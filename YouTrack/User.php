<?php
namespace YouTrack;

/**
 * A class describing a youtrack user.
 */
class User extends Object
{
    /**
     * @return null|string
     */
    public function getLogin()
    {
        return $this->__get('login');
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->__get('url');
    }
}
