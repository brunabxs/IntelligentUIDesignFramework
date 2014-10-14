<?php
class AnalyticsDataDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('AnalyticsData', 'analyticsData_oid');
  }

  public function sync()
  {
    return parent::load(array(array('method', $this->instance->method),
                        array('analytics_oid', $this->instance->analytics_oid)));
  }

  public function loadAllAnalyticsData($analytics)
  {
    return parent::loadAll(array(array('analytics_oid', $analytics->analytics_oid)), ' ORDER BY method ');
  }
}
?>
