<?php
class ProcessDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('Process', 'process_oid');
  }

  public function sync()
  {
    return parent::load(array(array('user_oid', $this->instance->user_oid)));
  }
}
?>
