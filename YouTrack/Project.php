<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nepda
 * Date: 24.03.13
 * Time: 14:50
 * To change this template use File | Settings | File Templates.
 */
namespace YouTrack;

/**
 * A class describing a youtrack project.
 */
class Project extends Object
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
    }

    public function getSubsystems()
    {
        return $this->youtrack->getSubsystems($this->id);
    }

    public function createSubsystem($name, $is_default, $default_assignee_login)
    {
        return $this->youtrack->createSubsystem($this->id, $name, $is_default, $default_assignee_login);
    }
}