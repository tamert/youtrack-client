<?php
namespace YouTrack;

/**
 * A class describing a youtrack link.
 */
class Link extends Object
{
    /**
     * Name of inward link for this link type
     *
     * @var string
     * @see setTypeInward
     * @see getTypeInward
     */
    protected $typeInward;

    /**
     * Name of outward link for this link type
     *
     * @var string
     * @see setTypeOutward
     * @see getTypeOutward
     */
    protected $typeOutward;

    /**
     * Name of a link type (please refer to Managing Issue Link Types page)
     *
     * @var string
     * @see setTypeName
     * @see getTypeName
     */
    protected $typeName;

    /**
     * Issue id of target issue
     *
     * @var string
     * @see setTarget
     * @see getTarget
     */
    protected $target;

    /**
     * Issue id of source issue
     *
     * @var string
     * @see setSource
     * @see getSource
     */
    protected $source;

    public function __construct(\SimpleXMLElement $xml = NULL, Connection $youtrack = NULL)
    {
        parent::__construct($xml, $youtrack);
    }

    /**
     * Returns the source
     *
     * @return mixed
     * @see setSource
     * @see $source
     */
    public function getSource()
    {
        return $this->__get('source');
    }

    /**
     * Sets the source
     *
     * @param mixed $source
     * @return Link
     * @see getSource
     * @see $source
     */
    public function setSource($source)
    {
        $this->__set('source', $source);
        return $this;
    }

    /**
     * Returns the target
     *
     * @return mixed
     * @see setTarget
     * @see $target
     */
    public function getTarget()
    {
        return $this->__get('target');
    }

    /**
     * Sets the target
     *
     * @param mixed $target
     * @return Link
     * @see getTarget
     * @see $target
     */
    public function setTarget($target)
    {
        $this->__set('target', $target);
        return $this;
    }

    /**
     * Returns the typeInward
     *
     * @return mixed
     * @see setTypeInward
     * @see $typeInward
     */
    public function getTypeInward()
    {
        return $this->__get('typeInward');
    }

    /**
     * Sets the typeInward
     *
     * @param mixed $typeInward
     * @return Link
     * @see getTypeInward
     * @see $typeInward
     */
    public function setTypeInward($typeInward)
    {
        $this->__set('typeInward', $typeInward);
        return $this;
    }

    /**
     * Returns the typeName
     *
     * @return mixed
     * @see setTypeName
     * @see $typeName
     */
    public function getTypeName()
    {
        return $this->__get('typeName');
    }

    /**
     * Sets the typeName
     *
     * @param mixed $typeName
     * @return Link
     * @see getTypeName
     * @see $typeName
     */
    public function setTypeName($typeName)
    {
        $this->__set('typeName', $typeName);
        return $this;
    }

    /**
     * Returns the typeOutward
     *
     * @return mixed
     * @see setTypeOutward
     * @see $typeOutward
     */
    public function getTypeOutward()
    {
        return $this->__get('typeOutward');
    }

    /**
     * Sets the typeOutward
     *
     * @param mixed $typeOutward
     * @return Link
     * @see getTypeOutward
     * @see $typeOutward
     */
    public function setTypeOutward($typeOutward)
    {
        $this->__set('typeOutward', $typeOutward);
        return $this;
    }
}
