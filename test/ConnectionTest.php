<?php
namespace YouTrack;
require_once("requirements.php");
require_once("testconnection.php");

/**
 * Unit test for the connection class.
 *
 * @author Jens Jahnke <jan0sch@gmx.net>
 * Created at: 31.03.11 12:35
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateConnection() {
        $con = new TestConnection();
    }
}
