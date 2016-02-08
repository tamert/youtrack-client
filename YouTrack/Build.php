<?php
namespace YouTrack;

/**
 * A class describing a youtrack build.
 *
 * @todo add properties and methods docs
 */
class Build extends Object
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
    }
}
