<?php
class GeneticAlgorithmCrossover
{
  public static $prob = 0.8;

  private static function rand()
  {
    return rand(0, 10000) / 10000.0;
  }

  private static function randPoint($start, $end)
  {
    return rand($start, $end - 1);
  }

  public static function simple($genome1, $genome2, $point=null)
  {
    if (strlen($genome1) != strlen($genome2))
    {
      throw new Exception('Genomes with different length');
    }

    $genomeSize = strlen($genome1);

    if (self::rand() > self::$prob)
    {
      return array($genome1, $genome2);
    }

    if (!isset($point))
    {
      $point = self::randPoint(0, $genomeSize);
    }

    $part1Individual1 = substr($genome1, 0, $point + 1);
    $part2Individual1 = substr($genome1, $point + 1);

    $part1Individual2 = substr($genome2, 0, $point + 1);
    $part2Individual2 = substr($genome2, $point + 1);

    $genome1 = $part1Individual1 . $part2Individual2;
    $genome2 = $part1Individual2 . $part2Individual1;

    return array($genome1, $genome2);
  }
}
?>
