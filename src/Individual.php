<?php
class Individual
{
  public static $genomeMask;

  public static function setGenomeMask($jsonString)
  {
    $jsonString = trim($jsonString);
    
    $genome = '';
    if ($jsonString != '')
    {
      $json = json_decode($jsonString);
      
      foreach ($json as $element=>$classes) {
        $genome = $genome . str_repeat('0', count($classes));
      }
    }
    self::$genomeMask = $genome;
  }
}

$json = '{"h1": ["class1_h1", "class2_h1"], "h2": ["class1_h2", "class2_h2", "class3_h2"]}';
$indiv = new Individual($json);

?>