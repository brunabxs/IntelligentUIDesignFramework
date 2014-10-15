<?php
class AnalyticsData
{
  public $analyticsData_oid;
  public $method;
  public $extraParameters;
  public $weight;
  public $analytics_oid;

  public function __construct($analyticsData_oid, $method, $extraParameters, $weight, $analytics_oid)
  {
    $this->analyticsData_oid = $analyticsData_oid;
    $this->method = $method;
    $this->extraParameters = $extraParameters;
    $this->weight = $weight;
    $this->analytics_oid = $analytics_oid;
  }
}
?>
