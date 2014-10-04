<?php
class Generation
{
  public $generation_oid;
  public $number;
  public $geneticAlgorithm_oid;

  public function __construct($generation_oid, $number, $geneticAlgorithm_oid)
  {
    $this->generation_oid = $generation_oid;
    $this->number = $number;
    $this->geneticAlgorithm_oid = $geneticAlgorithm_oid;
  }
}
?>
