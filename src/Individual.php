<?php
class Individual
{
  public static $genomeSize;

  public static function setGenomeSize($jsonString)
  {
    $jsonString = trim($jsonString);

    self::$genomeSize = 0;
    if ($jsonString != '')
    {
      $json = json_decode($jsonString);

      foreach ($json as $element=>$classes)
      {
        $numClasses = count($classes) + 1;
        $numBits = strlen(decbin($numClasses));
        self::$genomeSize += $numBits;
      }
    }
  }
}
?>