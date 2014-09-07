<?php
class Individual
{
  public function __construct($ga, $genome='')
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
  }

  public function convertToJSON()
  {
    $json = array();
    $start = 0;
    foreach ($this->ga->json as $element=>$elementData)
    {
      $numBits = $elementData['bits'];
      $numClasses = count($elementData['classes']);
      $genomePart = substr($this->genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;
      $json[$element] = $index < $numClasses ? $elementData['classes'][$index] : '';
    }
    return json_encode($json);
  }
}
?>