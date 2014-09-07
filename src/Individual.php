<?php
class Individual
{
  public static function getGenomeSize($jsonString)
  {
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

  public static function createGenome($jsonString)
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

  public static function createJSON($jsonString, $genome)
  {
    $jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
    $jsonString = trim($jsonString);

    $array = array();

    if ($genome != '')
    {
      $json = json_decode($jsonString);

      $start = 0;
      foreach ($json as $element=>$classes)
      {
        $numClasses = count($classes) + 1;
        $numBits = strlen(decbin($numClasses));
        $genomePart = substr($genome, $start, $numBits);
        $start += $numBits;
        $classIndex = bindec($genomePart);
        $array[$element] = $classIndex < count($classes) ? $classes[$classIndex] : '';
      }
    }

    return json_encode($array);
  }
}
?>