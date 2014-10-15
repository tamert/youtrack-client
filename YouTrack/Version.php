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
class Version extends Object
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
}