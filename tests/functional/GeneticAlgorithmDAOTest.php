<?php
include_once 'MyDatabase_TestCase.php';
class GeneticAlgorithmDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatExists_mustSetInstanceToGeneticAlgorithmObject()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('{"h1":["class1"],"h2":["class2"]}', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }

  public function testPersist_geneticAlgorithmWithDifferentUserOid_mustSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testPersist_geneticAlgorithmWithSameUserOid_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNotNullThatDoesNotExist_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000002', '2', '2', 'roullete', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNull_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNotNullThatDoesNotExist_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000002', '2', '2', 'roullete', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNotNullThatExists_mustSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', '4', '4', 'roulette2', 'simple2', 'simple2', '{"h1":["class1","class2"],"h2":["class3","class4"]}', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('GeneticAlgorithm');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('GeneticAlgorithm', 'SELECT geneticAlgorithm_oid, populationSize, genomeSize, methodForSelection, methodForCrossover, methodForMutation, properties, user_oid FROM GeneticAlgorithm');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_geneticAlgorithmExists_mustSetGeneticAlgorithmInstanceByUserOid()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('{"h1":["class1"],"h2":["class2"]}', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testSync_geneticAlgorithmDoesNotExist_mustSetGeneticAlgorithmInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }

  protected function mockGeneticAlgorithmDAO()
  {
    $stub = $this->getMockBuilder('GeneticAlgorithmDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
