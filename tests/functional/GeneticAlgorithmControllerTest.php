<?php
include_once 'MyDatabase_TestCase.php';
class GeneticAlgorithmControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistGeneticAlgorithm()
  {
    // Arrange
    $geneticAlgorithmController = new GeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('GeneticAlgorithm');

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $queryTable = $this->getConnection()->createQueryTable('GeneticAlgorithm', 'SELECT populationSize, genomeSize, methodForSelection, methodForCrossover, methodForMutation, properties, user_oid from GeneticAlgorithm');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testCreate_mustSyncGeneticAlgorithm()
  {
    // Arrange
    $geneticAlgorithmController = new GeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertNotNull($geneticAlgorithmController->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
  }

  public function testCreate_mustPersistGenerationWithNumber0()
  {
    // Arrange
    $geneticAlgorithmController = new GeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Generation');

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $queryTable = $this->getConnection()->createQueryTable('Generation', 'SELECT number from Generation');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testCreate_mustSyncGeneration()
  {
    // Arrange
    $geneticAlgorithmController = new GeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertNotNull($geneticAlgorithmController->generationDAO->instance->generation_oid);
  }

  public function testCreate_mustPersist4Individuals()
  {
    // Arrange
    $geneticAlgorithmController = new GeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 4, '{"h1":["class1", "class2"]}');

    // Assert
    $this->assertEquals(4, $this->getConnection()->getRowCount('Individual'));
  }
}
?>
