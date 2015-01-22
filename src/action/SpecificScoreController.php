<?php
abstract class SpecificScoreController
{
  public $analyticsDAO;
  public $analyticsDataDAO;

  public function __construct($geneticAlgorithm)
  {
    $this->analyticsDAO = new AnalyticsDAO();
    $this->analyticsDataDAO = new AnalyticsDataDAO();

    $this->analyticsDAO->instance = new Analytics(null, null, null, null, $geneticAlgorithm->geneticAlgorithm_oid);
    $this->analyticsDAO->sync();
  }

  public abstract function getAnalyticsData();

  public abstract function calculateScore($generationNumber, $individualGenome, $startDate, $endDate);
}
?>
