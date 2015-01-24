<?php
class ScoreController
{
  public $individualDAO;
  public $analyticsDAO;
  public $analyticsDataDAO;

  public function __construct()
  {
    $this->individualDAO = new IndividualDAO();
    $this->analyticsDAO = new AnalyticsDAO();
    $this->analyticsDataDAO = new AnalyticsDataDAO();
  }

  public function updateScores($geneticAlgorithm, $generation, $startDate, $endDate)
  {
    $individuals = $this->individualDAO->loadAllIndividuals($generation);

    foreach ($individuals as $individual)
    {
      $individual->score = $this->calculateScore($geneticAlgorithm, $generation, $individual, $startDate, $endDate);

      $this->individualDAO->instance = $individual;
      $this->individualDAO->update();
    }
  }

  public function calculateScore($geneticAlgorithm, $generation, $individual, $startDate, $endDate)
  {
    return WebAnalyticsFactory::init($geneticAlgorithm);
  }
}
?>
