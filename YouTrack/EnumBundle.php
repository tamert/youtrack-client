<?php
namespace YouTrack;

/**
 *
 * @author Jens Jahnke <jan0sch@gmx.net>
 * @author Nepomuk Frädrich <info@nepda.eu>
 * Created at: 29.03.11 16:29
 */


class EnumBundle extends Object {
  private $name = '';
  private $values = array();

  public function __construct(\SimpleXMLElement $xml = null, Connection $youtrack = null) {
    parent::__construct($xml, $youtrack);
  }

  protected function updateAttributes(\SimpleXMLElement $xml) {
    $this->name = (string)$xml->attributes()->name;
  }

  protected function updateChildrenAttributes(\SimpleXMLElement $xml) {
    foreach ($xml->children() as $node) {
      $this->values[] = (string)$node;
    }
  }

  public function toXML() {
    $xml = '<enumeration name="'. $this->name .'">';
    foreach ($this->values as $v) {
      $xml .= '<value>'. $v .'</value>';
    }
    $xml .= '</enumeration>';

    return $xml;
  }

  public function getValues() {
    return $this->values;
  }
}
