<?php
include_once 'MyUnit_Framework_TestCase.php';
class IndividualDAOTest extends MyUnit_Framework_TestCase
{
  public function testCreate_genomeEmpty_genomeMustBeCreated()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 2;
    $ga->properties = json_decode('{"h1":["class1","class2"]}');

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
    $ga->properties = json_decode('{"h1":["class1","class2"]}');

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

  public function testLoad_fourFiles_mustLoadFourIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->properties = array("h1"=>array("class1"), "h2"=>array("class2"));
    $generation = 1;
    $genomes = array("10", "11", "00", "10");

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individuals = $individualDAO->load(self::$datasetDir, $ga, $generation, $genomes);

    // Assert
    $this->assertEquals(4, count($individuals));
    $this->assertEquals('10', $individuals[0]->genome);
    $this->assertEquals('11', $individuals[1]->genome);
    $this->assertEquals('00', $individuals[2]->genome);
    $this->assertEquals('10', $individuals[3]->genome);
  }

  public function testLoad_oneFileWithOneIndividual_mustLoadOneIndividual()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->properties = array("h1"=>array("class1"), "h2"=>array("class2"));
    $generation = 5;
    $genomes = array("10");

    $individualDAO = $this->mockIndividualDAO();

    // Act
    $individuals = $individualDAO->load(self::$datasetDir, $ga, $generation, $genomes);

    // Assert
    $this->assertEquals(1, count($individuals));
    $this->assertEquals('10', $individuals[0]->genome);
    $this->assertEquals('{"h1":"","h2":"class2"}', $individuals[0]->properties);
    $this->assertNull($individuals[0]->score);
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
