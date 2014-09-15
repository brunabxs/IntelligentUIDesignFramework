<?php
include_once 'MyUnit_Framework_TestCase.php';
class IndividualTest extends MyUnit_Framework_TestCase
{
  public function testConstructor_genomeEmpty_genomeMustBeCreated()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 2;
    $genome = '';

    // Act
    $individual = new Individual($ga, $genome);

    // Assert
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConstructor_genomeNotEmpty_genomeMustNotBeCreated()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 2;
    $genome = '11';

    // Act
    $individual = new Individual($ga, $genome);

    // Assert
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConvertToJSON_oneElementWithOneClass()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->individualsProperties = json_decode('{"h1":["class1"]}');

    // Act
    $json00 = (new Individual($ga, '00'))->convertToJSON();
    $json01 = (new Individual($ga, '01'))->convertToJSON();
    $json10 = (new Individual($ga, '10'))->convertToJSON();
    $json11 = (new Individual($ga, '11'))->convertToJSON();

    // Assert
    $this->assertEquals('{"h1":"class1"}', $json00);
    $this->assertEquals('{"h1":""}', $json01);
    $this->assertEquals('{"h1":""}', $json10);
    $this->assertEquals('{"h1":""}', $json11);
  }

  public function testConvertToJSON_oneElementWithTwoClasses()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->individualsProperties = json_decode('{"h1":["class1","class2"]}');

    // Act
    $json00 = (new Individual($ga, '00'))->convertToJSON();
    $json01 = (new Individual($ga, '01'))->convertToJSON();
    $json10 = (new Individual($ga, '10'))->convertToJSON();
    $json11 = (new Individual($ga, '11'))->convertToJSON();

    // Assert
    $this->assertEquals('{"h1":"class1"}', $json00);
    $this->assertEquals('{"h1":"class2"}', $json01);
    $this->assertEquals('{"h1":""}', $json10);
    $this->assertEquals('{"h1":""}', $json11);
  }

  public function testConvertToJSON_oneElementWithThreeClasses()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->individualsProperties = json_decode('{"h1":["class1","class2","class3"]}');

    // Act
    $json00 = (new Individual($ga, '00'))->convertToJSON();
    $json01 = (new Individual($ga, '01'))->convertToJSON();
    $json10 = (new Individual($ga, '10'))->convertToJSON();
    $json11 = (new Individual($ga, '11'))->convertToJSON();

    // Assert
    $this->assertEquals('{"h1":"class1"}', $json00);
    $this->assertEquals('{"h1":"class2"}', $json01);
    $this->assertEquals('{"h1":"class3"}', $json10);
    $this->assertEquals('{"h1":""}', $json11);
  }

  public function testSave_fileNameMustContainsGenome()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->individualsProperties = json_decode('{"h1":["class1"]}');
    $dir = self::$tempDir;

    // Act
    (new Individual($ga, '00'))->save($dir);

    // Assert
    $this->assertEquals(1, self::countFiles($dir));
    $this->assertTrue(self::containsFile($dir, '00.json'));
  }

  public function testSave_fileMustContainsIndividualInformation()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->individualsProperties = json_decode('{"h1":["class1"]}');
    $dir = self::$tempDir;

    // Act
    (new Individual($ga, '00'))->save($dir);

    // Assert
    $this->assertEquals('__AppConfig={"h1":"class1"}', file_get_contents($dir . '00.json'));
  }
}
?>