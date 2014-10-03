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

  public function updateInstance()
  {
    $result = null;
    if ($this->instance->user_oid != null)
    {
      $values = 'user_oid=\'' . $this->instance->user_oid . '\', ' .
                'name=\'' . $this->instance->name . '\',' .
                'password=' . $this->instance->password . ',' .
                'email=\'' . $this->instance->email . '\'';
      $result = Database::executeUpdateQuery('UPDATE User SET ' . $values . ' WHERE user_oid = \'' . $this->instance->user_oid. '\'');
    }
    return $result;
  }
}
?>
