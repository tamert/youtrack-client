<?php
namespace YouTrack;

/**
 * A class describing a youtrack object.
 */
class Object
{
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
        if ($xml !== null) {
            $this->update($xml);
        }
    }

    protected function guessAttributeName($name)
    {
        $oName = $name;

        if (!empty($this->attributes[$name])) {
            return $name;
        }

        $name = lcfirst($name);
        if (!empty($this->attributes[$name])) {
            return $name;
        }
        $name = ucfirst($name);
        if (!empty($this->attributes[$name])) {
            return $name;
        }
        return $oName;
    }

    public function __get($name)
    {
        $name = $this->guessAttributeName($name);
        if (!empty($this->attributes["$name"])) {
            return $this->attributes["$name"];
        }
        return null;
    }

    public function __call($name, $args)
    {
        // Magic getter
        if (strlen($name) > 3 && substr($name, 0, 3) === 'get') {
            $name = $this->guessAttributeName(substr($name, 3));
            if (!empty($this->attributes[$name])) {
                return $this->attributes[$name];
            }
        }
        // Magic setter
        if (strlen($name) > 3 && substr($name, 0, 3) === 'set') {
            $name = $this->guessAttributeName(substr($name, 3));
            $this->attributes[$name] = $args[0];
        }
    }

    public function __set($name, $value)
    {
        $name = $this->guessAttributeName($name);
        $this->attributes["$name"] = $value;
    }

    protected function update($xml)
    {
        $this->updateAttributes($xml);
        $this->updateChildrenAttributes($xml);
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
            /** @var \SimpleXMLElement $node */
            foreach ($node->attributes() as $key => $value) {
                if ($key == 'name') {
                    $this->__set($value, (string)$node->value);
                } else {
                    $this->__set($key, (string)$value);
                }
            }
        }
    }
}
