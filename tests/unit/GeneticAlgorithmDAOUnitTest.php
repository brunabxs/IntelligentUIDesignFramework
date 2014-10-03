<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GeneticAlgorithmDAOUnitTest extends MyAnotherUnit_Framework_TestCase
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
}
?>
