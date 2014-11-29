<?php

namespace YouTrack;

/**
 * Class ProjectRef
 *
 * @package YouTrack
 */
class ProjectRef extends Object
{
    /**
     * @return string
     */
    public function getId()
    {
        return $this->__get('id');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->__get('url');
    }
}
