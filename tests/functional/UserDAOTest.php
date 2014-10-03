<?php
include_once 'MyDatabase_TestCase.php';
class UserDAOTest extends MyDatabase_TestCase
{
  public function testLoadInstance_userWithUserOidThatExists_mustSetInstanceToUserObject()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();

    // Act
    $userDAO->loadInstance('9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

    // Assert
    $this->assertNotNull($userDAO->instance);
    $this->assertEquals('9d3f75d2-4a72-11e4-b320-000df0ba9bdc', $userDAO->instance->user_oid);
    $this->assertEquals('user1', $userDAO->instance->name);
    $this->assertEquals('user1@users.com', $userDAO->instance->email);
  }

  public function testLoadInstance_userWithUserOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();

    // Act
    $userDAO->loadInstance('4afaacf8-4a71-11e4-b320-000df0ba9bdc');

    // Assert
    $this->assertNull($userDAO->instance);
  }

  public function testPersistInstance_userWithDifferentName_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'username', 123456, 'username@users.com');

    // Act
    $result = $userDAO->persistInstance();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('User'));
  }

  public function testPersistInstance_userWithSameName_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'user1', 123456, 'user1@users.com');

    // Act
    $result = $userDAO->persistInstance();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testPersistInstance_userWithUserOidNotNullThatDoesNotExist_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('4afaacf8-4a71-11e4-b320-000df0ba9bdc', 'user2', 123456, 'user2@users.com');

    // Act
    $result = $userDAO->persistInstance();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdateInstance_userWithUserOidNull_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('4afaacf8-4a71-11e4-b320-000df0ba9bdc', 'user2', 123456, 'user2@users.com');

    // Act
    $result = $userDAO->updateInstance();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdateInstance_userWithUserOidNotNullThatDoesNotExist_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('4afaacf8-4a71-11e4-b320-000df0ba9bdc', 'user2', 123456, 'user2@users.com');

    // Act
    $result = $userDAO->updateInstance();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdateInstance_userWithUserOidNotNullThatExists_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('9d3f75d2-4a72-11e4-b320-000df0ba9bdc', 'user2', '123456', 'user2@users.com');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('User');

    // Act
    $result = $userDAO->updateInstance();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('User', 'SELECT user_oid, name, password, email FROM User');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  protected function mockUserDAO()
  {
    $stub = $this->getMockBuilder('UserDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
