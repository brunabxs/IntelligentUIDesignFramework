<?php
include_once 'MyDatabase_TestCase.php';
class ProcessDAOTest extends MyDatabase_TestCase
{
  private static $table = 'Process';
  private static $query1 = 'SELECT process_oid, serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid FROM Process';
  private static $query2 = 'SELECT serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid FROM Process';

  public function testLoadById_processWithProcessOidThatExists_mustSetInstanceToProcessObject()
  {
    // Arrange
    $processDAO = new ProcessDAO();

    // Act
    $processDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($processDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $processDAO->instance->process_oid);
    $this->assertEquals('1', $processDAO->instance->serverConfiguration);
    $this->assertEquals('0', $processDAO->instance->clientConfiguration);
    $this->assertEquals('0', $processDAO->instance->scheduleNextGeneration);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $processDAO->instance->user_oid);
  }

  public function testLoadById_processWithProcessOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $processDAO = new ProcessDAO();

    // Act
    $processDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($processDAO->instance);
  }

  public function testPersist_processWithProcessOidNullWithUserOidThatDoesNotExist_mustSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_processWithProcessOidNullWithUserOidThatExists_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_processWithProcessOidNotNull_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000002', '0', '0', '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_processWithProcessOidNull_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_processWithProcessOidNotNullThatDoesNotExist_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000002', '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_processWithProcessOidNotNullThatExists_mustSaveProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000001', '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_processWithUserOidThatExists_mustSetProcessInstance()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process(null, null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->sync();

    // Assert
    $this->assertNotNull($processDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $processDAO->instance->process_oid);
    $this->assertEquals('1', $processDAO->instance->serverConfiguration);
    $this->assertEquals('0', $processDAO->instance->clientConfiguration);
    $this->assertEquals('0', $processDAO->instance->scheduleNextGeneration);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $processDAO->instance->user_oid);
  }

  public function testSync_processWithUserOidThatDoesNotExist_mustSetProcessInstanceToNull()
  {
    // Arrange
    $processDAO = new ProcessDAO();
    $processDAO->instance = new Process(null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $processDAO->sync();

    // Assert
    $this->assertNull($processDAO->instance);
  }
}
?>
