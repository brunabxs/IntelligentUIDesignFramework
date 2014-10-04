<?php
class User
{
  public $user_oid;
  public $name;
  public $password;
  public $email;

  public function __construct($user_oid, $name, $password, $email)
  {
    $this->user_oid = $user_oid;
    $this->name = $name;
    $this->password = $password;
    $this->email = $email;
  }
}
?>
