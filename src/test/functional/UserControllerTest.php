<?php
include_once 'MyDatabase_TestCase.php';
class UserControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistUser()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123456';

    // Act
    $user = $userController->create($name, $password);

    // Assert
    $this->assertActualAndExpectedTablesEqual('User', 'SELECT name, password from User');
  }

  public function testCreate_mustSyncUser()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123456';

    // Act
    $user = $userController->create($name, $password);

    // Assert
    $this->assertNotNull($user);
    $this->assertNotNull($userController->userDAO->instance->user_oid);
  }

  public function testCreate_mustPersistEncryptedPassword()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123456';

    // Act
    $user = $userController->create($name, $password);

    // Assert
    $this->assertActualAndExpectedTablesEqual('User', 'SELECT password from User');
  }

  public function testCreate_userExists_mustThrowsException()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123456';

    // Act & Arrange
    try
    {
      $userController->create($name, $password);
      $this->fail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertNull($userController->userDAO->instance);
      $this->assertEquals('User already exists', $e->getMessage());
      return;
    }

    $this->fail('Exception expected');
  }

  public function testLogin_userDoesNotExist_mustThrowsException()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user2';
    $password = '123456';

    // Act & Arrange
    try
    {
      $userController->login($name, $password);
      $this->fail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertNull($userController->userDAO->instance);
      $this->assertEquals('User does not exist', $e->getMessage());
      return;
    }

    $this->fail('Exception expected');
  }

  public function testLogin_userExistsAndPasswordIsCorrect_mustLoadUser()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123456';

    // Act
    $user = $userController->login($name, $password);

    // Assert
    $this->assertNotNull($user);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testLogin_userExistsAndPasswordIsNotCorrect_mustThrowsException()
  {
    // Arrange
    $userController = new UserController();
    $name = 'user1';
    $password = '123457';

    // Act & Arrange
    try
    {
      $userController->login($name, $password);
      $this->fail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertNull($userController->userDAO->instance);
      $this->assertEquals('Password is not correct', $e->getMessage());
      return;
    }

    $this->fail('Exception expected');
  }
}
?>
