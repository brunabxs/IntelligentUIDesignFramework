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

  public function testCreate_withGenomes_mustCreateIndividualsWithSelectedGenomes()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->properties = array("h1"=>array("class1"));

    $genomes = array("0", "1", "0");

    $populationDAO = $this->mockPopulationDAO();
    $populationDAO->individualDAO = $this->mockIndividualDAO();

    // Act
    $population = $populationDAO->create($ga, 1, $genomes);

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

  public function testLoad_fourIndividuals_mustLoadFourIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->properties = array("h1"=>array("class1", "class2"));
    $generation = 1;

    $populationDAO = new PopulationDAO();

    // Act
    $population = $populationDAO->load(self::$datasetDir, $ga, $generation);

    // Assert
    $this->assertEquals(1, $population->generation);
    $this->assertEquals(4, count($population->individuals));
  }

  public function testLoadLastGeneration_fourIndividuals_mustLoadFourIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->properties = array("h1"=>array("class1", "class2"));

    $populationDAO = new PopulationDAO();

    // Act
    $population = $populationDAO->loadLastGeneration(self::$datasetDir, $ga);

    // Assert
    $this->assertEquals(2, $population->generation);
    $this->assertEquals(4, count($population->individuals));
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

  public function testGetLastGeneration_onePopulation()
  {
    $this->assertEquals(0, PopulationDAO::getLastGeneration(self::$datasetDir));
  }

  public function testGetLastGeneration_twoConsecutivesPopulations()
  {
    $this->assertEquals(2, PopulationDAO::getLastGeneration(self::$datasetDir));
  }

  public function testGetLastGeneration_twoNonConsecutivesPopulations()
  {
    $this->assertEquals(5, PopulationDAO::getLastGeneration(self::$datasetDir));
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
