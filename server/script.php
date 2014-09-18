<?php
function autoload($class)
{
  include 'src/' . $class . '.php';
}

spl_autoload_register('autoload');

$dir = './resources/';

$currentGeneration = GeneticAlgorithm::getLastGeneration();

$jsonString = file_get_contents($dir . $currentGeneration . '-GA.json');
$jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
$jsonString = trim($jsonString);

$individuals = json_decode($jsonString)->individuals;

$individualIndex = rand(0, count($individuals) - 1);
$individualGenome = $individuals[$individualIndex];

echo $dir . $currentGeneration . '-' . $individualIndex . '-' . $individualGenome . '.json';

//echo file_get_contents($dir . $currentGeneration . '-' . $individualIndex . '-' . $individualGenome . '.json');
?>
