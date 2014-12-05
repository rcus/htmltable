<?php

namespace Rcus\HTMLTable;
// use Anax\DI\IInjectionAware;

/**
 * Test HTMLtable
 *
 */
class CHTMLTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up database options
     *
     * @return void
     *
     */
    public function setUp()
    {
        // global $options;
        $options = array(
            'dsn'     => "sqlite::memory:",
            'verbose' => false
            );
        $table = new CHTMLTable($options);
        require __DIR__.'../../../webroot/includeCreateTableData.php';
        $this->table = $table;
    }

    /**
     * Test create HTMLTable object
     */
    public function testCreateCHTMLTableObject()
    {
        $this->assertInstanceOf('\Rcus\HTMLTable\CHTMLTable', $this->table, 'There is no HTMLTable object.');
        self::assertInstanceOf('\Mos\Database\CDatabaseBasic', $this->table);
    }

    /**
     * Test setTableOptions()
     *
     * @depends testCreateCHTMLTableObject
     */
    public function testSetTableOptions()
    {
        $this->table->setTableOptions('test', array(
            'ID'         => 'id',
            'Förnamn'    => 'firstname',
            'Efternamn'  => 'surname',
            'Födelsedag' => 'birthdate')
        );
        $this->assertObjectHasAttribute('tableName', $this->table);
    }

    /**
     * Test getHTML()
     *
     * @depends testSetTableOptions
     */
    public function testGetHTML()
    {
        // Create a mock for $app->request->getGet()
        $app = $this->getMockBuilder('stdClass')
            // ->setMethods(array('getGet'))
            ->getMock();

        $app->request = $this->getMockBuilder('stdClass')
            ->setMethods(array('getGet'))
            ->getMock();

        $app->request->expects($this->any())
            ->method('getGet')
            ->will($this->returnValue(array(
                'orderby' => "id",
                'order' => "desc",
                'items' => 8,
                'page' => 2
            )));

        $_GET = array(
            'orderby' => "id",
            'order' => "desc",
            'items' => 8,
            'page' => 2
            );

        $act = $this->table->getHTML();
        $this->assertInternalType('string', $act, 'getHTML() does not return string.');
    }

}
