<?php

namespace rcus\HTMLTable;
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
    }


    /**
     * Set active table in choosen database.
     *
     * @param string $name containing the name of the database table.
     *
     * @return void
     */
    public function setTableOptions($name, $cols, $orderBy=null, $order='')
    {
        $this->setTableName($name);
        $this->setTableColumns($cols);
        $this->setOrderBy($orderBy, $order);
    }


    /**
     * Set active table in choosen database.
     *
     * @param string $name containing the name of the database table.
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
     * @param array $cols containing the names of the columns in database table.
     *
     * @return void
     */
    public function setTableColumns($cols)
    {
        $this->tableColumns = $cols;
    }


    /**
     * Set columns from which data will be retrieved from.
     *
     * @param string $orderBy the column which the table will be ordered by.
     * @param string $order info for sort column asc (default) or desc.
     *
     * @return void
     */
    public function setOrderBy($orderBy, $order='')
    {
        $this->orderBy = $orderBy;
        $this->order = (strtolower($order) == 'desc') ? ' DESC' : ' ASC';
    }


    /**
     * Set columns from which data will be retrieved from.
     *
     * @param string $orderBy the column which the table will be ordered by.
     * @param string $order info for sort column asc or desc.
     *
     * @return string Complete table in HTML.
     */
    public function getHTML()
    {
        $this->setParams();
        $html = $this->getItemOptions();
        $html .= "<table>\n <tr>\n";
        foreach ($this->tableColumns as $key => $value) {
            $html .= "  <th>$key" . self::OrderLinks($value) . "</th>\n";
        }
        $html .= " </tr>\n";
        foreach ($this->getRows() as $row) {
            $html .= " <tr>\n";
            foreach ($row as $value) {
                $html .= "  <td>$value</td>\n";
            }
            $html .= " </tr>\n";
        }
        $html .= "</table>\n";
        $html .= $this->getPagination();
        return $html;
    }


    /**
     * Set columns from which data will be retrieved from.
     *
     * @param string $orderBy the column which the table will be ordered by.
     * @param string $order info for sort column asc or desc.
     *
     * @return array Rows to show in table.
     */
    private function setParams()
    {
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
        $this->itemsInTable = $this->select("count(*) as items")
            ->from($this->tableName)
            ->executeFetchAll()[0]
            ->items;
    }


    /**
     * Set columns from which data will be retrieved from.
     *
     * @param string $orderBy the column which the table will be ordered by.
     * @param string $order info for sort column asc or desc.
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
        if ($this->itemsPerPage && ($this->itemsInTable > $this->itemsPerPage)) {
            $this->limit($this->itemsPerPage)
                ->offset($this->startNo);
        }

        return $this->executeFetchAll();
    }


    private function getItemOptions()
    {
        $html = "<div class='itemsPerPage'>\n <p>Visa antal rader: ";
        foreach ($this->itemsPerPageOption as $items) {
            $page = floor($this->startNo/$items+1);
            $page = ($page == 1) ? null : $page;
            $html .= "<a href='?" . http_build_query(array_merge($_GET, array("items"=>$items, "page"=>$page))) . "'>".$items."</a> ";
        }
        $html .= "<a href='?" . http_build_query(array_merge($_GET, array("items"=>"all", "page"=>null))) . "'>Alla</a>";
        $html .= "</p>\n</div>\n";
        return $html;
    }


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
     * @param string $column the name of the database column to sort by
     * @return string with links to order by column.
     */
    private function OrderLinks($column) {
        $asc = http_build_query(array_merge($_GET, array("orderby"=>$column, "order"=>null)));
        $desc = http_build_query(array_merge($_GET, array("orderby"=>$column, "order"=>"desc")));
        return " <span class='orderby'><a href='?$asc'>&uarr;</a><a href='?$desc'>&darr;</a></span>";
    }

}