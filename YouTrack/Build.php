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
        $this->updateDateAttributes(
            [
                'assembleDate',
            ]
        );
    }

    /**
     * @return \DateTime
     */
    public function getAssembleDate()
    {
        return $this->assembleDate;
    }
}
