<?php
class GoogleScoreController extends SpecificScoreController
{
  public function calculateScore($generationNumber, $individualGenome, $startDate, $endDate)
  {
    $analytics = $this->analyticsDAO->instance;

    $analyticsData = $this->analyticsDataDAO->loadAllAnalyticsData($analytics);

    $methods = array();
    $weights = array();
    $filter = null;
    foreach ($analyticsData as $data)
    {
      if (isset($data->method) && isset($data->weight))
      {
        $methods[] = $data->method;
        $weights[] = $data->weight;
      }
      else if (isset($data->extraParameters))
      {
        $filter = $data->extraParameters;
      }
    }

    return $this->calculateTotalScore($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analytics->token, $weights);
  }

  private function calculateTotalScore($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken, $weights)
  {
    $scores = $this->getScore($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken);
    $totalScore = 0;

    $i = 0;
    foreach ($scores as $index => $score)
    {
      $totalScore += $score * $weights[$i];
      $i++;
    }
    return $totalScore;
  }

  public function getScore($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken)
  {
    $client = new Google_Client();
    $client->setApplicationName(GOOGLE_ANALYTICS_APP_NAME);

    $client->setAssertionCredentials(new Google_Auth_AssertionCredentials(
      GOOGLE_ANALYTICS_EMAIL,
      array('https://www.googleapis.com/auth/analytics.readonly'),
      file_get_contents(GOOGLE_ANALYTICS_KEY))
    );

    $client->setClientId(GOOGLE_ANALYTICS_CLIENT_ID);
    $client->setAccessType('offline_access');

    $service = new Google_Service_Analytics($client);

    try
    {
      $optParams = array();
      $optParams['filters'] = self::prepareFilters($filter, $generationNumber, $individualGenome);

      $result = $service->data_ga->get($analyticsToken, $startDate, $endDate, $methods, $optParams);

      return $result['totalsForAllResults'];
    }
    catch (Exception $e)
    {
      return array();
    }
  }

  public static function prepareFilters($filter, $generationNumber, $individualGenome)
  {
    if (isset($filter))
    {
      $filters = $filter . ',';
    }
    else
    {
      $filters = '';
    }

    return $filters . 'customVarName1==GA,customVarValue1==' . $generationNumber . '.' . $individualGenome;
  }
}
?>
