﻿<?php
class WebAnalyticsGoogleController extends WebAnalyticsController
{
  public function getValue($generationNumber, $individualGenome, $startDate, $endDate)
  {
    $data = $this->extractAnalyticsData();

    return $this->calculateTotalValue($generationNumber, $individualGenome, $data['methods'], $data['filter'], $startDate, $endDate, $this->analytics->token, $data['weights']);
  }

  public function extractAnalyticsData()
  {
    $methods = array();
    $weights = array();
    $filter = null;
    foreach ($this->analyticsData as $data)
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

    return array('methods'=>$methods, 'weights'=>$weights, 'filter'=>$filter);
  }

  private function calculateTotalValue($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken, $weights)
  {
    $data = $this->retrieveDataFromTool($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken);
    $totalScore = 0;

    $i = 0;
    foreach ($data as $index => $value)
    {
      $totalScore += $value * $weights[$i];
      $i++;
    }
    return $totalScore;
  }

  public function retrieveDataFromTool($generationNumber, $individualGenome, $methods, $filter, $startDate, $endDate, $analyticsToken)
  {
    if (!is_file(GOOGLE_ANALYTICS_KEY))
    {
      return array();
    }

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
      $optParams['dimensions'] = 'ga:dimension1';

      $result = $service->data_ga->get($analyticsToken, $startDate, $endDate, self::prepareMetrics($methods), $optParams);

      return $result['totalsForAllResults'];
    }
    catch (Exception $e)
    {
      return array();
    }
  }

  public function validate()
  {
    $data = $this->extractAnalyticsData();

    $result = $this->retrieveDataFromTool('0', '0', $data['methods'], $data['filter'], date('Y-m-d'), date('Y-m-d'), $this->analytics->token);

    if (is_array($result) && empty($result))
    {
      return array('type'=>'error', 'message'=>'Preencha corretamente os campos');
    }
    return array('type'=>'success');
  }

  public static function prepareFilters($filter, $generationNumber, $individualGenome)
  {
    if (isset($filter))
    {
      $filters = $filter . ';';
    }
    else
    {
      $filters = '';
    }

    return $filters . 'ga:dimension1==' . $generationNumber . '.' . $individualGenome;
  }

  public static function prepareMetrics($metrics)
  {
    return implode(',', $metrics);
  }
}
?>
