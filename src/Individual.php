<?php
class Individual
{
  public static function getGenomeSize($jsonString)
  {
    $jsonString = trim($jsonString);

    $genomeSize = 0;
    if ($jsonString != '')
    {
      $json = json_decode($jsonString);

      foreach ($json as $element=>$classes)
      {
        $numClasses = count($classes) + 1;
        $numBits = strlen(decbin($numClasses));
        $genomeSize += $numBits;
      }
    }

    return $genomeSize;
  }

  public static function create($jsonString)
  {
    $genome = '';
    $genomeSize = self::getGenomeSize($jsonString);
    for ($i = 0; $i < $genomeSize; $i++)
    {
      $rand = rand(0, 1);
      $genome .= "$rand";
    }
    return $genome;
  }
}
?>