<?php
class UserDAO extends AbstractDAO
{
  public function __constructor()
  {
    parent::__constructor();
  }

  public function loadById($id)
  {
    return parent::loadInstance('User', array(array('user_oid', $id)));
  }

  public function persist()
  {
    return parent::persistInstance('User', 'user_oid');
  }

  public function update()
  {
    return parent::updateInstance('User', 'user_oid');
  }
}
?>
