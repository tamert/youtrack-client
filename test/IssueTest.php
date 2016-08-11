<?php
namespace YouTrack;
require_once("requirements.php");

/**
 * Unit test for the youtrack issue class.
 *
 * @author Jens Jahnke <jan0sch@gmx.net>
 * Created at: 08.04.11 13:55
 */
class IssueTest extends \PHPUnit_Framework_TestCase
{

    private $filename = "test/testdata/issue.xml";

    public function testConstruct01()
    {
        $xml = simplexml_load_file($this->filename);
        $issue = new Issue($xml);
        $this->assertEquals(3, count($issue->__get('links')));
    }

    public function testConstruct02()
    {
        $xml = simplexml_load_file($this->filename);
        $issue = new Issue($xml);
        $this->assertEquals(3, count($issue->__get('attachments')));
    }

    public function testIssueHasAssignee()
    {
        $xml = simplexml_load_file($this->filename);
        $issue = new Issue($xml);
        $this->assertTrue($issue->hasAssignee());
    }

    public function testGetIssueId()
    {
        $testIssueId = 'T-2';
        $xml = simplexml_load_file($this->filename);
        $issue = new Issue($xml);
        $this->assertEquals($testIssueId, $issue->getId());
    }
}
