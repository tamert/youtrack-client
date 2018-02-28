<?php
namespace YouTrack;

/**
 * A class describing a youtrack agile board setting.
 *
 * @property string name
 * @method string getName
 * @method string setName(string $value)
 *
 * @link https://www.jetbrains.com/help/youtrack/incloud/Get-List-of-Agile-Boards.html
 */
class AgileSetting extends BaseObject
{
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct($xml, $youtrack);
        if (isset($xml->projects)) {
            $projects = [];
            foreach ($xml->projects->project as $test) {
                /** @var \SimpleXMLElement $test */
                $projects[] = new Project(new \SimpleXMLElement($test->asXML()), $youtrack);
            }
            $this->attributes['projects'] = $projects;
        }
        if (isset($xml->sprints)) {
            $sprints = [];
            foreach ($xml->sprints->sprint as $sprint) {
                /** @var \SimpleXMLElement $sprint */
                $sprints[] = new Sprint(new \SimpleXMLElement($sprint->asXML()), $youtrack);
            }
            $this->attributes['sprints'] = $sprints;
        }
    }
}
