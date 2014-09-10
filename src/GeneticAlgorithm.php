<?php
class GeneticAlgorithm
{
  public function __construct($maxIndividuals, $jsonFile=null, $jsonString=null, $selectionFunction=null)
  {
    $this->maxIndividuals = $maxIndividuals;
    $this->json = array();
    $this->genomeSize = 0;
    $this->individuals = null;
    $this->selectionFunction = isset($selectionFunction) ? $selectionFunction : 'SelectionFunction::roulette';

    if (isset($jsonFile))
    {
      $jsonString = file_get_contents($jsonFile);
    }
    else if (!isset($jsonString) || $jsonString == '')
    {
      throw new Exception('Declare jsonFile or jsonString');
    }

    $jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
    $jsonString = trim($jsonString);

    $json = json_decode($jsonString);
    foreach ($json as $element=>$classes)
    {
      $this->json[$element] = array();
      $this->json[$element]['classes'] = $classes;
      $this->json[$element]['bits'] = strlen(decbin(count($classes) + 1));

      $this->genomeSize += $this->json[$element]['bits'];
    }
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
}
?>