<?php
class MethodsForMutation
{
  public static $prob = 0.01;

  public static function rand()
  {
    return rand(0, 10000) / 10000.0;
  }

  public static function randPoint($start, $end)
  {
    return rand($start, $end - 1);
  }

  public static function simple($genome, $point=null)
  {
    if (self::rand() > self::$prob)
    {
      return $genome;
    }

    if (!isset($point))
    {
      $point = self::randPoint(0, strlen($genome));
    }

    $genome[$point] = $genome[$point] == '1' ? '0' : '1';

    return $genome;
  }
}
?>
