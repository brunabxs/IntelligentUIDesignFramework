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
