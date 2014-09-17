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
    $this->genomeSize = isset($this->json->genomeSize) ? $this->json->genomeSize : self::calculateGenomeSize($this->individualsProperties);
    $this->selectionMethod = (isset($this->json->selectionMethod) ? $this->json->selectionMethod : 'SelectionMethod::roulette');
    $this->crossoverMethod = (isset($this->json->crossoverMethod) ? $this->json->crossoverMethod : 'CrossoverMethod::simple');
    $this->mutationMethod = (isset($this->json->mutationMethod) ? $this->json->mutationMethod : 'MutationMethod::simple');
    $this->population = null;

    if ($this->generation == 0)
    {
      $this->createIndividuals();
    }
  }

  public static function calculateGenomeSize($properties)
  {
    $genomeSize = 0;
    foreach ($properties as $element => $classes)
    {
      $numClasses = count($classes);
      $numBits = strlen(decbin($numClasses + 1));
      $genomeSize += $numBits;
    }
    return $genomeSize;
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
    $fileContent = get_object_vars($this);
    unset($fileContent['json']);
    unset($fileContent['population']);
    $fileContent['individualsProperties'] = json_encode($fileContent['individualsProperties']);
    $fileContent['individuals'] = array();
    foreach ($this->population as $individual)
    {
      $fileContent['individuals'][] = $individual->genome;
    }
    file_put_contents(self::$dir . $this->generation . '-GA.json', json_encode($fileContent, JSON_PRETTY_PRINT), LOCK_EX);
  }

  public function selectIndividuals()
  {
    return call_user_func($this->selectionMethod, $this->population);
  }

  public function generateIndividuals()
  {
    $this->generation++;

    // select
    $selectedIndividuals = $this->selectIndividuals();

    // crossover
    $this->population = array();
    for ($i = 0; $i < count($selectedIndividuals); $i += 2)
    {
      $offsprings = call_user_func($this->crossoverMethod, $this, $selectedIndividuals[$i], $selectedIndividuals[$i+1]);
      $this->population = array_merge($this->population, $offsprings);
    }

    // mutation
    foreach ($this->population as &$individual)
    {
      $individual = call_user_func($this->mutationMethod, $this, $individual);
    }

    $this->saveIndividuals();
  }

  public static function getLastGeneration()
  {
    $dir = self::$dir;
    $lastGeneration = null;
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file) && strpos($file, '-GA.json'))
        {
          $lastGeneration = max(explode('-', $file)[0], $lastGeneration);
        }
      }
    }
    return $lastGeneration;
  }
}
?>
