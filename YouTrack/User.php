<?php
namespace YouTrack;

/**
 * A class describing a youtrack user.
 */
class User extends Object
{
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }
}
