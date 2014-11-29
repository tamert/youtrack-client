<?php

namespace YouTrack;

/**
 * A class describing a youtrack project.
 */
class Project extends Object
{
    public function getSubsystems()
    {
        return $this->youtrack->getSubsystems($this->id);
    }

    public function createSubsystem($name, $is_default, $default_assignee_login)
    {
        return $this->youtrack->createSubsystem($this->id, $name, $is_default, $default_assignee_login);
    }
}
