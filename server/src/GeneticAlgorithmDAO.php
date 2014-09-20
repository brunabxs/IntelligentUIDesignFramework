<?php
class GeneticAlgorithmDAO
{
  public function __construct()
  {
    $this->populationDAO = new PopulationDAO();
  }

  public function create($populationSize, $properties, $selectionMethod, $crossoverMethod, $mutationMethod)
  {
    $genomeSize = self::generateGenomeSize($properties);

    $ga = new GeneticAlgorithm($populationSize, $genomeSize, $properties, $selectionMethod, $crossoverMethod, $mutationMethod);
    $ga->population = $this->populationDAO->create($ga, 0);
    return $ga;
  }

  public function load($dir, $generation=null)
  {
    $json = file_get_contents(self::getFile($dir));
    $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json);
    $json = json_decode($json);

    $populationSize = $json->populationSize;
    $properties = json_decode($json->properties, true);
    $genomeSize = self::generateGenomeSize($properties);
    $selectionMethod = $json->selectionMethod;
    $crossoverMethod = $json->crossoverMethod;
    $mutationMethod = $json->mutationMethod;

    $ga = new GeneticAlgorithm($populationSize, $genomeSize, $properties, $selectionMethod, $crossoverMethod, $mutationMethod);

    $lastGeneration = PopulationDAO::getLastGeneration($dir);
    if (!isset($generation) || $generation > $lastGeneration)
    {
      $generation = $lastGeneration;
    }
    $ga->population = $this->populationDAO->load($dir, $ga, $generation);

    return $ga;
  }

  public function save($dir, $ga)
  {
    $ga->populationDAO->save($dir, $ga->population);
  }

  public static function getFile($dir)
  {
    return $dir . 'properties.json';
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
