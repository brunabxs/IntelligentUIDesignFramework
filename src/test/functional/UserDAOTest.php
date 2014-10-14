<?php
include_once 'MyDatabase_TestCase.php';
class UserDAOTest extends MyDatabase_TestCase
{
  private static $table = 'User';
  private static $query1 = 'SELECT user_oid, name, password, email FROM User';
  private static $query2 = 'SELECT name, password, email FROM User';

  public function testLoadById_userWithUserOidThatExists_mustSetInstanceToUserObject()
  {
    // Arrange
    $userDAO = new UserDAO();

    // Act
    $userDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($userDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $userDAO->instance->user_oid);
    $this->assertEquals('user1', $userDAO->instance->name);
    $this->assertEquals('password1', $userDAO->instance->password);
    $this->assertEquals('user1@users.com', $userDAO->instance->email);
  }

  public function testLoadById_userWithUserOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $userDAO = new UserDAO();

    // Act
    $userDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($userDAO->instance);
  }

  public function testPersist_userWithUserOidNullWithNameThatDoesNotExist_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User(null, 'user2', 'password2', 'user2@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_userWithUserOidNullWithNameThatExists_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User(null, 'user1', 'password2', 'user2@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_userWithUserOidNotNull_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000002', 'user2', 'newpasword', 'user2@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_userWithUserOidNull_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User(null, 'user1', 'password2', 'user2@users.com');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_userWithUserOidNotNullThatDoesNotExist_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000002', 'user1', 'password2', 'user2@users.com');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_userWithUserOidNotNullThatExists_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000001', 'user2', 'password2', 'user2@users.com');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_processWithNameThatExists_mustSetUserInstance()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User(null, 'user1', null, null);

    // Act
    $result = $userDAO->sync();

    // Assert
    $this->assertNotNull($userDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $userDAO->instance->user_oid);
    $this->assertEquals('user1', $userDAO->instance->name);
    $this->assertEquals('password1', $userDAO->instance->password);
    $this->assertEquals('user1@users.com', $userDAO->instance->email);
  }

  public function testSync_processWithNameThatDoesNotExist_mustSetUserInstanceToNull()
  {
    // Arrange
    $userDAO = new UserDAO();
    $userDAO->instance = new User(null, 'user2', null, null);

    // Act
    $result = $userDAO->sync();

    // Assert
    $this->assertNull($userDAO->instance);
  }
}
?>
