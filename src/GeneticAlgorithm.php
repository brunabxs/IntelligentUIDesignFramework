<?php
class GeneticAlgorithm
{
  public function __construct($maxIndividuals, $jsonFile=null, $jsonString=null)
  {
    $this->maxIndividuals = $maxIndividuals;
    $this->json = array();
    $this->genomeSize = 0;

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
}
?>