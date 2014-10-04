<?php
class GeneticAlgorithmSelection
{
  private static function rand()
  {
    return rand(0, 10000) / 10000.0;
  }

  private static function getRandomValues($size)
  {
    $values = array();
    for ($i = 0; $i < $size; $i++)
    {
      $values[] = self::rand();
    }
    return $values;
  }

  private static function calculateTotalScore($individuals)
  {
    $totalScore = 0;
    foreach ($individuals as $individual)
    {
      $totalScore += $individual->score;
    }
    return $totalScore;
  }

  public static function roulette($individuals, $rouletteValues=array())
  {
    $totalScore = self::calculateTotalScore($individuals);

    $rouletteValues = empty($rouletteValues) ? self::getRandomValues($numSelectedIndividuals) : $rouletteValues;

    $selectedIndividuals = array();
    for ($i = 0; $i < count($individuals); $i++)
    {
      $selectedIndividuals[$i] = $individuals[count($individuals) - 1];
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
