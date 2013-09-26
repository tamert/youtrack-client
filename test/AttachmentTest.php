<?php
namespace YouTrack;
require_once("requirements.php");

/**
 * Unit test for the youtrack attachment class.
 *
 * @author Nepomuk Fraedrich <info@nepda.eu>
 */
class AttachmentsTest extends \PHPUnit_Framework_TestCase
{

    private $singleAttachmentFile = 'test/testdata/attachment.xml';

    public function testCanCreateSimpleAttachment()
    {
        try {
            $attachment = new Attachment();
        } catch (\Exception $e) {
            $this->fail();
        }
        $this->assertInstanceOf('\\YouTrack\\Attachment', $attachment);
    }

    public function testCanCreateAttachmentFromResponse()
    {
        $xml = simplexml_load_file($this->singleAttachmentFile);
        $xml = $xml->children()[0];
        try {
            $attachment = new Attachment($xml);
        } catch (\Exception $e) {
            $this->fail();
        }
        $this->assertInstanceOf('\\YouTrack\\Attachment', $attachment);
    }

    private function createAttachment()
    {
        $xml = simplexml_load_file($this->singleAttachmentFile);
        $xml = $xml->children()[0];
        return $attachment = new Attachment($xml);
    }

    public function testUrlIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        $this->assertEquals('http://example.com/file.abc', $attachment->getUrl());
    }

    public function testIdIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        $this->assertEquals('62-180', $attachment->getId());
    }

    public function testNameIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        $this->assertEquals('attachment.txt', $attachment->getName());
    }

    public function testAuthorLoginIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        $this->assertEquals('root', $attachment->getAuthorLogin());
    }

    public function testGroupIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        $this->assertEquals('All Users', $attachment->getGroup());
    }

    public function testCreatedIsSetAfterXmlLoad()
    {
        $attachment = $this->createAttachment();
        //26.09.13 16:05:32
        $this->assertInstanceOf('\\DateTime', $attachment->getCreated());
        $this->assertEquals('2013-09-26 16:05:32', $attachment->getCreated()->format('Y-m-d H:i:s'));
    }
}
