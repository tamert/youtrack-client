<?php
namespace YouTrack;

/**
 * Class NotConnectedException
 *
 * @package YouTrack
 */
class NotConnectedException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        if (empty($message)) {
            $message = 'The current YouTrack object has no connection to the server.';
        }
        parent::__construct($message, $code, $previous);
    }
}
