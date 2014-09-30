<?php
  require 'vendor/autoload.php';

  define('RESOURCES_DIR', dirname(__FILE__) . '/resources/');

  $controller = new GeneticAlgorithmController(RESOURCES_DIR);
  $controller->execute();
?>
