<?php
namespace YouTrack;
require_once("requirements.php");
/**
 * Unit test for the youtrack workitem class.
 *
 * @author Sergey Susikov <sergey.susikov@gmail.com>
 */
class WorkitemTest extends \PHPUnit_Framework_TestCase
{

    private $filename = "test/testdata/workitem.xml";

    public function test___construct01()
    {
        $items = $this->_loadWorkitems();
        $this->assertEquals(2, count($items));
    }

    public function testWorkItemAuthorIsUser()
    {
        $items = $this->_loadWorkitems();
        $this->assertTrue($items[0]->author instanceof User);
    }

    public function testWorkitemGetDescription()
    {
        $items = $this->_loadWorkitems();
        $this->assertEquals('first work item', $items[0]->description);
    }

    /**
     * @return array
     */
    private function _loadWorkitems()
    {
        $items = array();
        $xml = simplexml_load_file($this->filename);
        foreach ($xml->children() as $node) {
            $items[] = new Workitem($node, null);
        }
        return $items;
    }
}
