<?php
namespace YouTrack;

/**
 * A class describing a youtrack custom field.
 */
class CustomField extends Object
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
    }
}
