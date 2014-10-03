<?php
class UserDAO
{
  public $instance = null;

  public function __constructor()
  {
    $this->instance = null;
  }

  public function loadInstance($id)
  {
    $result = Database::executeSelectQuery('SELECT * from User where user_oid = \'' . $id . '\'');
    if (count($result) === 1)
    {
      $result = $result[0];
      $this->instance = new User($result['user_oid'], $result['name'], $result['password'], $result['email']);
    }
    else
    {
      $this->instance = null;
    }
    return $result;
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
