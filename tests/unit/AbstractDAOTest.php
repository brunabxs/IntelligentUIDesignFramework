<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class AbstractDAOTest extends MyAnotherUnit_Framework_TestCase
{
  public function testGetClassAttributes_classUser_mustReturnAllAttributes()
  {
    // Arrange
    $entity = 'User';

    // Act
    $attributes = AbstractDAO::getClassAttributes($entity);

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
    $query = AbstractDAO::getSelectQuery($entity, array($parameter1));

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email from User where user_oid=\'123\'', $query);
  }

  public function testGetSelectQuery_twoParameters()
  {
    // Arrange
    $entity = 'User';
    $parameter1 = array('user_oid', '123');
    $parameter2 = array('name', 'user');

    // Act
    $query = AbstractDAO::getSelectQuery($entity, array($parameter1, $parameter2));

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email from User where user_oid=\'123\' and name=\'user\'', $query);
  }

  public function testGetSelectQuery_noParameter()
  {
    // Arrange
    $entity = 'User';

    // Act
    $query = AbstractDAO::getSelectQuery($entity, array());

    // Assert
    $this->assertEquals('SELECT user_oid, name, password, email from User', $query);
  }

  public function testGetInstance_userEntity()
  {
    // Arrange
    $entity = 'User';
    $params = array('123', 'user0', '123456', 'user0@users.com');

    // Act
    $instance = AbstractDAO::getInstance($entity, $params);

    // Assert
    $this->assertNotNull($instance);
    $this->assertEquals('123', $instance->user_oid);
    $this->assertEquals('user0', $instance->name);
    $this->assertEquals('123456', $instance->password);
    $this->assertEquals('user0@users.com', $instance->email);
  }
}
?>
