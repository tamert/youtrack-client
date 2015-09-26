<?php
namespace YouTrack;

/**
 * A class describing a youtrack project.
 *
 * @property string name
 * @method string getName
 * @method string setName(string $value)
 * @property string id
 * @method string getId
 * @method string setId(string $value)
 * @property string lead
 * @method string getLead
 * @method string setLead(string $value)
 * @property string description
 * @method string getDescription
 * @method string setDescription(string $value)
 *
 * @link https://confluence.jetbrains.com/display/YTD65/GET+Project
 */
class Project extends Object
{
    /**
     * This extra constructor sets subsystems, if they are present in the response
     *
     * @param \SimpleXMLElement $xml
     * @param Connection $youtrack
     */
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);

        if (isset($xml->subsystems)) {

            $this->attributes['subsystems'] = array();
            foreach ($xml->subsystems->sub as $subsystemNode) {
                $system = new Subsystem(null, $youtrack);
                $system->__set('name', (string)$subsystemNode['value']);
                $this->attributes['subsystems'][] = $system;
            }
        }

        if (isset($xml->assigneesLogin)) {
            $this->attributes['assigneesUsers'] = array();
            foreach ($xml->assigneesLogin->sub as $assigneesLogin) {
                $user = new User(null, $youtrack);
                $user->__set('login', (string)$assigneesLogin['value']);
                $this->attributes['assigneesUsers'][] = $user;
            }
        }
    }

    /**
     * Gets the subsystems of the projects
     *
     * @return array|Subsystem[]
     * @throws NotConnectedException
     */
    public function getSubsystems()
    {
        if (is_null($this->attributes['subsystems'])) {
            if (is_null($this->youtrack)) {
                throw new NotConnectedException();
            }
            $this->attributes['subsystems'] = $this->youtrack->getSubsystems($this->getShortName());
        }
        return $this->attributes['subsystems'];
    }

    /**
     * @param string $name
     * @param $is_default
     * @param $default_assignee_login
     * @return string
     * @throws NotConnectedException
     */
    public function createSubsystem($name, $is_default, $default_assignee_login)
    {
        if (is_null($this->youtrack)) {
            throw new NotConnectedException();
        }
        return $this->youtrack->createSubsystem($this->getShortName(), $name, $is_default, $default_assignee_login);
    }
}
