<?php
namespace YouTrack;

/**
 * A class describing a youtrack project.
 */
class Project extends Object
{
    /**
     * @var Subsystem[]
     */
    protected $subsystems;

    /**
     * @var User[]
     */
    protected $assigneesUsers;

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

            $this->subsystems = array();
            foreach ($xml->subsystems->sub as $subsystemNode) {
                $system = new Subsystem(null, $youtrack);
                $system->__set('name', (string)$subsystemNode['value']);
                $this->subsystems[] = $system;
            }
        }

        if (isset($xml->assigneesLogin)) {
            $this->assigneesUsers = array();
            foreach ($xml->assigneesLogin->sub as $assigneesLogin) {
                $user = new User(null, $youtrack);
                $user->__set('login', (string)$assigneesLogin['value']);
                $this->assigneesUsers[] = $user;
            }
        }
    }

    /**
     * Returns the assigneesUsers
     *
     * @return User[]
     * @see setAssigneesUsers
     * @see $assigneesUsers
     */
    public function getAssigneesUsers()
    {
        return $this->assigneesUsers;
    }

    /**
     * Gets the subsystems of the projects
     *
     * @return array|Subsystem[]
     * @throws NotConnectedException
     */
    public function getSubsystems()
    {
        if (is_null($this->subsystems)) {
            if (is_null($this->youtrack)) {
                throw new NotConnectedException();
            }
            $this->subsystems = $this->youtrack->getSubsystems($this->getShortName());
        }
        return $this->subsystems;
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

    /**
     * Returns the shortName
     *
     * @return string
     * @see setShortName
     */
    public function getShortName()
    {
        return $this->__get('shortName');
    }

    /**
     * Returns the name
     *
     * @return string
     * @see setName
     */
    public function getName()
    {
        return $this->__get('name');
    }
}
