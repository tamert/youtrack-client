<?php
namespace YouTrack;

/**
 * A class describing the work type for a youtrack workitem.
 *
 * @property string id
 * @method string getId
 * @method void setId(string $value)
 *
 * @property string name
 * @method string getName
 * @method void setName(string $value)
 *
 * @property bool autoAttached
 * @method bool isAutoAttached
 * @method void setAutoAttached(bool $value)
 */
class Worktype extends BaseObject
{

    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);

        if (isset($xml->autoAttached)) {
            $this->attributes['autoAttached'] = (string)$xml->autoAttached == 'true';
        }
    }

    protected function updateChildrenAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->children() as $nodeName => $node) {
            $this->attributes[$nodeName] = (string)$node;
        }
    }
}
