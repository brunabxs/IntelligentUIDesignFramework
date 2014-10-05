<?php
class PiwikScoreController
{
  public static function getScores($generation, $genomes, $params)
  {
    if (self::validateParameters($params))
    {
      return self::getScoresFromWebAnalytics($generation, $genomes, $params);
    }
    return null;
  }

  private static function validateParameters($params)
  {
    return    isset($params['methods'])
           && isset($params['startDate'])
           && isset($params['endDate'])
           && isset($params['siteId'])
           && isset($params['token']);
  }

  private static function getScoresFromWebAnalytics($generation, $genomes, $params)
  {
    $scores = array();
    foreach ($genomes as $genome => $quantity)
    {
      if (isset($scores[$genome]))
      {
        continue;
      }
      $url = self::getURL($generation, $genome, $params['methods'], $params['startDate'], $params['endDate'], $params['siteId'], $params['token']);
      $fetched = file_get_contents($url);
      //$scores[$genome] = unserialize($fetched);
      $scores[$genome] = 1;
    }
    return $scores;
  }

  private static function getURL($generation, $genome, $methods, $startDate, $endDate, $siteId, $token)
  {
    if (count($methods) == 1)
    {
      return self::getURLWithOneMethod($generation, $genome, $methods[0], $startDate, $endDate, $siteId, $token);
    }
    return '';
  }

  private static function getURLWithOneMethod($generation, $genome, $method, $startDate, $endDate, $siteId, $token)
  {
    $url = "http://localhost/piwik";
    $url .= "?module=API";
    $url .= "&method=" . $method['name'];
    if (isset($method['columns']))
    {
      $url .= self::getColumnsURL($method['columns']);
    }
    $url .= "&idSite=$siteId";
    $url .= "&period=range";
    $url .= "&date=$startDate,$endDate";
    $url .= "&format=PHP";
    $url .= "&segment=customVariablePageName1==GA;customVariablePageValue1==$generation.$genome";
    $url .= "&token_auth=$token";
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
      $url .= $column['name'] . ';';
    }
    $url = rtrim($url, ';');
    return $url;
  }
}
?>
