<?php
class GeneticAlgorithmController
{
  public function __construct($dir)
  {
    $this->gaDAO = new GeneticAlgorithmDAO();
    $this->dir = $dir;
    $this->ga = $this->gaDAO->load($this->dir);
  }

  public function execute()
  {
    $lastGeneration = PopulationDAO::getLastGeneration($this->dir);
    if (isset($lastGeneration))
    {
      $generation = $this->ga->population->generation;

      $genomes = array();
      foreach ($this->ga->population->individuals as $individual)
      {
        $genomes[] = $individual->genome;
      }

      $methods = array(0 => array('name'=>'VisitFrequency.get'));
      $startDate = date('Y-m-d');
      $endDate = date('Y-m-d');
      $siteId = 1;
      $token = '09a21a9bf047682b557d6a0193b12189';

      $scores = PiwikScore::getScores($generation, $genomes, $methods, $startDate, $endDate, $siteId, $token);

      foreach ($this->ga->population->individuals as $individual)
      {
        $individual->score = $scores[$individual->genome];
      }
    }
    $this->gaDAO->save($this->dir, $this->ga);
  }
}
?>
