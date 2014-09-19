<?php
include_once 'MyUnit_Framework_TestCase.php';
class IndividualDAOTest extends MyUnit_Framework_TestCase
{
  public function testCreate_genomeEmpty_genomeMustBeCreated()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 2;
    $ga->individualsProperties = json_decode('{"h1":["class1","class2"]}');

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individual = $individualDAO->create($ga);

    // Assert
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testCreate_genomeNotEmpty_genomeMustNotBeCreated()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 2;
    $genome = '11';
    $ga->individualsProperties = json_decode('{"h1":["class1","class2"]}');

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individual = $individualDAO->create($ga, $genome);

    // Assert
    $this->assertEquals(2, strlen($individual->genome));
    $this->assertEquals('11', $individual->genome);
  }

  public function testConvertToJSON_oneElement_jsonMustContainsGenerationGenomeAndProperties()
  {
    // Arrange
    $individual = new Individual('00', '{"h1":"class1"}', null);

    // Act
    $json = IndividualDAO::convertToJSON(0, $individual);

    // Assert
    $this->assertEquals('{"generation":0,"genome":"00","properties":{"h1":"class1"}}', $json);
  }

  public function testConvertToJSON_twoElements_jsonMustContainsGenerationGenomeAndProperties()
  {
    // Arrange
    $individual = new Individual('0001', '{"h1":"class1","h2":"class2"}', null);

    // Act
    $json = IndividualDAO::convertToJSON(3, $individual);

    // Assert
    $this->assertEquals('{"generation":3,"genome":"0001","properties":{"h1":"class1","h2":"class2"}}', $json);
  }

  public function testGetFile_fileNameMustContainsGenerationIndexAndGenome()
  {
    // Arrange
    $dir = self::$tempDir;
    $generation = 0;
    $index = 1;
    $genome = '0101';

    // Act
    $fileName = IndividualDAO::getFile($dir, $generation, $index, $genome);

    // Assert
    $this->assertEquals($dir . '0-1-0101.json', $fileName);
  }

  public function testSave_fileNameMustContainsGenerationIndexAndGenome()
  {
    // Arrange
    $dir = self::$tempDir;
    $generation = 0;
    $index = 1;
    $individual = new Individual('0100', '{"h1":"class2","h2":"class1"}', null);

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individualDAO->save($dir, $generation, $index, $individual);

    // Assert
    $this->assertEquals(1, self::countFiles($dir));
    $this->assertTrue(self::containsFile($dir, '0-1-0100.json'));
  }

  public function testSave_fileMustContainsPropertiesOfIndividual()
  {
    // Arrange
    $dir = self::$tempDir;
    $generation = 0;
    $index = 1;
    $individual = new Individual('00', '{"h1":"class1"}', null);

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individualDAO->save($dir, $generation, $index, $individual);

    // Assert
    $this->assertEquals('__AppConfig={"generation":0,"genome":"00","properties":{"h1":"class1"}}', file_get_contents($dir . '0-1-00.json'));
  }

  protected function mockIndividualDAO()
  {
    $dao = $this->getMockBuilder('IndividualDAO')
               ->disableOriginalConstructor()
               ->setMethods(NULL)
               ->getMock();
    return $dao;
  }
}
?>
