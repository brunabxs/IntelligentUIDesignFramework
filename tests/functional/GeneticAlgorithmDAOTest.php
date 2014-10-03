<?php
include_once 'MyDatabase_TestCase.php';
class GeneticAlgorithmDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatExists_mustSetInstanceToGeneticAlgorithmObject()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('9d3f75d2-4a72-11e4-b320-000df0ba9bdc', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('h1:class1', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('9d3f75d2-4a72-11e4-b320-000df0ba9bdc', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('4afaacf8-4a71-11e4-b320-000df0ba9bdc');

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }

  public function testPersist_geneticAlgorithmWithDifferentUserOid_mustSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', 'h1:class1', '4afaacf8-4a71-11e4-b320-000df0ba9bdc');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('GeneticAlgorithm'));
  }

  public function testPersist_geneticAlgorithmWithSameUOid_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = $this->mockGeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', 'h1:class1', '9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

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
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('4afaacf8-4a71-11e4-b320-000df0ba9bdc', '2', '2', 'roullete', 'simple', 'simple', 'h1:class1', '9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

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
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '2', '2', 'roullete', 'simple', 'simple', 'h1:class1', '9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

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
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('4afaacf8-4a71-11e4-b320-000df0ba9bdc', '2', '2', 'roullete', 'simple', 'simple', 'h1:class1', '9d3f75d2-4a72-11e4-b320-000df0ba9bdc');

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
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('9d3f75d2-4a72-11e4-b320-000df0ba9bdc', '4', '4', 'roulette', 'simple2', 'simple2', 'h2:class2', '4afaacf8-4a71-11e4-b320-000df0ba9bdc');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('GeneticAlgorithm');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('GeneticAlgorithm', AbstractDAO::getSelectQuery('GeneticAlgorithm', array()));
    $this->assertTablesEqual($expectedTable, $queryTable);
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
