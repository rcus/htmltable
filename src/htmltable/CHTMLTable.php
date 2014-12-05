<?php

namespace Rcus\HTMLTable;
use Mos\Database\CDatabaseBasic;

/**
 * Makes nice tables in HTML with pagination.
 *
 */
class CHTMLTable extends CDatabaseBasic
{

    /**
     * Members
     */
    private $tableColumns = array();    // select ...
    private $tableName = null;          // from ...
    private $orderBy = null;            // orderby ...
    private $order = " ASC";            // ...
    private $itemsPerPage = 10;         // limit ...
    private $startNo = 0;               // offset ...
    
    private $itemsPerPageOption = array(5, 10, 20);
    private $pagination = true;
    private $page = 1;
    private $itemsInTable = 0;


    /**
     * Constructor creating a PDO object connecting to a choosen database.
     *
     * @param array $options containing details for connecting to the database.
     *
     * @return void
     */
    public function __construct($options=[])
    {
        parent::__construct($options);
        parent::connect();
    }


    /**
     * Set all table options.
     *
     * @param string $name The name of the database table.
     * @param array $cols Array to choose which columns to display.
     * @param string $orderBy Set which column to order table.
     * @param string $order Order column asc (default) or desc.
     * @param boolean $pagination A boolean for set pagination on (default) or off.
     *
     * @return void
     */
    public function setTableOptions($name, $cols, $orderBy=null, $order='', $pagination=true)
    {
        $this->setTableName($name);
        $this->setTableColumns($cols);
        $this->setOrderBy($orderBy, $order);
        $this->setPaginationOn($pagination);
    }


    /**
     * Set active table in choosen database.
     *
     * @param string $name The name of the database table.
     *
     * @return void
     */
    public function setTableName($name)
    {
        $this->tableName = $name;
    }


    /**
     * Set columns from which data will be retrieved from.
     *
     * @param array $cols Array to choose which columns to display.
     *
     * @return void
     */
    public function setTableColumns($cols)
    {
        $this->tableColumns = $cols;
    }


    /**
     * Set column to order table.
     *
     * @param string $orderBy Set which column to order table.
     * @param string $order Order column asc (default) or desc.
     *
     * @return void
     */
    public function setOrderBy($orderBy, $order='')
    {
        $this->orderBy = $orderBy;
        $this->order = (strtolower($order) == 'desc') ? ' DESC' : ' ASC';
    }


    /**
     * Turn pagination on/off.
     *
     * @param boolean $pagination A boolean for set pagination on (default) or off.
     *
     * @return void
     */
    public function setPaginationOn($on=true)
    {
        $this->pagination = $on;
    }


    /**
     * Set members from _GET and number of rows in database.
     *
     * @return void
     */
    private function setMembers()
    {
        /**
         * For use without ANAX
         */
/*        global $app;
        $this->setOrderBy(htmlentities($app->request->getGet('orderby')), htmlentities($app->request->getGet('order')));
        $this->itemsPerPage = (is_numeric($app->request->getGet('items'))) ? $app->request->getGet('items') : null;
        if (is_numeric($app->request->getGet('page'))) {
            $this->page = $app->request->getGet('page');
            $this->startNo = ($this->page-1)*$this->itemsPerPage;
        }
*/
        /**
         * For use without ANAX
         */
        if (isset($_GET['orderby'])) {
            if (isset($_GET['order'])) {
                $this->setOrderBy(htmlentities($_GET['orderby']), htmlentities($_GET['order']));
            }
            else {
                $this->setOrderBy(htmlentities($_GET['orderby']));
            }
        }
        if (isset($_GET['items'])) {
            $this->itemsPerPage = (is_numeric($_GET['items'])) ? $_GET['items'] : null;
        }
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $this->page = $_GET['page'];
            $this->startNo = ($_GET['page']-1)*$this->itemsPerPage;
        }

