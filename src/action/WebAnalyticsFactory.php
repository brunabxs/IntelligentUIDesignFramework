<?php
class WebAnalyticsFactory
{
  public static function init($geneticAlgorithm, $analytics=null, $analyticsData=null)
  {
    if ($analytics == null)
    {
      $analyticsDAO = new AnalyticsDAO();
      $analyticsDAO->instance = new Analytics(null, null, null, null, $geneticAlgorithm->geneticAlgorithm_oid);
      $analyticsDAO->sync();
      $analytics = $analyticsDAO->instance;
    }

    if ($analyticsData == null)
    {
      $analyticsDataDAO = new AnalyticsDataDAO();
      $analyticsData = $analyticsDataDAO->loadAllAnalyticsData($analytics);
    }

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
