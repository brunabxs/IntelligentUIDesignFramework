<?php
include_once 'MyUnit_Framework_TestCase.php';
class GeneticAlgorithmTest extends MyUnit_Framework_TestCase
{
  public function testConstructor_newGA_buildFirstGeneration()
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

    // Act
    $ga = new GeneticAlgorithm($json);

    // Assert
    $this->assertEquals(json_decode('{"h1":["class1"]}'), $ga->individualsProperties);
    $this->assertEquals(0, $ga->generation);
    $this->assertEquals(4, $ga->populationSize);
    $this->assertEquals(3, $ga->genomeSize);
    $this->assertEquals('roulette', $ga->selectionMethod);
    $this->assertEquals('simple', $ga->crossoverMethod);
    $this->assertEquals(4, count($ga->population));
  }

  public function testConstructor_loadGA_reloadSecondGeneration()
  {
    // Arrange
    $json = array('individualsProperties' => '{"h1":["class1","class2"]}',
                  'generation' => 1,
                  'populationSize' => 2,
                  'genomeSize' => 3,
                  'selectionMethod' => 'roulette',
                  'crossoverMethod' => 'simple'
                 );
    $json = json_decode(json_encode($json));
    GeneticAlgorithm::$dir = self::$datasetDir;

    // Act
    $ga = new GeneticAlgorithm($json);

    // Assert
    $this->assertEquals(json_decode('{"h1":["class1","class2"]}'), $ga->individualsProperties);
    $this->assertEquals(1, $ga->generation);
    $this->assertEquals(2, $ga->populationSize);
    $this->assertEquals(3, $ga->genomeSize);
    $this->assertEquals('roulette', $ga->selectionMethod);
    $this->assertEquals('simple', $ga->crossoverMethod);
    $this->assertEquals(2, count($ga->population));
  }

  public function testSaveIndividuals_twoIndividuals_fileNameMustContainsGenerationAndIndividualIndexNumber()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->generation = 2;
    $ga->individualsProperties = json_decode('{"h1":["class1"]}');
    $ga->individuals = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));

    // Act
    $ga->saveIndividuals(self::$tempDir);

    // Assert
    $this->assertTrue(self::containsFile(self::$tempDir, '2-0-01.json'));
    $this->assertTrue(self::containsFile(self::$tempDir, '2-1-10.json'));
  }
}
?>