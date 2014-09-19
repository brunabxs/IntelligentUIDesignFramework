<?php
class IndividualDAO
{
  public function create($ga, $genome=null, $score=null)
  {
    if (!isset($genome))
    {
      $genome = self::generateGenome($ga);
    }

    $properties = self::generateProperties($ga, $genome);

    return new Individual($genome, $properties, $score);
  }

  public function save($dir, $generation, $index, $individual)
  {
    $json = '__AppConfig=' . self::convertToJSON($generation, $individual);
    file_put_contents(self::getFile($dir, $generation, $index, $individual->genome), $json, LOCK_EX);
  }

  public static function getFile($dir, $generation, $index, $genome)
  {
    return $dir . $generation . '-' . $index . '-' . $genome . '.json';
  }

  public static function convertToJSON($generation, $individual)
  {
    return json_encode(array('generation' => $generation,
                             'genome' => $individual->genome,
                             'properties' => json_decode($individual->properties)));
  }

  private static function generateGenome($ga)
  {
    $genome = '';
    for ($i = 0; $i < $ga->genomeSize; $i++)
    {
      $rand = rand(0, 1);
      $genome .= "$rand";
    }
    return $genome;
  }

  private static function generateProperties($ga, $genome)
  {
    $properties = array();
    $start = 0;
    foreach ($ga->individualsProperties as $element => $classes)
    {
      $numClasses = count($classes);
      $numBits = strlen(decbin(ceil(log($numClasses+1, 2))));
      $genomePart = substr($genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;
      $properties[$element] = $index < $numClasses ? $classes[$index] : '';
    }
    return json_encode($properties);
  }
}
