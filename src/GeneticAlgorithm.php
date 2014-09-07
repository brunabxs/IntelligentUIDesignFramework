<?php
class GeneticAlgorithm
{
  public function __construct($maxIndividuals, $jsonFile=null)
  {
    $this->maxIndividuals = $maxIndividuals;

    if (isset($jsonFile))
    {
      $this->jsonString = file_get_contents($jsonFile);
    }
  }

  public function createIndividuals()
  {
    $individuals = array();
    if ($this->jsonString != '')
    {    
      for ($i = 0; $i < $this->maxIndividuals; $i++)
      {
        $individuals[] = new Individual($this->jsonString);
      }
    }
    return $individuals;
  }
}
?>