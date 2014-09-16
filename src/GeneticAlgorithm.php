<?php
class GeneticAlgorithm
{
  public static $dir = './';

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
      $this->createIndividuals();
    }
  }

  private function createIndividuals()
  {
    $this->population = array();
    for ($i = 0; $i < $this->populationSize; $i++)
    {
      $this->population[] = new Individual($this);
    }
    $this->saveIndividuals(self::$dir);
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

  public function saveIndividuals()
  {
    foreach ($this->population as $index => $individual)
    {
      $individual->save(self::$dir . $this->generation . '-' . $index . '-');
    }
  }

  public function save()
  {
    $this->json->individuals = array();
    foreach ($this->population as $individual)
    {
      $this->json->individuals[] = $individual->genome;
    }
    file_put_contents(self::$dir . $this->generation . '-GA.json', $this->json, LOCK_EX);
  }

  public function selectIndividuals()
  {
    return call_user_func('SelectionMethod::' . $this->selectionMethod, $this->population);
  }

  public function generateIndividuals()
  {
    $this->generation++;

    $selectedIndividuals = $this->selectIndividuals();

    $this->population = array();
    for ($i = 0; $i < count($selectedIndividuals); $i += 2)
    {
      $offsprings = call_user_func('CrossoverMethod::' . $this->crossoverMethod, $this, $selectedIndividuals[$i], $selectedIndividuals[$i+1]);
      $this->population = array_merge($this->population, $offsprings);
    }
    $this->saveIndividuals();
  }
}
?>