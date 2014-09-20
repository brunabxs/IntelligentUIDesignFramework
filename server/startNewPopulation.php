<?php
foreach (glob(dirname(__FILE__) . "/src/*.php") as $filename)
{
  include $filename;
}

$dir = dirname(__FILE__) . '/resources/';

$gaDAO = new GeneticAlgorithmDAO();
$ga = $gaDAO->load($dir);

$lastGeneration = PopulationDAO::getLastGeneration($dir);
if (isset($lastGeneration))
{
  $generation = $ga->population->generation;
  $genomes = $ga->population->individuals;
  $methods = array(0 => array('name'=>'VisitFrequency.get'));
  $startDate = date('Y-m-d');
  $endDate = date('Y-m-d');
  $siteId = 1;
  $token = '09a21a9bf047682b557d6a0193b12189';

  $scores = PiwikScore::getScores($generation, $genomes, $methods, $startDate, $endDate, $siteId, $token);

  foreach ($ga->population->individuals as $individual)
  {
    $individual->score = $scores[$individual->genome];
  }
}
$gaDAO->save($dir, $ga);
?>
