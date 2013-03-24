<?php
namespace YouTrack;



/**
 * A class describing a youtrack link.
 */
class Link extends YouTrackObject {
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL) {
        parent::__construct($xml, $youtrack);
    }
}