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

  public function testCreate_generationMustBe0()
  {
    // Arrange
    $gaDAO = $this->mockGeneticAlgorithmDAO();
    $gaDAO->populationDAO = $this->mockPopulationDAO();
    $gaDAO->populationDAO->expects($this->any())
                         ->method('create')
                         ->will($this->returnValue('POPULATION_INSTANCE'));
    $populationSize = 3;
    $individualProperties = array("h1"=>array("class1","class2"));
    $selectionMethod = 'SelectionMethod::roulette';
    $crossoverMethod = 'CrossoverMethod::simple';
    $mutationMethod = 'MutationMethod::simple';

    // Act
    $ga = $gaDAO->create($populationSize, $individualProperties, $selectionMethod, $crossoverMethod, $mutationMethod);

    // Assert
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(3, $ga->populationSize);
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
