<?php
namespace YouTrack;


/**
 * A class describing a youtrack comment.
 */
class Comment extends YouTrackObject {
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL) {
        parent::__construct($xml, $youtrack);
    }

    public function getAuthor() {
        return $this->youtrack->getUser($this->__get('author'));
    }
}