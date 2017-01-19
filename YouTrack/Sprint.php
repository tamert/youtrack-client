<?php
namespace YouTrack;

/**
 * A class describing a youtrack agile board setting.
 *
 * @property string name
 * @method string getName
 * @method string getVersion
 * @method string setName(string $value)
 *
 * @link https://confluence.jetbrains.com/display/YTD65/Get+List+of+Agile+Boards
 */
class Sprint extends BaseObject
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
        if ($xml) {
            foreach ($xml->children() as $child) {
                $this->__set($child->getName(), (string)$child);
            }
        }
    }
}
