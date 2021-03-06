<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class AbstractDAOUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testGetClassAttributes_classUser_mustReturnAllAttributes()
  {
    // Arrange
    $entity = 'User';

    // Act
    $attributes = self::callMethod('AbstractDAO', 'getClassAttributes', array($entity));

    // Assert
    $this->assertEquals(4, count($attributes));
    $this->assertEquals('user_oid', $attributes[0]);
    $this->assertEquals('name', $attributes[1]);
    $this->assertEquals('password', $attributes[2]);
    $this->assertEquals('email', $attributes[3]);
  }

  public function testGetSelectQuery_oneParameter()
  {
    // Arrange
    $entity = 'User';
    $parameter1 = array('user_oid', '123');

    // Act
    $query = self::callMethod('AbstractDAO', 'getSelectQuery', array($entity, array($parameter1)));

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email FROM User WHERE user_oid=\'123\'', $query);
  }

  public function testGetSelectQuery_twoParameters()
  {
    // Arrange
    $entity = 'User';
    $parameter1 = array('user_oid', '123');
    $parameter2 = array('name', 'user');

    // Act
    $query = self::callMethod('AbstractDAO', 'getSelectQuery', array($entity, array($parameter1, $parameter2)));

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email FROM User WHERE user_oid=\'123\' AND name=\'user\'', $query);
  }

  public function testGetSelectQuery_noParameter()
  {
    // Arrange
    $entity = 'User';

    // Act
    $query = self::callMethod('AbstractDAO', 'getSelectQuery', array($entity, array()));

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email FROM User', $query);
  }

  public function testGetInsertQuery_allInstancesAttributeSet()
  {
    // Arrange
    $entity = 'User';
    $instance = new User(null, 'user', 'pass', 'user@users.com');
    $key = 'user_oid';

    // Act
    $query = self::callMethod('AbstractDAO', 'getInsertQuery', array($entity, $instance, $key));

    // Assert
    $this->assertEquals('INSERT INTO User (user_oid, name, password, email) VALUES (UUID(), \'user\', \'pass\', \'user@users.com\')', $query);
  }

  public function testGetInsertQuery_oneInstancesAttributeSet()
  {
    // Arrange
    $entity = 'User';
    $instance = new User(null, 'user', null, null);
    $key = 'user_oid';

    // Act
    $query = self::callMethod('AbstractDAO', 'getInsertQuery', array($entity, $instance, $key));

    // Assert
    $this->assertEquals('INSERT INTO User (user_oid, name, password, email) VALUES (UUID(), \'user\', null, null)', $query);
  }

  public function testGetInsertQuery_noInstancesAttributeSet()
  {
    // Arrange
    $entity = 'User';
    $instance = new User(null, null, null, null);
    $key = 'user_oid';

    // Act
    $query = self::callMethod('AbstractDAO', 'getInsertQuery', array($entity, $instance, $key));

    // Assert
    $this->assertEquals('INSERT INTO User (user_oid, name, password, email) VALUES (UUID(), null, null, null)', $query);
  }

  public function testGetUpdateQuery_allInstancesAttributeSet()
  {
    // Arrange
    $entity = 'User';
    $instance = new User('12345', 'userA', 'passA', 'userA@users.com');
    $key = 'user_oid';

    // Act
    $query = self::callMethod('AbstractDAO', 'getUpdateQuery', array($entity, $instance, $key));

    // Assert
    $this->assertEquals('UPDATE User SET user_oid=\'12345\', name=\'userA\', password=\'passA\', email=\'userA@users.com\' WHERE user_oid=\'12345\'', $query);
  }

  public function testGetUpdateQuery_noInstancesAttributeSet()
  {
    // Arrange
    $entity = 'User';
    $instance = new User('12345', null, null, null);
    $key = 'user_oid';

    // Act
    $query = self::callMethod('AbstractDAO', 'getUpdateQuery', array($entity, $instance, $key));

    // Assert
    $this->assertEquals('UPDATE User SET user_oid=\'12345\', name=null, password=null, email=null WHERE user_oid=\'12345\'', $query);
  }

  public function testInitInstance_userEntity()
  {
    // Arrange
    $entity = 'User';
    $params = array('123', 'user0', '123456', 'user0@users.com');

    // Act
    $instance = self::callMethod('AbstractDAO', 'initInstance', array($entity, $params));

    // Assert
    $this->assertNotNull($instance);
    $this->assertEquals('123', $instance->user_oid);
    $this->assertEquals('user0', $instance->name);
    $this->assertEquals('123456', $instance->password);
    $this->assertEquals('user0@users.com', $instance->email);
  }
}
?>
