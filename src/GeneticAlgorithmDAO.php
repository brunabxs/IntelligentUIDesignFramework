<?php
class GeneticAlgorithmDAO extends AbstractDAO
{
  private static $entity = 'GeneticAlgorithm';
  private static $entityKey = 'geneticAlgorithm_oid';

  public function __constructor()
  {
    parent::__constructor();
    //$this->populationDAO = new PopulationDAO();
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
    parent::$instance = $instance;
  }

  public static function generateGenomeSize($properties)
  {
    $genomeSize = 0;
    foreach ($properties as $element => $classes)
    {
      $numClasses = count($classes) + 1;
      $numBits = ceil(log($numClasses, 2));
      $genomeSize += $numBits;
    }
    return $genomeSize;
  }
}
