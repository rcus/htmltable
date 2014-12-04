<?php

// namespace Rcus\HTMLTable;
use Anax\DI\IInjectionAware;

/**
 * HTML Form elements.
 *
 */
class CHTMLTableTest extends \PHPUnit_Framework_TestCase
{
    protected $options;


    /**
     * Set up database options
     *
     * @return void
     *
     */
    protected function setUp()
    {
        global $options;
        $this->options = $options;
    }



    /**
     * Test create HTMLTable object
     *
     * @return object $obj The HTMLTable object
     *
     */
    public function testCreateCHTMLTableObject()
    {
        $obj = new \Rcus\HTMLTable\CHTMLTable($this->options);
        $this->assertInstanceOf('\Rcus\HTMLTable\CHTMLTable', $obj, 'There is no HTMLTable object.');
        self::assertInstanceOf('\Mos\Database\CDatabaseBasic', $obj);

        return $obj;
    }



    /**
     * Test setTableOptions()
     *
     * @depends testCreateCHTMLTableObject
     *
     * @param object $obj The HTMLTable object from testCreateCHTMLTableObject()
     * @return object $obj The HTMLTable object
     *
     */
    public function testSetTableOptions($obj)
    {
        $obj->setTableOptions('test', array(
            'ID'         => 'id',
            'Förnamn'    => 'firstname',
            'Efternamn'  => 'surname',
            'Födelsedag' => 'birthdate')
        );
        $this->assertObjectHasAttribute('tableName', $obj);
        return $obj;
    }



    /**
     * Test getHTML()
     *
     * @depends testSetTableOptions
     *
     * @param object $obj The HTMLTable object from testCreateCHTMLTableObject()
     * @return void
     *
     */
    public function testGetHTML($obj)
    {
        // Create a mock for $app->request->getGet()
        /*$app->request = $this->getMockBuilder('CRequestBasic')
            ->disableOriginalConstructor()
            ->setMethods(array('getGet'))
            ->getMock();

        $app->expects($this->any())
            ->method('getGet')
            ->will($this->returnValue(array(
                'orderby' => "id",
                'order' => "desc",
                'items' => 8,
                'page' => 2
            )));
*/        
        $act = $obj->getHTML();
        $this->assertInternalType('string', $act, 'getHTML() does not return string.');


    }

}
