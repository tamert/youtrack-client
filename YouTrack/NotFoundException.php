<?php
namespace YouTrack;

/**
 * Class NotFoundException
 *
 * @package YouTrack
 */
class NotFoundException extends Exception
{
    protected $code = 404;
}
