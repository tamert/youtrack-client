<?php
namespace YouTrack;

/**
 * A class describing a youtrack group.
 */
class Group extends BaseObject
{
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }
}
