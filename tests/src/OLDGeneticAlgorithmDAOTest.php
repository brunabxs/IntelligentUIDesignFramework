<?php
include_once 'MyUnit_Framework_TestCase.php';
class OLDGeneticAlgorithmDAOTest extends MyUnit_Framework_TestCase
{


  public function testCreate_fileDoesNotExist_mustCreateFile()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $dir = self::$tempDir;
    $populationSize = 2;
    $properties = '{"h1":["class1", "class2"]; "h2":["class1", "class2"]}';
    $methodForSelection = 'roulette';
    $methodForCrossover = 'simple';
    $methodForMutation = 'simple';

    // Act
    $ga = $gaDAO->create($dir, $populationSize, $properties, $methodForSelection, $methodForCrossover, $methodForMutation);

    // Assert
    $this->assertEquals(1, self::countFiles($dir));
    $this->assertEquals(1, self::containsFile($dir, 'properties.json'));
  }

  public function testCreate_fileExists_mustNotCreateFile()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $dir = self::$datasetDir;
    $populationSize = 2;
    $properties = '{"h1":["class1", "class2"]; "h2":["class1", "class2"]}';
    $methodForSelection = 'roulette';
    $methodForCrossover = 'simple';
    $methodForMutation = 'simple';

    // Act
    try
    {
      $ga = $gaDAO->create($dir, $populationSize, $properties, $methodForSelection, $methodForCrossover, $methodForMutation);
      $this->fail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertEquals('Genetic Algorithm properties file already created', $e->getMessage());
      return;
    }

    $this->fail('Exception expected');
  }

  public function testGetFile()
  {
    // Arrange
    $dir = self::$tempDir;

    // Act
    $fileName = GeneticAlgorithmDAO::getFile($dir);

    // Assert
    $this->assertEquals($dir . 'properties.json', $fileName);
  }

  public function testLoad_generation1_mustLoadGeneration1()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $gaDAO->populationDAO = $this->mockPopulationDAO();
    $gaDAO->populationDAO->expects($this->any())
                         ->method('load')
                         ->will($this->returnValue('POPULATION_INSTANCE'));

    // Act
    $ga = $gaDAO->load(self::$datasetDir, 1);

    // Assert
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(3, $ga->populationSize);
    $this->assertEquals(array("h1"=>array("class1", "class2")), $ga->properties);
    $this->assertEquals('roulette', $ga->methodForSelection);
    $this->assertEquals('simple', $ga->methodForCrossover);
    $this->assertEquals('simple', $ga->methodForMutation);
    $this->assertEquals('POPULATION_INSTANCE', $ga->population);
  }

  public function testLoad_noGeneration_mustLoadLastGeneration()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $gaDAO->populationDAO = $this->mockPopulationDAO();
    $gaDAO->populationDAO->expects($this->any())
                         ->method('load')
                         ->will($this->returnValue('POPULATION_INSTANCE'));

    // Act
    $ga = $gaDAO->load(self::$datasetDir);

    // Assert
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(3, $ga->populationSize);
    $this->assertEquals(array("h1"=>array("class1", "class2")), $ga->properties);
    $this->assertEquals('roulette', $ga->methodForSelection);
    $this->assertEquals('simple', $ga->methodForCrossover);
    $this->assertEquals('simple', $ga->methodForMutation);
    $this->assertEquals('POPULATION_INSTANCE', $ga->population);
  }

  public function testLoad_generation100_mustLoadLastGeneration()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $gaDAO->populationDAO = $this->mockPopulationDAO();
    $gaDAO->populationDAO->expects($this->any())
                         ->method('load')
                         ->will($this->returnValue('POPULATION_INSTANCE'));

    // Act
    $ga = $gaDAO->load(self::$datasetDir, 100);

    // Assert
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(3, $ga->populationSize);
    $this->assertEquals(array("h1"=>array("class1", "class2")), $ga->properties);
    $this->assertEquals('roulette', $ga->methodForSelection);
    $this->assertEquals('simple', $ga->methodForCrossover);
    $this->assertEquals('simple', $ga->methodForMutation);
    $this->assertEquals('POPULATION_INSTANCE', $ga->population);
  }

  public function testLoad_noGeneration_mustStartGeneration()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $gaDAO->populationDAO = $this->mockPopulationDAO();
    $gaDAO->populationDAO->expects($this->any())
                         ->method('create')
                         ->will($this->returnValue('POPULATION_INSTANCE'));

    // Act
    $ga = $gaDAO->load(self::$datasetDir);

    // Assert
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(3, $ga->populationSize);
    $this->assertEquals(array("h1"=>array("class1", "class2")), $ga->properties);
    $this->assertEquals('roulette', $ga->methodForSelection);
    $this->assertEquals('simple', $ga->methodForCrossover);
    $this->assertEquals('simple', $ga->methodForMutation);
    $this->assertEquals('POPULATION_INSTANCE', $ga->population);
  }

  protected function mockGeneticAlgorithmDAO()
  {
    $dao = $this->getMockBuilder('GeneticAlgorithmDAO')
               ->disableOriginalConstructor()
               ->setMethods(NULL)
               ->getMock();
    return $dao;
  }

  protected function mockPopulationDAO()
  {
    $dao = $this->getMockBuilder('PopulationDAO')
               ->disableOriginalConstructor()
               ->getMock();
    return $dao;
  }
}
?>
