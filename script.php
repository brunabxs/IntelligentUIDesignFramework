<?php
require 'vendor/autoload.php';

$geneticAlgorithmCode = isset($_GET['c']) ? $_GET['c'] : null;
$generationAndIndividualCode = isset($_GET['i']) ? $_GET['i'] : null;

header("Access-Control-Allow-Origin: *");

$controller = new GeneticAlgorithmController();
echo $controller->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);
?>
