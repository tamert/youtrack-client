<?php
namespace YouTrack;

/**
 * A class describing a YouTrack attachment.
 *
 * @property string url
 * @method string getUrl
 * @property string name
 * @method string getName
 * @method string setName(string $value)
 * @property string group
 * @method string getGroup
 * @method string setGroup(string $value)
 * @property string created
 * @method string getCreated
 *
 * @link https://confluence.jetbrains.com/display/YTD65/Get+Attachments+of+an+Issue
 */
class Attachment extends Object
{
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);

        if ($xml) {
            foreach ($xml->attributes() as $key => $value) {
                $method = 'set' . ucfirst($key);

                $this->$method((string)$value);
            }
        }
    }


    /**
     * Fetches the file content from this attachment
     *
     * If the connection object is not available, it will return false
     *
     * @return string|bool
     */
    public function fetchContent()
    {
        if ($this->youtrack) {
            return $this->youtrack->getAttachmentContent($this->getUrl());
        } else {
            return false;
        }
    }

    /**
     * Sets the created
     *
     * @param \DateTime $created
     * @return Attachment
     * @see getCreated
     * @see $created
     */
    public function setCreated($created)
    {
        if (!$created instanceof \DateTime) {
            $tmp = false;
            try {
                // The API returns the timestamp in milliseconds
                // @see http://confluence.jetbrains.com/display/YTD4/Timestamps+in+REST+API
                $ts = substr($created, 0, -3); // do not divide by 1000 (small integer php settings cause wrong ints)
                $tmp = new \DateTime('@' . $ts);
            } catch (\Exception $e) {

                // we could throw it... but.
            }
            if ($tmp) {
                $created = $tmp;
            }
        }
        $this->attributes['created'] = $created;
        return $this;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return Attachment
     * @see getUrl
     * @see $url
     */
    public function setUrl($url)
    {
        // The API will always return http instead of https
        //
        // Is this a bug from YouTrack?
        // Reported: http://youtrack.jetbrains.com/issue/JT-21987
        //
        // So we fix this, by checking, if the connection is via HTTPS and if so
        // the protocol will be changed from http to https
        if (is_string($url) && $this->youtrack) {
            if (substr($url, 0, strlen('https')) != 'https') {
                if ($this->youtrack->isHttps()) {

                    $url = 'https' . substr($url, strlen('https')-1);
                }
            }
        }
        $this->attributes['url'] = $url;
        return $this;
    }
}
