<?php
class Process
{
  public $process_oid;
  public $serverConfiguration;
  public $clientConfiguration;
  public $scheduleNextGeneration;
  public $user_oid;

  public function __construct($process_oid, $serverConfiguration, $clientConfiguration, $scheduleNextGeneration, $user_oid)
  {
    $this->process_oid = $process_oid;
    $this->serverConfiguration = $serverConfiguration;
    $this->clientConfiguration = $clientConfiguration;
    $this->scheduleNextGeneration = $scheduleNextGeneration;
    $this->user_oid = $user_oid;
  }
}
?>
