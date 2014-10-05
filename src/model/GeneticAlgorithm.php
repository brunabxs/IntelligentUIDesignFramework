<?php
class GeneticAlgorithm
{
  public $geneticAlgorithm_oid;
  public $code;
  public $populationSize;
  public $genomeSize;
  public $methodForSelection;
  public $methodForCrossover;
  public $methodForMutation;
  public $properties;
  public $user_oid;

  public function __construct($geneticAlgorithm_oid, $code, $populationSize, $genomeSize, $methodForSelection, $methodForCrossover, $methodForMutation, $properties, $user_oid)
  {
    $this->geneticAlgorithm_oid = $geneticAlgorithm_oid;
    $this->code = $code;
    $this->populationSize = $populationSize;
    $this->genomeSize = $genomeSize;
    $this->methodForSelection = $methodForSelection;
    $this->methodForCrossover = $methodForCrossover;
    $this->methodForMutation = $methodForMutation;
    $this->properties = $properties;
    $this->user_oid = $user_oid;
  }
}
?>
