<?php
class GeneticAlgorithm
{
  public function __construct($maxIndividuals, $json=null, $jsonFile=null, $jsonString=null, $selectionFunction=null, $crossoverFunction=null)
  {
    $this->maxIndividuals = $maxIndividuals;
    $this->json = null;
    $this->genomeSize = 0;
    $this->individuals = null;
    $this->selectionFunction = isset($selectionFunction) ? $selectionFunction : 'SelectionFunction::roulette';
    $this->crossoverFunction = isset($crossoverFunction) ? $crossoverFunction : 'CrossoverFunction::simple';

    if (isset($json))
    {
      $this->json = $json;
    }
    else if (isset($jsonFile) && $jsonString != '')
    {
      $jsonString = file_get_contents($jsonFile);
      $jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
      $jsonString = trim($jsonString);
      $this->json = self::createJSON($jsonString);
    }
    else if (isset($jsonString) && $jsonString != '')
    {
      $jsonString = trim($jsonString);
      $this->json = self::createJSON($jsonString);
    }
    else
    {
      throw new Exception('Declare jsonFile or jsonString');
    }

    foreach ($this->json as $elementData)
    {
      $this->genomeSize += $elementData['bits'];
    }
  }

  private static function createJSON($jsonString)
  {
    $myJson = array();
    $json = json_decode($jsonString);
    foreach ($json as $element=>$classes)
    {
      $myJson[$element] = array();
      $myJson[$element]['classes'] = $classes;
      $myJson[$element]['bits'] = strlen(decbin(count($classes) + 1));
    }
    return $myJson;
  }

  public function createIndividuals($dir='')
  {
    for ($i = 0; $i < $this->maxIndividuals; $i++)
    {
      $individual = new Individual($this);
      $json = '__AppConfig=' . $individual->convertToJSON();
      file_put_contents($dir . $i . '-' .$individual->genome . '.json', $json, LOCK_EX);
    }
  }

  public function loadIndividuals($dir='')
  {
    $this->individuals  = array();
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          $genome = substr($file, strpos($file, '-')+1, strpos($file, '.')-2);
          $this->individuals[] = new Individual($this, $genome);
        }
      }
    }
  }

  public function selectIndividuals()
  {
    return call_user_func($this->selectionFunction, $this->individuals);
  }

  public function generateOffspringIndividuals()
  {
    $offsprings = array();
    $ga = new GeneticAlgorithm($this->maxIndividuals, $this->json, null, null, $this->selectionFunction, $this->crossoverFunction);
    $selectedIndividuals = $this->selectIndividuals();
    for ($i = 0; $i < count($selectedIndividuals); $i+=2)
    {
      $offsprings = array_merge($offsprings, call_user_func($this->crossoverFunction, $ga, $selectedIndividuals[$i], $selectedIndividuals[$i+1]));
    }
    return $offsprings;
  }
}
?>