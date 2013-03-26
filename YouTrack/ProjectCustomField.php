<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nepda
 * Date: 24.03.13
 * Time: 14:52
 * To change this template use File | Settings | File Templates.
 */
namespace YouTrack;

/**
 * A class describing a youtrack project custom field.
 */
class ProjectCustomField extends Object
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
    }

    protected function updateChildrenAttributes(\SimpleXMLElement $xml)
    {
        throw new NotImplementedException("_update_children_attributes(xml)");
    }
}