<?php
namespace YouTrack;

/**
 * A class describing a youtrack workitem.
 *
 * @property string id
 * @method string getId
 * @method void setId(string $value)
 *
 * @property int date
 * @method int getDate
 * @method void setDate(int $value)
 *
 * @property int duration
 * @method int getDuration
 * @method void setDuration(int $value)
 *
 * @property Worktype worktype
 * @method Worktype getWorktype
 * @method void setWorktype(string $value)
 *
 * @property string description
 * @method string getDescription
 * @method void setDescription(string $value)
 *
 * @property User author
 * @method User getAuthor
 * @method void setAuthor(int $value)
 *
 * @link https://www.jetbrains.com/help/youtrack/incloud/Get-Available-Work-Items-of-Issue.html
 */
class Workitem extends BaseObject
{

    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);

        if (isset($xml->date)) {
            $this->attributes['date'] = (int)((string)$xml->date / 1000);
        }

        if (isset($xml->author)) {
            $this->attributes['author'] = new User($xml->author, $youtrack);
        }

        if (isset($xml->worktype)) {
            $this->attributes['worktype'] = new Worktype($xml->worktype, $youtrack);
        }
    }

    protected function updateChildrenAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->children() as $nodeName => $node) {
            $this->attributes[$nodeName] = (string)$node;
        }
    }
}
