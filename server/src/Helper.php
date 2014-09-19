<?php
class Helper
{
  public static function getIndividualData($dir, $code)
  {
    $generation = null;
    $genome = null;

    $code = split('\.', $code);
    if (count($code) == 2)
    {
      $generation = $code[0];
      $genome = $code[1];
    }

    $generation = self::updateGeneration($dir, $generation);
    
    $jsonString = file_get_contents($dir . $generation . '-GA.json');
    $jsonString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $jsonString);
    $jsonString = trim($jsonString);
    $json = json_decode($jsonString);
    $individuals = $json->individuals;

    $index = self::updateIndividualIndex($individuals, $genome);

    return file_get_contents($dir . $generation . '-' . $index . '-' . $individuals[$index] . '.json');
  }

  private static function updateGeneration($dir, $generation)
  {
    $currentGeneration = GeneticAlgorithm::getLastGeneration($dir);

    if (!isset($generation))
    {
      $generation = $currentGeneration;
    }

    return min($currentGeneration, $generation);
  }

  private static function updateIndividualIndex($genomes, $genome)
  {
    $index = array_search($genome, $genomes);

    if (!isset($index) || $index == false)
    {
      $index = rand(0, count($genomes) - 1);
    }

    return $index;
  }
}
