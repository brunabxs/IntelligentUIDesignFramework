<?php
class IndividualDAO extends AbstractDAO
{
  private static $entity = 'Individual';
  private static $entityKey = 'individual_oid';

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
    $this->instance = $instance;
  }

  public function sync()
  {
    return parent::loadInstance(self::$entity, array(array('genome', $this->instance->genome),
                                                     array('generation_oid', $this->instance->generation_oid)));
  }

  public static function generateGenome($geneticAlgorithm)
  {
    $genome = '';
    for ($i = 0; $i < $geneticAlgorithm->genomeSize; $i++)
    {
      $rand = rand(0, 1);
      $genome .= "$rand";
    }
    return $genome;
  }

  public static function generateProperties($geneticAlgorithm, $genome)
  {
    $decodedProperties = json_decode($geneticAlgorithm->properties);
    $properties = array();
    $start = 0;
    foreach ($decodedProperties as $element => $classes)
    {
      $numClasses = count($classes);
      $numBits = ceil(log($numClasses+1, 2));
      $genomePart = substr($genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;

      if ($index == 0 || $index > $numClasses)
      {
        $properties[$element] = '';
      }
      else
      {
        $properties[$element] = $classes[$index-1];
      }
    }
    return json_encode($properties);
  }
}
