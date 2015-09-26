<?php
namespace YouTrack;

/**
 * A class describing a youtrack workitem.
 */
class Workitem extends Object
{

    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);

        if (isset($xml->date)) {
            $this->date = intval((string)$xml->date / 1000);
        }

        if (isset($xml->author)) {
            $this->author = new User(null, $youtrack);
            $this->author->__set('login', (string)$xml->author);
        }
    }

    protected function updateChildrenAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->children() as $nodeName => $node) {
            $this->attributes[$nodeName] = (string)$node;
        }
    }
}
