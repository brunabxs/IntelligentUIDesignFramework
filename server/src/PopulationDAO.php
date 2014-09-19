<?php
class PopulationDAO
{
  public function __construct()
  {
    $this->individualDAO = new IndividualDAO();
  }

  public function create($ga, $generation)
  {
    $individuals = array();
    for ($i = 0; $i < $ga->populationSize; $i++)
    {
      $individuals[] = $this->individualDAO->create($ga);
    }

    return new Population($generation, $individuals);
  }

  public function save($dir, $population)
  {
    foreach ($population->individuals as $index => $individual)
    {
      $this->individualDAO->save($dir, $population->generation, $index, $individual);
    }

    $json = self::convertToJSON($population);
    file_put_contents(self::getFile($dir, $population->generation), $json, LOCK_EX);
  }

  public static function getFile($dir, $generation)
  {
    return $dir . $generation . '-GA.json';
  }

  public static function convertToJSON($population)
  {
    $genomes = array();
    foreach ($population->individuals as $individual)
    {
      $genomes[] = $individual->genome;
    }

    return json_encode(array('generation' => $population->generation,
                             'individuals' => $genomes));
  }
}
