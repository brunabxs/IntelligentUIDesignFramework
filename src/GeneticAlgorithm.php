<?php
class GeneticAlgorithm
{
  public static $dir = '.';

  public function __construct($json=null)
  {
    $this->json = $json;
    $this->individualsProperties = json_decode($this->json->individualsProperties);
    $this->generation = $this->json->generation;
    $this->populationSize = $this->json->populationSize;
    $this->genomeSize = $this->json->genomeSize;
    $this->selectionMethod = $this->json->selectionMethod;
    $this->crossoverMethod = $this->json->crossoverMethod;
    $this->population = self::population($this, self::$dir);
  }

  private static function population($ga, $dir)
  {
    if ($ga->generation == 0)
    {
      return self::createIndividuals($ga, $dir);
    }
    else
    {
      return self::loadIndividuals($ga, $dir);
    }
  }

  private static function createIndividuals($ga, $dir)
  {
    $population = array();
    for ($i = 0; $i < $ga->populationSize; $i++)
    {
      $population[] = new Individual($ga);
    }
    return $population;
  }

  private static function loadIndividuals($ga, $dir)
  {
    $population = array();
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          $individual = split('-', $file);
          $generation = $individual[0];
          $genome = split('.', $individual[2])[0];
          if ($generation == $ga->generation-1)
          {
            $population[] = new Individual($ga, $genome);
          }
        }
      }
    }
    return $population;
  }

  public function saveIndividuals($dir)
  {
    foreach ($this->individuals as $index => $individual)
    {
      $individual->save($dir . $this->generation . '-' . $index . '-');
    }
  }

  public function selectIndividuals()
  {
    return call_user_func('SelectionMethod::' . $this->selectionMethod, $this->individuals);
  }
}
?>