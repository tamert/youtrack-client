<?php
namespace YouTrack;

/**
 * A class describing a youtrack build.
 */
class Build extends BundleElement
{
    /** @var \DateTime */
    private $assembleDate;

    /**
     * @param \SimpleXMLElement|null $xml
     * @param Connection|null $youtrack
     */
    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        parent::__construct('build', $xml, $youtrack);
    }

    protected function update($xml)
    {
        parent::update($xml);
        // todo what timezone is this in? it's not documented.
        $millis = (int)$xml['assembleDate'];
        $this->assembleDate = new \DateTime('@'.round($millis / 1000));
    }

    /**
     * @return \DateTime
     */
    public function getAssembleDate()
    {
        return $this->assembleDate;
    }
}
