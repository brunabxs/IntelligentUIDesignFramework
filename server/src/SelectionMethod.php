<?php
class SelectionMethod
{
  public static function rand()
  {
    return rand(0, 10000) / 10000.0;
  }

  public static function getRandomValues($size)
  {
    $values = array();
    for ($i = 0; $i < $size; $i++)
    {
      $values[] = self::rand();
    }
    return $values;
  }

  public static function roulette($individuals, $rouletteValues=array())
  {
    $totalScore = 0;
    foreach ($individuals as $individual)
    {
      $totalScore += $individual->score;
    }

    $numSelectedIndividuals = count($individuals);
    $selectedIndividuals = array();

    if (count($rouletteValues) == 0)
    {
      $rouletteValues = self::getRandomValues($numSelectedIndividuals);
    }

    for ($i = 0; $i < $numSelectedIndividuals; $i++)
    {
      $selectedIndividuals[] = $individuals[$numSelectedIndividuals - 1];
      $cummulativeProportion = 0;
      foreach ($individuals as $individual)
      {
        $cummulativeProportion += ($individual->score / $totalScore);
        if ($rouletteValues[$i] <= $cummulativeProportion)
        {
          $selectedIndividuals[$i] = $individual;
          break;
        }
      }
    }
    return $selectedIndividuals;
  }
}
?>