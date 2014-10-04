<?php
class GeneticAlgorithmDAO extends AbstractDAO
{
  private static $entity = 'GeneticAlgorithm';
  private static $entityKey = 'geneticAlgorithm_oid';

  public function __constructor()
  {
    parent::__constructor();
  }

  public function loadById($id)
  {
    return parent::loadInstance(self::$entity, array(array(self::$entityKey, $id)));
  }

  public function persist()
  {
    return parent::persistInstance(self::$entity, self::$entityKey);
  }

  public function update()
  {
    return parent::updateInstance(self::$entity, self::$entityKey);
  }

  public function setInstance($instance)
  {
    $instance->genomeSize = self::generateGenomeSize($instance->properties);
    $this->instance = $instance;
  }

  public function sync()
  {
    return parent::loadInstance(self::$entity, array(array('user_oid', $this->instance->user_oid)));
  }

  private static function generateGenomeSize($properties)
  {
    $decodedProperties = json_decode($properties);
    $genomeSize = 0;
    foreach ($decodedProperties as $element => $classes)
    {
      $numClasses = count($classes) + 1;
      $numBits = ceil(log($numClasses, 2));
      $genomeSize += $numBits;
    }
    return $genomeSize;
  }
}
?>
