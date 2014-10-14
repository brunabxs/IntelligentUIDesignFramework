<?php
class AnalyticsScoreDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('AnalyticsScore', 'analyticsScore_oid');
  }

  public function sync()
  {
    return parent::load(array(array('method', $this->instance->method),
                        array('analytics_oid', $this->instance->analytics_oid)));
  }
}
?>
