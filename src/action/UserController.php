<?php
class UserController
{
  public $userDAO;

  public function __construct()
  {
    $this->userDAO = new UserDAO();
  }

  public function login($name, $password)
  {
    $user = new User(null, $name, null, null);
    $this->userDAO->instance = $user;
    $this->userDAO->sync();

    if ($this->userDAO->instance !== null)
    {
      if ($this->userDAO->instance->password === self::encrypt($password))
      {
        return $this->userDAO->instance;
      }
      else
      {
        $this->userDAO->instance = null;
        throw new Exception('Password is not correct');
      }
    }
    else
    {
      throw new Exception('User does not exist');
    }
  }

  public function create($name, $password)
  {
    $user = new User(null, $name, self::encrypt($password), null);
    $this->userDAO->instance = $user;
    $this->userDAO->persist();
    $this->userDAO->sync();
    return $this->userDAO->instance;
  }

  private static function encrypt($data)
  {
    return md5($data);
  }
}
?>
