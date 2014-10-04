<?php
class Individual
{
  public $individual_oid;
  public $genome;
  public $properties;
  public $generationFraction;
  public $generation_oid;

  public function __construct($individual_oid, $genome, $properties, $generationFraction, $generation_oid)
  {
    $this->individual_oid = $individual_oid;
    $this->genome = $genome;
    $this->properties = $properties;
    $this->generationFraction = $generationFraction;
    $this->generation_oid = $generation_oid;
  }
}
?>
