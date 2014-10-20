<?php
class Process
{
  public $process_oid;
  public $analyticsConfiguration;
  public $serverConfiguration;
  public $clientConfiguration;
  public $user_oid;

  public function __construct($process_oid, $analyticsConfiguration, $serverConfiguration, $clientConfiguration, $user_oid)
  {
    $this->process_oid = $process_oid;
    $this->analyticsConfiguration = $analyticsConfiguration;
    $this->serverConfiguration = $serverConfiguration;
    $this->clientConfiguration = $clientConfiguration;
    $this->user_oid = $user_oid;
  }
}
?>
