<?php
namespace YouTrack;

/**
 * A class describing a youtrack role.
 */
class Role extends Object
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ProjectRef[]
     */
    protected $projectRefs = array();

    /**
     * This extra constructor will build the project references for the role (if present)
     *
     * @param \SimpleXMLElement $xml
     * @param Connection $youtrack
     */
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
        if ($xml) {
            if (isset($xml->projects) && count((array)$xml->projects) > 0) {
                foreach ($xml->projects as $projectRef) {
                    $this->projectRefs[] = new ProjectRef($projectRef, $youtrack);
                }
            }
        }
    }

    /**
     * @return ProjectRef[]
     */
    public function getProjectRefs()
    {
        return $this->projectRefs;
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
        return $this->__get('name');
    }
}
