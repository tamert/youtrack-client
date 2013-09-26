<?php
namespace YouTrack;
require_once("requirements.php");
/**
 * Unit test for the youtrack object class.
 *
 * @author Jens Jahnke <jan0sch@gmx.net>
 * Created at: 08.04.11 13:55
 */
class ObjectTest extends \PHPUnit_Framework_TestCase
{

    private $filename = "test/testdata/issue.xml";

  public function test___construct01() {
    $xml = simplexml_load_file($this->filename);
    $item = new Object($xml);
    $this->assertEquals('T', $item->__get('projectShortName'));
  }

  public function test___get01() {
    $item = new Object();
    $this->assertNull($item->__get('foo'));
  }

  public function test___get02() {
    $xml = simplexml_load_file($this->filename);
    $item = new Object($xml);
    $this->assertEquals('T-2', $item->__get('id'));
  }

  public function test___set01() {
    $item = new Object();
    $value = 'bar';
    $item->__set('foo', $value);
    $this->assertEquals($value, $item->__get('foo'));
  }
}
