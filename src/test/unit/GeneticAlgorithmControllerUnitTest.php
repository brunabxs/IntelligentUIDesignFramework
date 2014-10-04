<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GeneticAlgorithmControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testCountGenomes_genomesArrayWithTwoDifferentGenomes_mustReturnListWithTwoGenomes()
  {
    // Arrange
    $genomesArray = array('000', '111');

    // Act
    $genomes = self::callMethod('GeneticAlgorithmController', 'countGenomes', array($genomesArray));

    // Assert
    $this->assertEquals(2, count($genomes));
    $this->assertEquals(1, $genomes['000']);
    $this->assertEquals(1, $genomes['111']);
  }

  public function testCountGenomes_genomesArrayWithTwoEqualGenomes_mustReturnListWithOneGenome()
  {
    // Arrange
    $genomesArray = array('000', '000');

    // Act
    $genomes = self::callMethod('GeneticAlgorithmController', 'countGenomes', array($genomesArray));

    // Assert
    $this->assertEquals(1, count($genomes));
    $this->assertEquals(2, $genomes['000']);
  }
}
?>
