<?php
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

  public function testCreate_geneticAlgorithmWithPopulationTwoWithDifferentGenomes_mustPersistTwoIndividualsWithQuantityOne()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController(array('generateGenome'));
    $geneticAlgorithmController->method('generateGenome')->will($this->onConsecutiveCalls('01', '11'));
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1", "class2"]}');

    // Assert
    $this->assertActualAndExpectedTablesEqual('Individual', 'SELECT genome, quantity from Individual');
  }

  public function testCreate_geneticAlgorithmWithPopulationTwoAndWithEqualGenomes_mustPersistOneIndividualWithQuantityTwo()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController(array('generateGenome'));
    $geneticAlgorithmController->method('generateGenome')->will($this->onConsecutiveCalls('01', '01'));
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $geneticAlgorithmController->create($user, 2, '{"h1":["class1", "class2"]}');

    // Assert
    $this->assertActualAndExpectedTablesEqual('Individual', 'SELECT genome, quantity from Individual');
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
    $this->assertEquals('{"generation":"0","genome":"10","properties":{"h1":"class1","h2":""}}', $json);
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

  public function testGetBestIndividuals_oneGenerationWithTwoIndividualsBothWithScore_mustReturnArrayWithOneEntryWithIndividualWithHighestScoreForGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $code = '123456';

    // Act
    $bestIndividuals = $geneticAlgorithmController->getBestIndividuals($code);

    // Assert
    $this->assertEquals(array(0=>'{"h1":"class1","h2":"class2"}'), $bestIndividuals);
  }

  public function testGetBestIndividuals_oneGenerationWithTwoIndividualsJustOneWithScore_mustReturnArrayWithOneEntryWithIndividualWithScoreForGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $code = '123456';

    // Act
    $bestIndividuals = $geneticAlgorithmController->getBestIndividuals($code);

    // Assert
    $this->assertEquals(array(0=>'{"h1":"class1","h2":"class2"}'), $bestIndividuals);
  }

  public function testGetBestIndividuals_oneGenerationWithTwoIndividualsNoneWithScore_mustReturnArrayWithNullEntryForGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $code = '123456';

    // Act
    $bestIndividuals = $geneticAlgorithmController->getBestIndividuals($code);

    // Assert
    $this->assertEquals(array(0=>null), $bestIndividuals);
  }

  public function testGetBestIndividuals_twoGenerations_mustReturnArrayWithTwoEntriesWithIndividualWithHighestScoreForGeneration()
  {
    // Arrange
    $geneticAlgorithmController = $this->mockGeneticAlgorithmController();
    $code = '123456';

    // Act
    $bestIndividuals = $geneticAlgorithmController->getBestIndividuals($code);

    // Assert
    $this->assertEquals(array(0=>'{"h1":""}', 1=>null), $bestIndividuals);
  }

  private function mockGeneticAlgorithmController($methods=NULL)
  {
    $mock = $this->getMockBuilder('GeneticAlgorithmController')
                 ->setMethods($methods)
                 ->getMock();

    $mock->scoreController = $this->mockScoreController();

    return $mock;
  }

  private function mockScoreController()
  {
    $mock = $this->getMockBuilder('ScoreController')
                 ->setMethods(array('calculateScore'))
                 ->getMock();
    $mock->method('calculateScore')->will($this->onConsecutiveCalls(2, 3, 5, 8));

    return $mock;
  }
}
?>
