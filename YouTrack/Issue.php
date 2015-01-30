<?php
namespace YouTrack;

/**
 * A class describing a youtrack issue.
 */
class Issue extends Object
{
    private $links = array();
    private $attachments = array();
    private $comments = array();

    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        //bug
        parent::__construct($xml, $youtrack);
        if ($xml) {
            if (!empty($this->attributes['links'])) {
                $links = array();
                foreach($xml->xpath('//field[@name="links"]') as $node) {
                    foreach($node->children() as $link) {
                        $links[(string)$link] = array(
                            'type' => (string)$link->attributes()->type,
                            'role' => (string)$link->attributes()->role,
                        );
                    }
                }
                $this->__set('links', $links);
            }
            if (!empty($this->attributes['attachments'])) {
                $attachments = array();
                foreach($xml->xpath('//field[@name="attachments"]') as $node) {
                    foreach($node->children() as $attachment) {
                        $attachments[(string)$attachment] = array(
                            'url' => (string)$attachment->attributes()->url,
                        );
                    }
                }
                $this->__set('attachments', $attachments);
            }
        }
    }

    /**
     * Returns the Issue Id (if it is already created or fetched)
     * @return string
     */
    public function getId()
    {
        return $this->__get('id');
    }

    /**
     * @return User
     */
    public function getReporter()
    {
        return $this->youtrack->getUser($this->__get('reporterName'));
    }

    /**
     * @return bool
     */
    public function hasAssignee()
    {
        $name = $this->__get('assigneeName');
        return !empty($name);
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->youtrack->getUser($this->__get('assigneeName'));
    }

    /**
     * @return User
     */
    public function getUpdater()
    {
        return $this->youtrack->getUser($this->__get('updaterName'));
    }

    /**
     * @return array|Comment[]
     */
    public function getComments()
    {
        if (empty($this->comments)) {
            $this->comments = $this->youtrack->getComments($this->__get('id'));
        }
        return $this->comments;
    }

    /**
     * @return array|Attachment[]
     */
    public function getAttachments()
    {
        if (empty($this->attachments)) {
            $this->attachments = $this->youtrack->getAttachments($this->__get('id'));
        }
        return $this->attachments;
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        if (empty($this->links)) {
            $this->links = $this->youtrack->getLinks($this->__get('id'));
        }
        return $this->links;
    }
}
