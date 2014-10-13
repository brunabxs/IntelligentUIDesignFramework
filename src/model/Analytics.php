<?php
class Analytics
{
  public $analytics_oid;
  public $token;
  public $siteId;
  public $type;
  public $geneticAlgorithm_oid;

  public function __construct($analytics_oid, $token, $siteId, $type, $geneticAlgorithm_oid)
  {
    $this->analytics_oid = $analytics_oid;
    $this->token = $token;
    $this->siteId = $siteId;
    $this->type = $type;
    $this->geneticAlgorithm_oid = $geneticAlgorithm_oid;
  }
}
?>
