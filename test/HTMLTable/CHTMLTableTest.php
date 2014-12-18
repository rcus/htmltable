<?php

namespace Rcus\HTMLTable;

/**
 * Test HTMLtable
 *
 */
class CHTMLTableTest extends \PHPUnit_Framework_TestCase
{
    static private $table;
    // static private $di;

    /**
     * Set up database options
     *
     * @return void
     *
     */
    public static function setUpBeforeClass()
    {
        $options = array("dsn" => "sqlite::memory:");
        $table = new CHTMLTable($options);
        require __DIR__.'../../../webroot/includeCreateTableData.php';
        self::$table = $table;
    }

    /**
     * Test create HTMLTable object
     */
    public function testCreateCHTMLTableObject()
    {
        $this->assertInstanceOf('\Rcus\HTMLTable\CHTMLTable', self::$table, 'There is no CHTMLTable object.');
        $this->assertInstanceOf('\Mos\Database\CDatabaseBasic', self::$table, 'The object is not an instance of CDatabaseBasic');
    }

    /**
     * Test setTableOptions()
     *
     * @depends testCreateCHTMLTableObject
     */
    public function testSetTableOptions()
    {
        self::$table->setTableOptions('test', array(
            'ID'         => 'id',
            'Förnamn'    => 'firstname',
            'Efternamn'  => 'surname',
            'Födelsedag' => 'birthdate')
        );
        $this->assertObjectHasAttribute('tableName', self::$table);
    }

    /**
     * Test getHTML()
     *
     * @depends testSetTableOptions
     */
    public function testGetHTML()
    {
        // Response as array
        $returnArray = array(
            'orderby' => "id",
            'order' => "desc",
            'items' => 8,
            'page' => 2
            );

        // For test without use of Anax
        $_GET = $returnArray;

        // Create a mock for $di->request->getGet()
        $di = $this->getMockBuilder('\stdClass')
            ->getMock();

        $di->request = $this->getMockBuilder('\stdClass')
            ->getMock();

        $di->request->expects($this->any())
            ->method('getGet')
            ->will($this->returnValue($returnArray));

        $act = self::$table->getHTML();
        $this->assertInternalType('string', $act, 'getHTML() does not return string.');
    }

}
