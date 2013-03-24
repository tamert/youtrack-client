<?php
namespace YouTrack;


/**
 * A class describing a YouTrack attachment.
 */
class Attachment extends Object {
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL) {
        parent::__construct($xml, $youtrack);
    }

    public function getContent() {
        return $this->youtrack->getAttachmentContent($this->__get('url'));
    }
}
