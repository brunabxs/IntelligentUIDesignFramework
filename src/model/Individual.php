<?php
class Individual
{
  public $individual_oid;
  public $genome;
  public $properties;
  public $quantity;
  public $score;
  public $generation_oid;

  public function __construct($individual_oid, $genome, $properties, $quantity, $score, $generation_oid)
  {
    $this->individual_oid = $individual_oid;
    $this->genome = $genome;
    $this->properties = $properties;
    $this->quantity = $quantity;
    $this->score = $score;
    $this->generation_oid = $generation_oid;
  }
}
?>
