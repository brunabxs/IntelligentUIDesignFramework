<?php
class AnalyticsDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('Analytics', 'analytics_oid');
  }

  public function sync()
  {
    return parent::load(array(array('geneticAlgorithm_oid', $this->instance->geneticAlgorithm_oid)));
  }
}
?>
