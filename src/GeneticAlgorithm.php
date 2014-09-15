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
    $this->population = null;

    if ($this->generation == 0)
    {
      $this->createIndividuals(self::$dir);
    }
  }

  private function createIndividuals($dir)
  {
    $this->population = array();
    for ($i = 0; $i < $this->populationSize; $i++)
    {
      $this->population[] = new Individual($this);
    }
    $this->saveIndividuals($dir);
  }

  public function loadIndividuals()
  {
    $dir = self::$dir;
    $this->population = array();
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          $individual = split('-', $file);
          $generation = $individual[0];
          $genome = split('.', $individual[2])[0];
          if ($generation == $this->generation)
          {
            $this->population[] = new Individual($this, $genome);
          }
        }
      }
    }
    return $this->population;
  }

  public function saveIndividuals($dir)
  {
    foreach ($this->population as $index => $individual)
    {
      $individual->save($dir . $this->generation . '-' . $index . '-');
    }
  }

  public function selectIndividuals()
  {
    return call_user_func('SelectionMethod::' . $this->selectionMethod, $this->population);
  }
}
?>