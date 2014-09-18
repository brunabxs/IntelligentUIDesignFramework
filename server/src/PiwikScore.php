<?php
class PiwikScore
{
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
    $url = "&columns=";
    foreach ($columns as $column)
    {
      $url .= $column['name'] . ";";
    }
    $url = rtrim($url, ";");
    return $url;
  }

  public static function getURL($generation, $genome, $methods, $startDate, $endDate, $siteId, $token)
  {
    if (count($methods) == 1)
    {
      return self::getURLWithOneMethod($generation, $genome, $methods[0], $startDate, $endDate, $siteId, $token);
    }
    return '';
  }
}
?>
