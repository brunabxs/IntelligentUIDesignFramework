<?php
include_once 'MyDatabase_TestCase.php';
class ProcessControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistProcess()
  {
    // Arrange
    $processController = new ProcessController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Process');

    // Act
    $processController->create($user);

    // Assert
    $queryTable = $this->getConnection()->createQueryTable('Process', 'SELECT serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid from Process');
    $this->assertTablesEqual($expectedTable, $queryTable);
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
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Process');

    // Act
    $processController->load($user);

    // Assert
    $queryTable = $this->getConnection()->createQueryTable('Process', 'SELECT serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid from Process');
    $this->assertTablesEqual($expectedTable, $queryTable);
    $this->assertNotNull($processController->processDAO->instance);
    $this->assertEquals('0', $processController->processDAO->instance->serverConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->clientConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->scheduleNextGeneration);
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
    $this->assertEquals('0', $processController->processDAO->instance->clientConfiguration);
    $this->assertEquals('0', $processController->processDAO->instance->scheduleNextGeneration);
  }

  public function testUpdate()
  {
    // Arrange
    $processController = new ProcessController();
    $processController->processDAO->loadById('00000000-0000-0000-0000-000000000001');
    $processController->processDAO->instance->clientConfiguration = '1';
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Process');

    // Act
    $processController->update();

    // Assert
    $queryTable = $this->getConnection()->createQueryTable('Process', 'SELECT process_oid, serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid from Process');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }
}
?>
