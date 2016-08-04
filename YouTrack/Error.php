<?php
namespace YouTrack;

/**
 * A class describing a youtrack error.
 */
class Error extends BaseObject
{
    /**
     * @param \SimpleXMLElement $xml
     * @param Connection $youtrack
     */
    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setJsonResponse(array $data)
    {
        if (isset($data['value']) && !isset($data['error'])) {
            $data['error'] = $data['value'];
            unset($data['value']);
        }
        $this->attributes = array_merge($this->attributes, $data);
        return $this;
    }

    /**
     * @param \SimpleXMLElement $xml
     */
    protected function updateAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->xpath('/error') as $node) {
            $this->attributes['error'] = (string) $node;
        }
    }
}
