<?php
class CrossoverMethod
{
  public static $prob = 0.8;

  public static function rand()
  {
    return rand(0, 10000) / 10000.0;
  }

  public static function randPoint($start, $end)
  {
    return rand($start, $end - 1);
  }

  public static function simple($ga, $individual1, $individual2, $point=null)
  {
    if (self::rand() > self::$prob)
    {
      return array(new Individual($ga, $individual1->genome), new Individual($ga, $individual2->genome));
    }

    if (!isset($point))
    {
      $point = self::randPoint(0, $ga->genomeSize);
    }

    $part1Individual1 = substr($individual1->genome, 0, $point + 1);
    $part2Individual1 = substr($individual1->genome, $point + 1);

    $part1Individual2 = substr($individual2->genome, 0, $point + 1);
    $part2Individual2 = substr($individual2->genome, $point + 1);

    $genome1 = $part1Individual1 . $part2Individual2;
    $genome2 = $part1Individual2 . $part2Individual1;

    return array(new Individual($ga, $genome1), new Individual($ga, $genome2));
  }
}
?>