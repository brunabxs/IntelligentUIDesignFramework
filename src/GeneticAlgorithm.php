<?php
class GeneticAlgorithm
{
  public function __construct($populationSize, $genomeSize, $properties, $methodForSelection, $methodForCrossover, $methodForMutation)
  {
    $this->populationSize = $populationSize;
    $this->genomeSize = $genomeSize;
    $this->properties = $properties;
    $this->methodForSelection = $methodForSelection;
    $this->methodForCrossover = $methodForCrossover;
    $this->methodForMutation = $methodForMutation;
    $this->population = null;
  }
}
?>
