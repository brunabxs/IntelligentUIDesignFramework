<?php
foreach (glob(dirname(__FILE__) . "/src/*.php") as $filename)
{
  include $filename;
}

$dir = dirname(__FILE__) . '/resources/';

$currentGeneration = GeneticAlgorithm::getLastGeneration($dir);

if (!isset($currentGeneration))
{
  $jsonString = file_get_contents($dir . 'properties.json');
}
else
{
  $jsonString = file_get_contents($dir . $currentGeneration . '-GA.json');
}

$jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
$jsonString = trim($jsonString);
$ga = new GeneticAlgorithm(json_decode($jsonString));

if (!isset($currentGeneration))
{
  $ga->createIndividuals($dir);
}
else
{
  $generation = $currentGeneration;
  $genomes = $ga->json->individuals;
  $methods = array(0 => array('name'=>'VisitFrequency.get'));
  $startDate = date('Y-m-d');
  $endDate = date('Y-m-d');
  $siteId = 1;
  $token = '09a21a9bf047682b557d6a0193b12189';

  $scores = PiwikScore::getScores($generation, $genomes, $methods, $startDate, $endDate, $siteId, $token);

  $ga->loadIndividuals($dir);
  foreach ($ga->population as $individual)
  {
    $individual->score = $scores[$individual->genome];
  }

  $ga->generateIndividuals($dir);
}

$ga->save($dir);
?>
