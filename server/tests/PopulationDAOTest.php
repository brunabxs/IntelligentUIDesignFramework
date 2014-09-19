<?php
include_once 'MyUnit_Framework_TestCase.php';
class PopulationDAOTest extends MyUnit_Framework_TestCase
{
  public function testCreate_populationSize3_mustCreate3Individuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->populationSize = 3;

    $populationDAO = $this->mockPopulationDAO();
    $populationDAO->individualDAO = $this->mockIndividualDAO();
    $populationDAO->individualDAO->expects($this->any())
                                 ->method('create')
                                 ->will($this->returnValue('INDIVIDUAL_INSTANCE'));

    // Act
    $population = $populationDAO->create($ga, 1);

    // Assert
    $this->assertEquals(1, $population->generation);
    $this->assertEquals(3, count($population->individuals));
  }

  public function testConvertToJSON_oneIndividual_jsonMustContainsGenerationAndOneGenome()
  {
    // Arrange
    $individual1 = new Individual('000', '{}', null);
    $population = new Population(2, array($individual1));

    // Act
    $json = PopulationDAO::convertToJSON($population);

    // Assert
    $this->assertEquals('{"generation":2,"individuals":["000"]}', $json);
  }

  public function testConvertToJSON_twoIndividualsWithSameGenome_jsonMustContainsGenerationAndTwoGenomes()
  {
    // Arrange
    $individual1 = new Individual('000', '{}', null);
    $individual2 = new Individual('010', '{}', null);
    $population = new Population(2, array($individual1, $individual2));

    // Act
    $json = PopulationDAO::convertToJSON($population);

    // Assert
    $this->assertEquals('{"generation":2,"individuals":["000","010"]}', $json);
  }

  public function testConvertToJSON_twoIndividualsWithDifferentGenome_jsonMustContainsGenerationAndTwoGenomes()
  {
    // Arrange
    $individual1 = new Individual('011', '{}', null);
    $individual2 = new Individual('011', '{}', null);
    $population = new Population(12, array($individual1, $individual2));

    // Act
    $json = PopulationDAO::convertToJSON($population);

    // Assert
    $this->assertEquals('{"generation":12,"individuals":["011","011"]}', $json);
  }

  public function testGetFile_fileNameMustContainsGeneration()
  {
    // Arrange
    $dir = self::$tempDir;
    $generation = 0;
    
    // Act
    $fileName = PopulationDAO::getFile($dir, $generation);

    // Assert
    $this->assertEquals($dir . '0-GA.json', $fileName);
  }

  public function testSave_fileNameMustContainsGeneration()
  {
    // Arrange
    $dir = self::$tempDir;
    $individual1 = new Individual('011', '{}', null);
    $individual2 = new Individual('000', '{}', null);
    $population = new Population(12, array($individual1, $individual2));

    $populationDAO = $this->mockPopulationDAO();
    $populationDAO->individualDAO = $this->mockIndividualDAO();

    // Act
    $populationDAO->save($dir, $population);

    // Assert
    $this->assertEquals(1, self::countFiles($dir));
    $this->assertTrue(self::containsFile($dir, '12-GA.json'));
  }

  public function testSave_fileMustContainsPropertiesOfPopulation()
  {
    // Arrange
    $dir = self::$tempDir;
    $individual1 = new Individual('011', '{}', null);
    $individual2 = new Individual('000', '{}', null);
    $population = new Population(1, array($individual1, $individual2));

    $populationDAO = $this->mockPopulationDAO();
    $populationDAO->individualDAO = $this->mockIndividualDAO();

    // Act
    $populationDAO->save($dir, $population);

    // Assert
    $this->assertEquals('{"generation":1,"individuals":["011","000"]}', file_get_contents($dir . '1-GA.json'));
  }

  protected function mockPopulationDAO()
  {
    $dao = $this->getMockBuilder('PopulationDAO')
               ->disableOriginalConstructor()
               ->setMethods(NULL)
               ->getMock();
    return $dao;
  }

  protected function mockIndividualDAO()
  {
    $dao = $this->getMockBuilder('IndividualDAO')
               ->disableOriginalConstructor()
               ->getMock();
    return $dao;
  }
}
?>
