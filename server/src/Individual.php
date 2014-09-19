<?php
class Individual
{
  public function __construct($genome, $properties, $score)
  {
    $this->genome = $genome;
    $this->properties = $properties;
    $this->score = $score;
  }
}
?>
