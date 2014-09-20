<?php
include_once 'MyUnit_Framework_TestCase.php';
class GeneticAlgorithmDAOTest extends MyUnit_Framework_TestCase
{
  public function testGenerateGenomeSize_oneElementWithOneClass_genomeSizeMustBe1()
  {
    // Arrange
    $properties = array("h1"=>array("class1"));

    // Act
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);

    // Assert
    $this->assertEquals(1, $genomeSize);
  }

  public function testGenerateGenomeSize_oneElementWithTwoClasses_genomeSizeMustBe2()
  {
    // Arrange
    $properties = array("h1"=>array("class1", "class2"));

    // Act
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);

    // Assert
    $this->assertEquals(2, $genomeSize);
  }

  public function testGenerateGenomeSize_twoElementsWithOneClassEach_genomeSizeMustBe2()
  {
    // Arrange
    $properties = array("h1"=>array("class1"), "h2"=>array("class2"));

    // Act
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);

    // Assert
    $this->assertEquals(2, $genomeSize);
  }

  public function testGenerateGenomeSize_twoElementsWithTwoClassesEach_genomeSizeMustBe4()
  {
    // Arrange
    $properties = array("h1"=>array("class1", "class2"), "h2"=>array("class3", "class4"));

    // Act
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);

    // Assert
    $this->assertEquals(4, $genomeSize);
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
    $this->assertEquals('SelectionMethod::roulette', $ga->selectionMethod);
    $this->assertEquals('CrossoverMethod::simple', $ga->crossoverMethod);
    $this->assertEquals('MutationMethod::simple', $ga->mutationMethod);
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
    $this->assertEquals('SelectionMethod::roulette', $ga->selectionMethod);
    $this->assertEquals('CrossoverMethod::simple', $ga->crossoverMethod);
    $this->assertEquals('MutationMethod::simple', $ga->mutationMethod);
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
    $this->assertEquals('SelectionMethod::roulette', $ga->selectionMethod);
    $this->assertEquals('CrossoverMethod::simple', $ga->crossoverMethod);
    $this->assertEquals('MutationMethod::simple', $ga->mutationMethod);
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
    $this->assertEquals('SelectionMethod::roulette', $ga->selectionMethod);
    $this->assertEquals('CrossoverMethod::simple', $ga->crossoverMethod);
    $this->assertEquals('MutationMethod::simple', $ga->mutationMethod);
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
