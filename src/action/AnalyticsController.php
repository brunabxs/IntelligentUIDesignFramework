<?php
class AnalyticsController
{
  public $analyticsDAO;
  public $analyticsDataDAO;
  public $geneticAlgorithmDAO;

  public function __construct()
  {
    $this->analyticsDAO = new AnalyticsDAO();
    $this->analyticsDataDAO = new AnalyticsDataDAO();
    $this->geneticAlgorithmDAO = new GeneticAlgorithmDAO();
  }

  public function create($user, $tool, $token, $siteId, $data)
  {
    // load user's genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, null, $user->user_oid);
    $this->geneticAlgorithmDAO->sync();

    // create analytics
    $this->analyticsDAO->instance = new Analytics(null, $token, $siteId, $tool, $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->analyticsDAO->persist();
    $this->analyticsDAO->sync();

    // create analytics data
    foreach ($data as $analyticsData)
    {
      $this->analyticsDataDAO->instance = new AnalyticsData(null, $analyticsData['method'], (isset($analyticsData['extraParameters']) ? $analyticsData['extraParameters'] : null), $analyticsData['weight'], $this->analyticsDAO->instance->analytics_oid);
      $this->analyticsDataDAO->persist();
    }
  }
}
?>
