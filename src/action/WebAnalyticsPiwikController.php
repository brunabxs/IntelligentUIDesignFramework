<?php
class WebAnalyticsPiwikController extends WebAnalyticsController
{
  public function getValue($generationNumber, $individualGenome, $startDate, $endDate)
  {
    $data = $this->extractAnalyticsData();

    $url = self::getURL($generationNumber, $individualGenome, $data['methods'], $startDate, $endDate, $this->analytics->siteId, $this->analytics->token);

    return $this->calculateTotalValue($data['weights'], $url);
  }

  public function extractAnalyticsData()
  {
    $methods = array();
    $weights = array();
    foreach ($this->analyticsData as $data)
    {
      $methods[] = $data->method;
      $weights[] = $data->weight;
    }

    return array('methods'=>$methods, 'weights'=>$weights);
  }

  private function calculateTotalValue($weights, $url)
  {
    $data = $this->retrieveDataFromTool($url);
    $totalScore = 0;

    if (!is_array($data))
    {
      $totalScore = $data * $weights[0];
    }
    else
    {
      foreach ($data as $index => $value)
      {
        $totalScore += $value * $weights[$index];
      }
    }
    return $totalScore;
  }

  public function retrieveDataFromTool($url)
  {
    $fetched = file_get_contents($url);
    $score = unserialize($fetched);
    return $score;
  }

  public function validate()
  {
    $data = $this->extractAnalyticsData();

    $url = self::getURL('0', '0', $data['methods'], date('Y-m-d'), date('Y-m-d'), $this->analytics->siteId, $this->analytics->token);

    $result = $this->retrieveDataFromTool($url);

    if (is_array($result) && empty($result))
    {
      return array('type'=>'error', 'message'=>'Preencha corretamente os campos');
    }
    return array('type'=>'success');
  }

  private static function getURL($generationNumber, $individualGenome, $methods, $startDate, $endDate, $analyticsSiteId, $analyticsToken)
  {
    $url = PIWIK_SERVER;
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
