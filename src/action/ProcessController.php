<?php
class ProcessController
{
  public $processDAO;

  public function __construct()
  {
    $this->processDAO = new ProcessDAO();
  }

  public function load($user)
  {
    $process = new Process(null, null, null, null, $user->user_oid);
    $this->processDAO->setInstance($process);
    $this->processDAO->sync();

    if ($this->processDAO->instance === null)
    {
      $this->create($user);
    }
  }

  public function update()
  {
    $this->processDAO->update();
  }

  public function create($user)
  {
    $process = new Process(null, '0', '0', '0', $user->user_oid);
    $this->processDAO->setInstance($process);
    $this->processDAO->persist();
    $this->processDAO->sync();
  }
}
?>