        /**
         * And back together
         */
        $this->itemsInTable = $this->select("count(*) as items")
            ->from($this->tableName)
            ->executeFetchAll()[0]
            ->items;
    }


    /**
     * Call this method to get a HTMLtable.
     *
     * @return string Complete table in HTML.
     */
    public function getHTML()
    {
        $this->setMembers();
        $rows = $this->getRows();

        $html = "<div class='htmltable'>\n";
        if ($this->itemsInTable > 0) {
            $html .= $this->getItemOptions();
            $html .= " <table>\n  <tr>\n";
            foreach ($this->tableColumns as $key => $value) {
                $html .= "   <th>$key" . self::OrderLinks($value) . "</th>\n";
            }
            $html .= "  </tr>\n";
            foreach ($rows as $row) {
                $html .= "  <tr>\n";
                foreach ($row as $value) {
                    $html .= "   <td>$value</td>\n";
                }
                $html .= "  </tr>\n";
            }
            $html .= " </table>\n";
            $html .= $this->getPagination();
        } else {
            $html .= " <p>There is no items to view :(</p>\n";
        }
        $html .= "</div>\n";
        
        return $html;
    }


    /**
     * Get rows from the database to show in the table.
     *
     * @return array Rows to show in table.
     */
    private function getRows()
    {
        $this->select(implode(", ", $this->tableColumns))
            ->from($this->tableName);
        if ($this->orderBy) {
            $this->orderBy($this->orderBy.$this->order);
        }
        if ($this->pagination && $this->itemsPerPage && ($this->itemsInTable > $this->itemsPerPage)) {
            $this->limit($this->itemsPerPage)
                ->offset($this->startNo);
        }
        return $this->executeFetchAll();
    }


    /**
     * Will return item options for table.
     *
     * @return string The itemoptions part in HTML.
     */
    private function getItemOptions()
    {
        if (!$this->pagination) {
            return "";
        }
        $html = "<div class='itemsPerPage'>\n <p>Items per page: ";
        foreach ($this->itemsPerPageOption as $items) {
            $page = floor($this->startNo/$items+1);
            $page = ($page == 1) ? null : $page;
            $html .= "<a href='?" . http_build_query(array_merge($_GET, array("items"=>$items, "page"=>$page))) . "'>".$items."</a> ";
        }
        $html .= "<a href='?" . http_build_query(array_merge($_GET, array("items"=>"all", "page"=>null))) . "'>All items</a>";
        $html .= "</p>\n</div>\n";
        return $html;
    }


    /**
     * Will return pagination for table.
     *
     * @return string The pagination part in HTML.
     */
    private function getPagination()
    {
        if (!$this->pagination || !$this->itemsPerPage || ($this->itemsPerPage >= $this->itemsInTable)) {
            return "";
        }
        $lastPage = ceil($this->itemsInTable/$this->itemsPerPage);
        $prev2Page = ($this->page-2 >= 1) ? $this->page-2 : null ;
        $prevPage = ($this->page-1 >= 1) ? $this->page-1 : null ;
        $nextPage = ($this->page+1 <= $lastPage) ? $this->page+1 : null ;
        $next2Page = ($this->page+2 <= $lastPage) ? $this->page+2 : null ;

        $html = "<div class='pagination'>\n <p>";
        $html .= ($this->page != 1) ? "<a href='?".http_build_query(array_merge($_GET, array("page"=>null)))."'>&laquo;&laquo;</a> <a href='?".http_build_query(array_merge($_GET, array("page"=>($this->page-1))))."'>&laquo;</a> " : "";
        $html .= ($this->page-2 > 1) ? "... " : "";
        $html .= ($prev2Page) ? "<a href='?".http_build_query(array_merge($_GET, array("page"=>($prev2Page == 1 ? null : $prev2Page))))."'>$prev2Page</a> " : "";
        $html .= ($prevPage) ? "<a href='?".http_build_query(array_merge($_GET, array("page"=>($prevPage == 1 ? null : $prevPage))))."'>$prevPage</a> " : "";
        $html .= $this->page;
        $html .= ($nextPage) ? " <a href='?".http_build_query(array_merge($_GET, array("page"=>$nextPage)))."'>$nextPage</a>" : "";
        $html .= ($next2Page) ? " <a href='?".http_build_query(array_merge($_GET, array("page"=>$next2Page)))."'>$next2Page</a>" : "";
        $html .= ($this->page+2 < $lastPage) ? " ..." : "";
        $html .= ($this->page != $lastPage) ? " <a href='?".http_build_query(array_merge($_GET, array("page"=>($this->page+1))))."'>&raquo;</a> <a href='?".http_build_query(array_merge($_GET, array("page"=>$lastPage)))."'>&raquo;&raquo;</a>" : "";
        $html .= "</p>\n</div>\n";
        return $html;
    }


    /**
     * Function to create links for sorting
     *
     * @param string $column The name of the database column to sort by.
     *
     * @return string Links to order by column.
     */
    private function OrderLinks($column) {
        $asc = http_build_query(array_merge($_GET, array("orderby"=>$column, "order"=>null)));
        $desc = http_build_query(array_merge($_GET, array("orderby"=>$column, "order"=>"desc")));
        return " <span class='orderby'><a href='?$asc'>&uarr;</a><a href='?$desc'>&darr;</a></span>";
    }
}