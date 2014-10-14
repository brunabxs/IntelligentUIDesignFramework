<?php
class UserDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('User', 'user_oid');
  }

  public function sync()
  {
    return parent::load(array(array('name', $this->instance->name)));
  }
}
?>
