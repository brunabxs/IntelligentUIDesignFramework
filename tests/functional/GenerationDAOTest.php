<?php
include_once 'MyDatabase_TestCase.php';
class GenerationDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_generationWithGenerationOidThatExists_mustSetInstanceToGenerationObject()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();

    // Act
    $generationDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->generation_oid);
    $this->assertEquals('0', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testLoadById_generationWithGenerationOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();

    // Act
    $generationDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($generationDAO->instance);
  }

  public function testPersist_generationWithDifferentNumberAndSameGeneticAlgorithmOid_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('Generation'));
  }

  public function testPersist_generationWithSameNumberAndOtherGeneticAlgorithmOid_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('Generation'));
  }

  public function testPersist_generationWithSameNumberAndSameGeneticAlgorithmOid_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Generation'));
  }

  public function testPersist_generationWithGenerationOidNotNullThatDoesNotExist_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000002', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Generation'));
  }

  public function testUpdate_generationWithGenerationOidNull_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Generation'));
  }

  public function testUpdate_generationWithGenerationOidNotNullThatDoesNotExist_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000002', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Generation'));
  }

  public function testUpdate_generationWithGenerationOidNotNullThatExists_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000001', '1', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Generation');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('Generation', 'SELECT generation_oid, number, geneticAlgorithm_oid FROM Generation');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_generationExists_mustSetGenerationInstanceByNumberAndGeneticAlgorithmOid()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->sync();

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->generation_oid);
    $this->assertEquals('0', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testSync_generationDoesNotExist_mustSetGenerationInstanceToNull()
  {
    // Arrange
    $generationDAO = $this->mockGenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->sync();

    // Assert
    $this->assertNull($generationDAO->instance);
  }

  protected function mockGenerationDAO()
  {
    $stub = $this->getMockBuilder('GenerationDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
