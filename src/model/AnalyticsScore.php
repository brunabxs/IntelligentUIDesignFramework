<?php
class AnalyticsScore
{
  public $analyticsScore_oid;
  public $method;
  public $columns;
  public $weight;
  public $analytics_oid;

  public function __construct($analyticsScore_oid, $method, $columns, $weight, $analytics_oid)
  {
    $this->analyticsScore_oid = $analyticsScore_oid;
    $this->method = $method;
    $this->columns = $columns;
    $this->weight = $weight;
    $this->analytics_oid = $analytics_oid;
  }
}
?>
