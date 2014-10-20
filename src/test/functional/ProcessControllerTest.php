<?php
class ProcessControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistProcess()
  {
    // Arrange
    $processController = new ProcessController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $processController->create($user);

    // Assert
    $this->assertActualAndExpectedTablesEqual('Process', 'SELECT serverConfiguration, analyticsConfiguration, clientConfiguration, user_oid from Process');
  }

  public function testCreate_mustSyncProcess()
  {
    // Arrange
    $processController = new ProcessController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $processController->create($user);

    // Assert
    $this->assertNotNull($processController->processDAO->instance->process_oid);
  }

  public function testLoad_processDoesNotExist_mustCreateProcessInstance()
  {
    // Arrange
    $processController = new ProcessController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $processController->load($user);

    // Assert
    $this->assertActualAndExpectedTablesEqual('Process', 'SELECT serverConfiguration, analyticsConfiguration, clientConfiguration, user_oid from Process');
    $this->assertNotNull($processController->processDAO->instance);
    $this->assertEquals('0', $processController->processDAO->instance->serverConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->analyticsConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->clientConfiguration);
  }

  public function testLoad_processExists_mustLoadProcessInstance()
  {
    // Arrange
    $processController = new ProcessController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $processController->load($user);

    // Assert
    $this->assertNotNull($processController->processDAO->instance);
    $this->assertEquals('1', $processController->processDAO->instance->serverConfiguration);
    $this->assertEquals('1', $processController->processDAO->instance->analyticsConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->clientConfiguration);
  }

  public function testUpdate()
  {
    // Arrange
    $processController = new ProcessController();
    $processController->processDAO->loadById('00000000-0000-0000-0000-000000000001');
    $processController->processDAO->instance->clientConfiguration = '1';

    // Act
    $processController->update();

    // Assert
    $this->assertActualAndExpectedTablesEqual('Process', 'SELECT process_oid, serverConfiguration, analyticsConfiguration, clientConfiguration, user_oid from Process');
  }
}
?>
