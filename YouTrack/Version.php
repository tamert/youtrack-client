<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nepda
 * Date: 24.03.13
 * Time: 14:51
 * To change this template use File | Settings | File Templates.
 */
namespace YouTrack;

/**
 * A class describing a youtrack version.
 */
class Version extends BaseObject
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
        $check = $this->__get('description');
        if (empty($check)) {
            $this->__set('description', '');
        }
        $check = $this->__get('releaseDate');
        if (empty($check)) {
            $this->__set('releaseDate', null);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->__get('name');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->__get('description');
    }

    /**
     * @return int|null
     */
    public function getReleaseDate()
    {
        if ($this->__get('releaseDate') === null) {
            return null;
        }

        return (int)$this->__get('releaseDate');
    }

    /**
     * @return bool
     */
    public function isReleased()
    {
        return $this->__get('isReleased') === 'true';
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->__get('isArchived') === 'true';
    }
}
