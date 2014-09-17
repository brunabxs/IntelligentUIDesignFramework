<?php
function autoload($class)
{
  include 'src/' . $class . '.php';
}

spl_autoload_register('autoload');

GeneticAlgorithm::$dir = './resources/';

$currentGeneration = GeneticAlgorithm::getLastGeneration();

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

if (isset($currentGeneration))
{
  // TODO scores
  //$ga->generateIndividuals();
}

$ga->save();
?>
