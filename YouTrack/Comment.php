<?php
namespace YouTrack;


/**
 * A class describing a youtrack comment.
 *
 * @property string id
 * @method string getId
 * @method string setId(string $value)
 * @property string author
 * @method string setAuthor(string $value)
 * @property string issueId
 * @method string getIssueId
 * @method string setIssueId(string $value)
 * @property bool deleted
 * @method bool getDeleted
 * @method bool setDeleted(bool $value)
 * @property string jiraId
 * @method string getJiraId
 * @method string setJiraId(string $value)
 * @property string text
 * @method string getText
 * @method string setText(string $value)
 * @property int created
 * @method int getCreated
 * @method int setCreated(int $value)
 * @property int updated
 * @method int getUpdated
 * @method int setUpdated(int $value)
 *
 * @link https://confluence.jetbrains.com/display/YTD65/Get+Comments+of+an+Issue
 */
class Comment extends Object
{
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }

    public function getAuthor()
    {
        return $this->youtrack->getUser($this->__get('author'));
    }
}
