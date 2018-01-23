<?php
namespace YouTrack;

/**
 * A class describing a youtrack role.
 *
 * @property string name
 * @method string getName
 * @method string setName(string $value)
 * @property string description
 * @method string getDescription
 * @method string setDescription(string $value)
 * @property string permissionsUrl
 * @method string getPermissionsUrl
 * @method string setPermissionsUrl(string $value)
 *
 * @link https://www.jetbrains.com/help/youtrack/incloud/GET-Role.html
 */
class Role extends BaseObject
{
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
}
