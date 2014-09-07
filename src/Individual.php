<?php
class Individual
{
  public function __construct($jsonString, $genome='')
  {
    $jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
    $jsonString = trim($jsonString);
    
    $this->json = array();
    $this->genomeSize = 0;
    $this->genome = $genome;

    if ($jsonString != '')
    {
      $json = json_decode($jsonString);
      $this->json = array();
      $this->genomeSize = 0;
      foreach ($json as $element=>$classes)
      {
        $this->json[$element] = array();
        $this->json[$element]['classes'] = $classes;
        $this->json[$element]['bits'] = strlen(decbin(count($classes) + 1));

        $this->genomeSize += $this->json[$element]['bits'];
      }
    }

    if ($this->genome == '')
    {
      for ($i = 0; $i < $this->genomeSize; $i++)
      {
        $rand = rand(0, 1);
        $this->genome .= "$rand";
      }
    }
  }

  public function convertToJSON()
  {
    $json = array();
    $start = 0;
    foreach ($this->json as $element=>$elementData)
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