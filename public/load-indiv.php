<?php
require '../vendor/autoload.php';

$geneticAlgorithmCode = isset($_GET['code']) ? $_GET['code'] : null;
$generationAndIndividualCode = isset($_GET['indiv']) ? $_GET['indiv'] : null;

header("Access-Control-Allow-Origin: *");

$controller = new GeneticAlgorithmController();
echo $controller->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);
?>
