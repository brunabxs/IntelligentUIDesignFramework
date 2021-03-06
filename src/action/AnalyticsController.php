﻿<?php
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
      $this->analyticsDataDAO->instance = new AnalyticsData(null, (isset($analyticsData['method']) ? $analyticsData['method'] : null), (isset($analyticsData['extraParameters']) ? $analyticsData['extraParameters'] : null), (isset($analyticsData['weight']) ? $analyticsData['weight'] : null), $this->analyticsDAO->instance->analytics_oid);
      $this->analyticsDataDAO->persist();
    }
  }

  public function load($user)
  {
    // retrieve genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, null, $user->user_oid);
    $this->geneticAlgorithmDAO->sync();

    // retrieve analytics
    $this->analyticsDAO->instance = new Analytics(null, null, null, null, $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->analyticsDAO->sync();
  }

  public function getType($geneticAlgorithmCode)
  {
    // retrieve genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, $geneticAlgorithmCode, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->sync();

    if ($this->geneticAlgorithmDAO->instance === null)
    {
      return null;
    }

    $this->analyticsDAO->instance = new Analytics(null, null, null, null, $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->analyticsDAO->sync();

    return $this->analyticsDAO->instance->type;
  }

  public function validate($tool, $token, $siteId, $analyticsDataParams)
  {
    $analytics = new Analytics(null, $token, $siteId, $tool, null);

    $analyticsData = array();
    foreach ($analyticsDataParams as $data)
    {
      $analyticsData[] = new AnalyticsData(null, (isset($data['method']) ? $data['method'] : null), (isset($data['extraParameters']) ? $data['extraParameters'] : null), (isset($data['weight']) ? $data['weight'] : null), null);
    }

    $webController = WebAnalyticsFactory::init(null, $analytics, $analyticsData);
    return $webController->validate();
  }
}
?>
