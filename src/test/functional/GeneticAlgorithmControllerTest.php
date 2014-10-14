<?php
include_once 'MyDatabase_TestCase.php';
class GeneticAlgorithmControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistGeneticAlgorithm()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertActualAndExpectedTablesEqual('GeneticAlgorithm', 'SELECT populationSize, genomeSize, methodForSelection, methodForCrossover, methodForMutation, properties, user_oid from GeneticAlgorithm');
  }

  public function testCreate_mustSyncGeneticAlgorithm()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertNotNull($geneticAlgorithmController->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
  }

  public function testCreate_mustPersistGenerationWithNumber0()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertActualAndExpectedTablesEqual('Generation', 'SELECT number from Generation');
  }

  public function testCreate_mustSyncGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1"]}');

    // Assert
    $this->assertNotNull($geneticAlgorithmController->generationDAO->instance->generation_oid);
  }

  public function testCreateNextGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();

    // Act
    $geneticAlgorithmController->createNextGeneration('123456');

    // Assert
    $this->assertEquals(1, $this->getConnection()->getRowCount('GeneticAlgorithm'));
    $this->assertEquals(2, $this->getConnection()->getRowCount('Generation'));
  }

  public function testExportIndividualJSON_generationAndIndividualCodeWithGenerationAndGenomeThatExist_mustReturnIndividualProperties()
  {
    // Arrange
    $geneticAlgorithmCode = '123456';
    $generationAndIndividualCode = '0.10';
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();

    // Act
    $json = $geneticAlgorithmController->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);

    // Assert
    $this->assertEquals('{"generation":0,"genome":"10","properties":{"h1":"class1","h2":""}}', $json);
  }

  public function testExportIndividualJSON_generationAndIndividualCodeWithGenomeThatDoesNotExist_mustReturnRandomIndividualPropertiesFromLastGeneration()
  {
    // Arrange
    $geneticAlgorithmCode = '123456';
    $generationAndIndividualCode = '0.00';
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();

    // Act
    $json = $geneticAlgorithmController->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);

    // Assert
    $this->assertNotNull($json);
  }

  public function testExportIndividualJSON_generationAndIndividualCodeWithGenerationThatDoesNotExist_mustReturnRandomIndividualPropertiesFromLastGeneration()
  {
    // Arrange
    $geneticAlgorithmCode = '123456';
    $generationAndIndividualCode = '3.10';
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();

    // Act
    $json = $geneticAlgorithmController->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);

    // Assert
    $this->assertNotNull($json);
  }

  public function testExportIndividualJSON_emptyGenerationAndIndividualCode_mustReturnRandomIndividualPropertiesFromLastGeneration()
  {
    // Arrange
    $geneticAlgorithmCode = '123456';
    $generationAndIndividualCode = '';
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();

    // Act
    $json = $geneticAlgorithmController->exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode);

    // Assert
    $this->assertNotNull($json);
  }

  public function testLoad()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->load($user);

    // Assert
    $this->assertNotNull($geneticAlgorithmController->geneticAlgorithmDAO->instance);
  }

  private function mockGeneticAlgorithmController()
  {
    $mock = $this->getMockBuilder('GeneticAlgorithmController')
                 ->setMethods(NULL)
                 ->getMock();

    $mock->scoreController = $this->mockScoreController();

    return $mock;
  }

  private function mockScoreController()
  {
    $mock = $this->getMockBuilder('ScoreController')
                 ->setMethods(array('getScore'))
                 ->getMock();

    $mock->method('getScore')
         ->will($this->onConsecutiveCalls(2, 3, 5, 8));

    return $mock;
  }
}
?>
