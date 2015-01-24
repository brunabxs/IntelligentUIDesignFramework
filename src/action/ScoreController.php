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
      $individual->score = $this->calculateScore($generation, $individual, $startDate, $endDate);

      $this->individualDAO->instance = $individual;
      $this->individualDAO->update();
    }
  }

  public function calculateScore($generation, $individual, $startDate, $endDate)
  {
    return WebAnalyticsFactory::init($geneticAlgorithm)->getValue($generation->number, $individual->genome, $startDate, $endDate);
  }
}
?>
