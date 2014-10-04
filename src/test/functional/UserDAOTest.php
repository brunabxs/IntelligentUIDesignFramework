<?php
include_once 'MyDatabase_TestCase.php';
class UserDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_userWithUserOidThatExists_mustSetInstanceToUserObject()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();

    // Act
    $userDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($userDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $userDAO->instance->user_oid);
    $this->assertEquals('user1', $userDAO->instance->name);
    $this->assertEquals('user1@users.com', $userDAO->instance->email);
  }

  public function testLoadById_userWithUserOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();

    // Act
    $userDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($userDAO->instance);
  }

  public function testPersist_userWithDifferentName_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'newuser', 'newpassword', 'newuser@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('User'));
  }

  public function testPersist_userWithSameName_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'user1', 'newpassword', 'newuser@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testPersist_userWithUserOidNotNullThatDoesNotExist_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000002', 'newuser', 'newpasword', 'newuser@users.com');

    // Act
    $result = $userDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdate_userWithUserOidNull_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'user1', 'newpassword', 'newuser@users.com');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdate_userWithUserOidNotNullThatDoesNotExist_mustNotSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000002', 'user1', 'newpassword', 'newuser@users.com');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('User'));
  }

  public function testUpdate_userWithUserOidNotNullThatExists_mustSaveUserInstance()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User('00000000-0000-0000-0000-000000000001', 'newuser', 'newpassword', 'newuser@users.com');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('User');

    // Act
    $result = $userDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('User', 'SELECT user_oid, name, password, email FROM User');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_userExists_mustSetUserInstanceByName()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'user1', null, null);

    // Act
    $result = $userDAO->sync();

    // Assert
    $this->assertNotNull($userDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $userDAO->instance->user_oid);
    $this->assertEquals('user1', $userDAO->instance->name);
    $this->assertEquals('user1@users.com', $userDAO->instance->email);
  }

  public function testSync_userDoesNotExist_mustSetUserInstanceToNull()
  {
    // Arrange
    $userDAO = $this->mockUserDAO();
    $userDAO->instance = new User(null, 'newuser', null, null);

    // Act
    $result = $userDAO->sync();

    // Assert
    $this->assertNull($userDAO->instance);
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