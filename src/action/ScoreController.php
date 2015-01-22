<?php
class ScoreController
{
  public $individualDAO;
  public $analyticsDAO;

  public function __construct()
  {
    $this->individualDAO = new IndividualDAO();
    $this->analyticsDAO = new AnalyticsDAO();
  }

  public function updateScores($geneticAlgorithm, $generation, $startDate, $endDate)
  {
    $specificScoreController = $this->initScoreController($geneticAlgorithm);

    $individuals = $this->individualDAO->loadAllIndividuals($generation);

    foreach ($individuals as $individual)
    {
      $individual->score = $this->calculateScore($specificScoreController, $geneticAlgorithm, $generation, $individual, $startDate, $endDate);

      $this->individualDAO->instance = $individual;
      $this->individualDAO->update();
    }
  }

  public function initScoreController($geneticAlgorithm)
  {
    $this->analyticsDAO->instance = new Analytics(null, null, null, null, $geneticAlgorithm->geneticAlgorithm_oid);
    $this->analyticsDAO->sync();
    $analytics = $this->analyticsDAO->instance;

    $type = $analytics->type;

    if ($type == 'piwik')
    {
      return new PiwikScoreController($geneticAlgorithm);
    }
    else if ($type == 'google')
    {
      return new GoogleScoreController($geneticAlgorithm);
    }
    else
    {
      return null;
    }
  }

  public function calculateScore($specificScoreController, $geneticAlgorithm, $generation, $individual, $startDate, $endDate)
  {
    return $specificScoreController->calculateScore($generation->number, $individual->genome, $startDate, $endDate);
  }
}
?>
