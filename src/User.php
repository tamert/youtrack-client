<?php
namespace YouTrack;


/**
 * A class describing a youtrack user.
 * @todo Add methods for hashing and comparison.
 */
class User extends YouTrackObject {
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL) {
        parent::__construct($xml, $youtrack);
    }
}
