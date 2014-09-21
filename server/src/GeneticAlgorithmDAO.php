<?php
class GeneticAlgorithmDAO
{
  public function __construct()
  {
    $this->populationDAO = new PopulationDAO();
  }

  public function create($dir, $populationSize, $properties, $methodForSelection, $methodForCrossover, $methodForMutation)
  {
    $json = json_encode(array("populationSize"     => $populationSize,
                              "methodForSelection" => $methodForSelection,
                              "methodForCrossover" => $methodForCrossover,
                              "methodForMutation"  => $methodForMutation,
                              "properties"         => $properties), JSON_PRETTY_PRINT);
    file_put_contents(self::getFile($dir), $json, LOCK_EX);
  }

  public function load($dir, $generation=null)
  {
    $json = file_get_contents(self::getFile($dir));
    $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json);
    $json = json_decode($json);

    $populationSize = $json->populationSize;
    $properties = json_decode($json->properties, true);
    $genomeSize = self::generateGenomeSize($properties);
    $methodForSelection = $json->methodForSelection;
    $methodForCrossover = $json->methodForCrossover;
    $methodForMutation = $json->methodForMutation;

    $ga = new GeneticAlgorithm($populationSize, $genomeSize, $properties, $methodForSelection, $methodForCrossover, $methodForMutation);

    $lastGeneration = PopulationDAO::getLastGeneration($dir);
    if (!isset($lastGeneration))
    {
      $ga->population = $this->populationDAO->create($ga, 0);
    }
    else
    {
      if (!isset($generation) || $generation > $lastGeneration)
      {
        $generation = $lastGeneration;
      }
      $ga->population = $this->populationDAO->load($dir, $ga, $generation);
    }

    return $ga;
  }

  public function save($dir, $ga)
  {
    $this->populationDAO->save($dir, $ga->population);
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
