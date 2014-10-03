<?php
class UserDAO extends AbstractDAO
{
  public function __constructor()
  {
    parent::__constructor();
  }

  public function loadInstanceById($id)
  {
    return parent::loadInstance('User', array(array('user_oid', $id)));
  }

  public function persistInstance()
  {
    $result = null;
    if ($this->instance->user_oid == null)
    {
      $values = '\'' . $this->instance->name . '\',' . $this->instance->password . ',\'' . $this->instance->email . '\'';
      $result = Database::executeInsertQuery('INSERT INTO User (user_oid, name, password, email) VALUES (UUID(), ' . $values . ')');
    }
    return $result;
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
