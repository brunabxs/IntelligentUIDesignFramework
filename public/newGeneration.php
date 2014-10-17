<?php
  require '../vendor/autoload.php';
  $controller = new GeneticAlgorithmController();
  $controller->createNextGeneration($_GET['code']);
?>
