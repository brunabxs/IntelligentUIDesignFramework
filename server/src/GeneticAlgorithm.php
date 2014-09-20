<?php
class GeneticAlgorithm
{
  public function __construct($populationSize, $genomeSize, $properties, $selectionMethod, $crossoverMethod, $mutationMethod)
  {
    $this->populationSize = $populationSize;
    $this->genomeSize = $genomeSize;
    $this->properties = $properties;
    $this->selectionMethod = $selectionMethod;
    $this->crossoverMethod = $crossoverMethod;
    $this->mutationMethod = $mutationMethod;
    $this->population = null;
  }
}
?>
