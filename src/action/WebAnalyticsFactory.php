<?php
class WebAnalyticsFactory
{
  public static function init($geneticAlgorithm)
  {
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDataDAO = new AnalyticsDataDAO();

    $analyticsDAO->instance = new Analytics(null, null, null, null, $geneticAlgorithm->geneticAlgorithm_oid);
    $analyticsDAO->sync();
    $analytics = $analyticsDAO->instance;

    $analyticsData = $analyticsDataDAO->loadAllAnalyticsData($analytics);

    if ($analytics->type == 'piwik')
    {
      return new WebAnalyticsPiwikController($analytics, $analyticsData);
    }
    else if ($analytics->type == 'google-old')
    {
      return new WebAnalyticsGoogleOldController($analytics, $analyticsData);
    }
    else if ($analytics->type == 'google')
    {
      return new WebAnalyticsGoogleController($analytics, $analyticsData);
    }
    else
    {
      return null;
    }
  }
}
?>
