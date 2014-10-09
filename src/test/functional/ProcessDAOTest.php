<?php
include_once 'MyDatabase_TestCase.php';
class ProcessDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_processWithProcessOidThatExists_mustSetInstanceToProcessObject()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();

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
    $processDAO = $this->mockProcessDAO();

    // Act
    $processDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($processDAO->instance);
  }

  public function testPersist_processWithDifferentUserOid_mustSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('Process'));
  }

  public function testPersist_processWithSameUserOid_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Process'));
  }

  public function testPersist_processWithProcessOidNotNullThatDoesNotExist_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000001', '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Process'));
  }

  public function testUpdate_processWithProcessOidNull_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process(null, '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Process'));
  }

  public function testUpdate_processWithProcessOidNotNullThatDoesNotExist_mustNotSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000002', '0', '0', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Process'));
  }

  public function testUpdate_processWithProcessOidNotNullThatExists_mustSaveProcessInstance()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process('00000000-0000-0000-0000-000000000001', '0', '0', '0', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Process');

    // Act
    $result = $processDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('Process', 'SELECT process_oid, serverConfiguration, clientConfiguration, scheduleNextGeneration, user_oid FROM Process');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_processExists_mustSetProcessInstanceByUserOid()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
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

  public function testSync_processDoesNotExist_mustSetProcessInstanceToNull()
  {
    // Arrange
    $processDAO = $this->mockProcessDAO();
    $processDAO->instance = new Process(null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $processDAO->sync();

    // Assert
    $this->assertNull($processDAO->instance);
  }

  protected function mockProcessDAO()
  {
    $stub = $this->getMockBuilder('ProcessDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
