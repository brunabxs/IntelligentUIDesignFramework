<?php
class Individual
{
  public function __construct($ga, $genome='', $score=null)
  {
    if (!isset($genome) || $genome == '')
    {
      for ($i = 0; $i < $ga->genomeSize; $i++)
      {
        $rand = rand(0, 1);
        $genome .= "$rand";
      }
    }

    $this->ga = $ga;
    $this->genome = $genome;
    $this->score = $score;
  }

  public function convertToJSON()
  {
    $json = array();
    $start = 0;
    foreach ($this->ga->individualsProperties as $element=>$classes)
    {
      $numClasses = count($classes);
      $numBits = strlen(decbin($numClasses + 1));
      $genomePart = substr($this->genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;
      $json[$element] = $index < $numClasses ? $classes[$index] : '';
    }
    return json_encode($json);
  }

  public function save($dir)
  {
    $json = '__AppConfig=' . $this->convertToJSON();
    file_put_contents($dir . $this->genome . '.json', $json, LOCK_EX);
  }
}
?>