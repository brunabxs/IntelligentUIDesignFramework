<?php
class GeneticAlgorithmDAO
{
  public function __construct()
  {
    $this->populationDAO = new PopulationDAO();
  }

  public function create($populationSize, $individualProperties, $selectionMethod, $crossoverMethod, $mutationMethod)
  {
    $genomeSize = self::generateGenomeSize($individualProperties);

    $ga = new GeneticAlgorithm($populationSize, $genomeSize, $individualProperties, $selectionMethod, $crossoverMethod, $mutationMethod);
    $ga->population = $this->populationDAO->create($ga, 0);
    return $ga;
  }

  public function save($dir, $ga)
  {
    $ga->populationDAO->save($dir, $ga->population);
  }

  public static function generateGenomeSize($properties)
  {
    $genomeSize = 0;
    foreach ($properties as $element => $classes)
    {
      $numClasses = count($classes) + 1;
      $numBits = strlen(decbin(ceil(log($numClasses, 2))));
      $genomeSize += $numBits;
    }
    return $genomeSize;
  }
}
