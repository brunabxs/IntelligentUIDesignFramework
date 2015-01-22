<?php
class PiwikScoreController extends SpecificScoreController
{
  public function calculateScore($generationNumber, $individualGenome, $startDate, $endDate)
  {
    $analytics = $this->analyticsDAO->instance;

    $analyticsData = $this->analyticsDataDAO->loadAllAnalyticsData($analytics);

    $methods = array();
    $weights = array();
    foreach ($analyticsData as $data)
    {
      $methods[] = $data->method;
      $weights[] = $data->weight;
    }

    $url = self::getURL($generationNumber, $individualGenome, $methods, $startDate, $endDate, $analytics->siteId, $analytics->token);

    return $this->calculateTotalScore($weights, $url);
  }

  private function calculateTotalScore($weights, $url)
  {
    $scores = $this->getScore($url);
    $totalScore = 0;

    if (!is_array($scores))
    {
      $totalScore = $scores * $weights[0];
    }
    else
    {
      foreach ($scores as $index => $score)
      {
        $totalScore += $score * $weights[$index];
      }
    }
    return $totalScore;
  }

  public function getScore($url)
  {
    $fetched = file_get_contents($url);
    $score = unserialize($fetched);
    return $score;
  }

  private static function getURL($generationNumber, $individualGenome, $methods, $startDate, $endDate, $analyticsSiteId, $analyticsToken)
  {
    $url = "http://localhost/piwik";
    $url .= "?module=API&method=API.getBulkRequest&format=PHP";

    $index = 0;
    foreach ($methods as $method)
    {
      $url .= "&urls[$index]=";

      $urlIndex = "method=$method";
      $urlIndex .= "&idSite=$analyticsSiteId";
      $urlIndex .= "&period=range";
      $urlIndex .= "&date=$startDate,$endDate";
      $urlIndex .= "&segment=customVariablePageName1==GA;customVariablePageValue1==$generationNumber.$individualGenome";
      $urlIndex .= "&token_auth=$analyticsToken";

      $url .= urlencode($urlIndex);

      $index++;
    }
    return $url;
  }
}
?>
