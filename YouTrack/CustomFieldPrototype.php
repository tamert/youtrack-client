<?php
namespace YouTrack;

/**
 * A class describing a youtrack custom field.
 *
 * @property string name
 * @method string getName
 * @method string setName(string $value)
 * @property string type
 * @method string getType
 * @method string setType(string $value)
 * @property string isPrivate
 * @method string getIsPrivate
 * @method string setIsPrivate(string $value)
 * @property string isVisible
 * @method string getIsVisible
 * @method string setIsVisible(string $value)
 * @property string autoAttached
 * @method string getAutoAttached
 * @method string setAutoAttached(string $value)
 * @property string defaultParam
 * @method string getDefaultParam
 * @method string setDefaultParam(string $value)
 *
 * @link https://www.jetbrains.com/help/youtrack/incloud/GET-Prototype.html
 */
class CustomFieldPrototype extends BaseObject
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
    }
}
