<?php
include_once 'MyUnit_Framework_TestCase.php';
class GeneticAlgorithmTest extends MyUnit_Framework_TestCase
{
  public function testConstructor_loadInformationsFromJSON()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1"]}',
                  'generation' => 2,
                  'populationSize' => 4,
                  'genomeSize' => 3,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));

    // Act
    $ga = new GeneticAlgorithm($json);

    // Assert
    $this->assertEquals(json_decode('{"h1":["class1"]}'), $ga->individualsProperties);
    $this->assertEquals(2, $ga->generation);
    $this->assertEquals(4, $ga->populationSize);
    $this->assertEquals(3, $ga->genomeSize);
    $this->assertEquals('roulette', $ga->selectionMethod);
    $this->assertEquals('simple', $ga->crossoverMethod);
    $this->assertEquals(null, $ga->population);
  }

  public function testConstructor_generation0TriggersIndividualsCreation()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1"]}',
                  'generation' => 0,
                  'populationSize' => 4,
                  'genomeSize' => 3,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));
    GeneticAlgorithm::$dir = self::$tempDir;

    // Act
    $ga = new GeneticAlgorithm($json);

    // Assert
    $this->assertEquals(4, count($ga->population));
    $this->assertEquals(4, self::countFiles(self::$tempDir));
  }

  public function testLoadIndividuals_generation1WithTwoIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->generation = 1;
    $ga->genomeSize = 2;
    GeneticAlgorithm::$dir = self::$datasetDir;

    // Act
    $ga->loadIndividuals();

    // Assert
    $this->assertEquals(2, count($ga->population));
  }

  public function testSaveIndividuals_twoIndividuals_fileNameMustContainsGenerationAndIndividualIndexNumber()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->generation = 2;
    $ga->individualsProperties = json_decode('{"h1":["class1"]}');
    $ga->population = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $ga->saveIndividuals(self::$tempDir);

    // Assert
    $this->assertTrue(self::containsFile(self::$tempDir, '2-0-01.json'));
    $this->assertTrue(self::containsFile(self::$tempDir, '2-1-10.json'));
  }

  public function testSave_generation2_fileNameMustContainsGeneration()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1"]}',
                  'generation' => 2,
                  'populationSize' => 2,
                  'genomeSize' => 2,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));
    $ga = new GeneticAlgorithm($json);
    $ga->population = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $ga->save(self::$tempDir);

    // Assert
    $this->assertEquals(1, self::countFiles(self::$tempDir));
    $this->assertTrue(self::containsFile(self::$tempDir, '2-GA.json'));
  }

  public function testSelectIndividuals_populationSize2_rouletteAsSelectionMethodMustSelectTwoIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->selectionMethod = 'roulette';
    $ga->population = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $selectedIndividuals = $ga->selectIndividuals();

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
  }

  public function testGenerateIndividuals_populationSize2_mustGenerateTwoIndividuals()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1"]}',
                  'generation' => 1,
                  'populationSize' => 2,
                  'genomeSize' => 2,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));
    $ga = new GeneticAlgorithm($json);
    $ga->population = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $generatedIndividuals = $ga->generateIndividuals();

    // Assert
    $this->assertEquals(2, count($generatedIndividuals));
  }

  public function testGenerateIndividuals_generation2_generatedIndividualsMustBeFromGeneration3()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1"]}',
                  'generation' => 2,
                  'populationSize' => 2,
                  'genomeSize' => 2,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));
    $ga = new GeneticAlgorithm($json);
    $ga->population = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $generatedIndividuals = $ga->generateIndividuals();

    // Assert
    $this->assertEquals(2, $ga->generation);
    $this->assertEquals(3, $generatedIndividuals[0]->ga->generation);
    $this->assertEquals(3, $generatedIndividuals[1]->ga->generation);
  }
}
?>