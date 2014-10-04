<?php
include_once 'MyDatabase_TestCase.php';
class IndividualDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_individualWithIndividualOidThatExists_mustSetInstanceToIndividualObject()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individualDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($individualDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->individual_oid);
    $this->assertEquals('0', $individualDAO->instance->genome);
    $this->assertEquals('{"h1":[]}', $individualDAO->instance->properties);
    $this->assertEquals('1', $individualDAO->instance->generationFraction);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->generation_oid);
  }

  public function testLoadById_individualWithIndividualOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individualDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($individualDAO->instance);
  }

  public function testPersist_individualWithDifferentGenomeAndSameGenerationOid_mustSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual(null, '1', '{"h1":["class1"]}', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('Individual'));
  }

  public function testPersist_individualWithSameGenomeAndSameGenerationOid_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual(null, '0', '{"h1":[]}', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Individual'));
  }

  public function testPersist_individualWithIndividualOidNotNullThatDoesNotExist_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000002', '0', '{"h1":[]}', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Individual'));
  }

  public function testUpdate_individualWithIndividualOidNull_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual(null, '0', '{"h1":[]}', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Individual'));
  }

  public function testUpdate_individualWithIndividualOidNotNullThatDoesNotExist_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000002', '0', '{"h1":[]}', '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Individual'));
  }

  public function testUpdate_individualWithIndividualOidNotNullThatExists_mustSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000001', '1', '{"h1":["class1"]}', '1', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Individual');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('Individual', 'SELECT individual_oid, genome, properties, generationFraction, generation_oid FROM Individual');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_individualExists_mustSetIndividualInstanceByGenomeAndGenerationOid()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual(null, '0', null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->sync();

    // Assert
    $this->assertNotNull($individualDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->individual_oid);
    $this->assertEquals('0', $individualDAO->instance->genome);
    $this->assertEquals('{"h1":[]}', $individualDAO->instance->properties);
    $this->assertEquals('1', $individualDAO->instance->generationFraction);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->generation_oid);
  }

  public function testSync_individualDoesNotExist_mustSetIndividualInstanceToNull()
  {
    // Arrange
    $individualDAO = $this->mockIndividualDAO();
    $individualDAO->instance = new Individual(null, '1', null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->sync();

    // Assert
    $this->assertNull($individualDAO->instance);
  }

  protected function mockIndividualDAO()
  {
    $stub = $this->getMockBuilder('IndividualDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
