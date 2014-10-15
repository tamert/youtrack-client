<?php
namespace YouTrack;

/**
 * A class describing a YouTrack attachment.
 */
class Attachment extends Object
{
    /**
     * The attachment id
     *
     * @var string
     */
    protected $id;

    /**
     * The url to the real file content
     * @var string
     */
    protected $url;


    /**
     * The filename
     *
     * @var string
     */
    protected $name;


    /**
     * The username who has uploaded this attachment
     *
     * @var string
     */
    protected $authorLogin;


    /**
     * The group who has access rights
     *
     * @var string
     */
    protected $group;


    /**
     * The upload date
     *
     * @var \DateTime
     * @see setCreated
     * @see getCreated
     */
    protected $created;


    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);

        $methods = get_class_methods($this);

        if ($xml) {
            foreach ($xml->attributes() as $key => $value) {
                $method = 'set' . ucfirst($key);

                if (in_array($method, $methods)) {
                    $this->$method((string)$value);
                }
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
     * Sets the authorLogin
     *
     * @param string $authorLogin
     * @return Attachment
     * @see getAuthorLogin
     * @see $authorLogin
     */
    public function setAuthorLogin($authorLogin)
    {
        $this->authorLogin = $authorLogin;
        return $this;
    }


    /**
     * Returns the authorLogin
     *
     * @return string
     * @see setAuthorLogin
     * @see $authorLogin
     */
    public function getAuthorLogin()
    {
        return $this->authorLogin;
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
                $ts = (int)(((int)$created) / 1000);
                $tmp = new \DateTime('@' . $ts);
            } catch (\Exception $e) {

                // we could throw it... but.
            }
            if ($tmp) {
                $created = $tmp;
            }
        }
        $this->created = $created;
        return $this;
    }


    /**
     * Returns the created
     *
     * @return \DateTime
     * @see setCreated
     * @see $created
     */
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Sets the group
     *
     * @param string $group
     * @return Attachment
     * @see getGroup
     * @see $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }


    /**
     * Returns the group
     *
     * @return string
     * @see setGroup
     * @see $group
     */
    public function getGroup()
    {
        return $this->group;
    }


    /**
     * Sets the id
     *
     * @param string $id
     * @return Attachment
     * @see getId
     * @see $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Returns the id
     *
     * @return string
     * @see setId
     * @see $id
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return Attachment
     * @see getName
     * @see $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Returns the name
     *
     * @return string
     * @see setName
     * @see $name
     */
    public function getName()
    {
        return $this->name;
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
        $this->url = $url;
        return $this;
    }


    /**
     * Returns the url
     *
     * @return string
     * @see setUrl
     * @see $url
     */
    public function getUrl()
    {
        return $this->url;
    }
}
