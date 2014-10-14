<?php
class ScoreController
{
  public $analyticsDAO;
  public $analyticsDataDAO;
  public $individualDAO;

  public function __construct()
  {
    $this->analyticsDAO = new AnalyticsDAO();
    $this->analyticsDataDAO = new AnalyticsDataDAO();
    $this->individualDAO = new IndividualDAO();
  }

  public function updateScores($geneticAlgorithm, $generation, $startDate, $endDate)
  {
    $this->analyticsDAO->instance = new Analytics(null, null, null, null, $geneticAlgorithm->geneticAlgorithm_oid);
    $this->analyticsDAO->sync();
    $analytics = $this->analyticsDAO->instance;

    $analyticsData = $this->analyticsDataDAO->loadAllAnalyticsData($analytics);

    $individuals = $this->individualDAO->loadAllIndividuals($generation);

    foreach ($analyticsData as $data)
    {
      $method = array('name' => $data->method, 'columns' => array($data->columns));

      foreach ($individuals as $individual)
      {
        $url = self::getURL($generation->number, $individual->genome, $method, $startDate, $endDate, $analytics->siteId, $analytics->token);
        $score = $this->getScore($url);
        $individual->score = $individual->score + $data->weight * $score;
      }
    }

    foreach ($individuals as $individual)
    {
      $this->individualDAO->instance = $individual;
      $this->individualDAO->update();
    }
  }

  public function getScore($url)
  {
    //$fetched = file_get_contents($url);
    //$score = unserialize($fetched);
    $score = 0;
    return $score;
  }

  private static function getURL($generationNumber, $individualGenome, $methods, $startDate, $endDate, $analyticsSiteId, $analyticsToken)
  {
    if (count($methods) == 1)
    {
      return self::getURLWithOneMethod($generationNumber, $individualGenome, $methods[0], $startDate, $endDate, $analyticsSiteId, $analyticsToken);
    }
    return '';
  }

  private static function getURLWithOneMethod($generationNumber, $individualGenome, $method, $startDate, $endDate, $analyticsSiteId, $analyticsToken)
  {
    $url = "http://localhost/piwik";
    $url .= "?module=API";
    $url .= "&method=" . $method['name'];
    if (isset($method['columns']))
    {
      $url .= self::getColumnsURL($method['columns']);
    }
    $url .= "&idSite=$analyticsSiteId";
    $url .= "&period=range";
    $url .= "&date=$startDate,$endDate";
    $url .= "&format=PHP";
    $url .= "&segment=customVariablePageName1==GA;customVariablePageValue1==$generationNumber.$individualGenome";
    $url .= "&token_auth=$analyticsToken";
    return $url;
  }

  private static function getColumnsURL($columns)
  {
    if (empty($columns))
    {
      return '';
    }

    $url = '&columns=';
    foreach ($columns as $column)
    {
      $url .= $column . ';';
    }
    $url = rtrim($url, ';');
    return $url;
  }
}
?>
