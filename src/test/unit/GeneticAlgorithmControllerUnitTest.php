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

  public function testGenerateJSON()
  {
    // Arrange
    $generation = new Generation(null, 0, null);
    $individual = new Individual(null, '01', '{"h1":"","h2":"class2"}', null, null, null);

    // Act
    $json = self::callMethod('GeneticAlgorithmController', 'generateJSON', array($generation, $individual));

    // Assert
    $this->assertEquals('{"generation":0,"genome":"01","properties":{"h1":"","h2":"class2"}}', $json);
  }
}
?>
