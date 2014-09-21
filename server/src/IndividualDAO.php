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

  public function load($dir, $ga, $generation, $genomes)
  {
    $individuals = array();
    foreach ($genomes as $index => $genome)
    {
      $properties = self::generateProperties($ga, $genome);
      $individuals[] = new Individual($genome, $properties, null);
    }

    return $individuals;
  }

  public function save($dir, $generation, $index, $individual)
  {
    $json = '__AppConfig=' . self::convertToJSON($generation, $individual);
    file_put_contents(self::getFile($dir, $generation, $index, $individual->genome), $json, LOCK_EX);
  }

  public function getFileContent($dir, $generation, $index, $genome)
  {
    return file_get_contents(self::getFile($dir, $generation, $index, $genome));
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
    foreach ($ga->properties as $element => $classes)
    {
      $numClasses = count($classes);
      $numBits = ceil(log($numClasses+1, 2));
      $genomePart = substr($genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;
      $properties[$element] = $index < $numClasses ? $classes[$index] : '';
    }
    return json_encode($properties);
  }
}
