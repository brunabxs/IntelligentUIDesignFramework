<?php
class GeneticAlgorithmDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('GeneticAlgorithm', 'geneticAlgorithm_oid');
  }

  public function sync()
  {
    $instance = $this->instance;
    $userSync = parent::load(array(array('user_oid', $instance->user_oid)));
    if ($this->instance === null)
    {
      return parent::load(array(array('code', $instance->code)));
    }
    return $userSync;
  }

  public static function generateGenomeSize($properties)
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
