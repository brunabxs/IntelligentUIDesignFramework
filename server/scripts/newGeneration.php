<?php
  foreach (glob(dirname(__FILE__) . '/../src/*.php') as $filename)
  {
    include $filename;
  }

  $dir = dirname(__FILE__) . '/../resources/';

  $controller = new GeneticAlgorithmController($dir);
  $controller->execute();
?>
