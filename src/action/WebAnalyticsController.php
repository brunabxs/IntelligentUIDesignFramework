<?php
abstract class WebAnalyticsController
{
  public $analytics;
  public $analyticsData;

  public function __construct($analytics, $analyticsData)
  {
    $this->analytics = $analytics;
    $this->analyticsData = $analyticsData;
  }

  public abstract function getValue($generationNumber, $individualGenome, $startDate, $endDate);

  public abstract function validate();

  public abstract function extractAnalyticsData();
}
?>
