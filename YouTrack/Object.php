<?php
namespace YouTrack;

/**
 * A class describing a youtrack object.
 */
class Object {

    /**
     * @var null|Connection
     */
    protected $youtrack = null;

    /**
     * @var array
     */
    protected $attributes = array();

    public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null)
    {
        $this->youtrack = $youtrack;
        if ($xml) {
            $this->updateAttributes($xml);
            $this->updateChildrenAttributes($xml);
        }
    }

    public function __get($name)
    {
        if (!empty($this->attributes["$name"])) {
            return $this->attributes["$name"];
        }
        return null;
    }

    public function __call($name, $args)
    {
        // Magic getter
        if (substr($name, 0, 3) === 'get' && strlen($name) > 3) {
            $name = strtolower($name{3}) . substr($name, 4);
            if (!empty($this->attributes[$name])) {
                return $this->attributes[$name];
            }
        }
        // Magic setter
        if (substr($name, 0, 3) === 'set' && strlen($name) > 3) {
            $name = strtolower($name{3}) . substr($name, 4);
            $this->attributes[$name] = $args[0];
        }
    }

    public function __set($name, $value)
    {
        $this->attributes["$name"] = $value;
    }

    protected function updateAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->attributes() as $k => $v) {
            $this->attributes[$k] = (string)$v;
        }
        foreach ($xml->xpath('/*') as $node) {
            foreach ($node->attributes() as $key => $value) {
                $this->attributes["$key"] = (string)$value;
            }
        }
    }

    protected function updateChildrenAttributes(\SimpleXMLElement $xml)
    {
        foreach ($xml->children() as $node) {
            foreach ($node->attributes() as $key => $value) {
                if ($key == 'name') {
                    $this->__set($value, (string)$node->value);
                }
                else {
                    $this->__set($key, (string)$value);
                }
            }
        }
    }
}
