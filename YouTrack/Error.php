<?php
namespace YouTrack;

/**
 * A class describing a youtrack error.
 */
class Error extends Object
{
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }

    protected function updateAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->xpath('/error') as $node) {
            $this->attributes['error'] = (string) $node;
        }
    }
}
