<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GeneticAlgorithmCrossoverTest extends MyAnotherUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnTwoGenomesDifferentFromParents()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    $point = 1;
    GeneticAlgorithmCrossover::$prob = 1;

    // Act
    $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2, $point));

    // Assert
    $this->assertEquals(2, count($newGenomes));
    $this->assertEquals('001', $newGenomes[0]);
    $this->assertEquals('110', $newGenomes[1]);
  }

  public function testSimple_point0_mustReturnTwoGenomesDifferentFromParents()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    $point = 0;
    GeneticAlgorithmCrossover::$prob = 1;

    // Act
    $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2, $point));

    // Assert
    $this->assertEquals(2, count($newGenomes));
    $this->assertEquals('011', $newGenomes[0]);
    $this->assertEquals('100', $newGenomes[1]);
  }

  public function testSimple_point2_mustReturnTwoGenomesEqualsToParents()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    $point = '2';
    GeneticAlgorithmCrossover::$prob = 1;

    // Act
    $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2, $point));

    // Assert
    $this->assertEquals(2, count($newGenomes));
    $this->assertEquals('000', $newGenomes[0]);
    $this->assertEquals('111', $newGenomes[1]);
  }

  public function testSimple_noPoint_mustReturnTwoGenomes()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    GeneticAlgorithmCrossover::$prob = 1;

    // Act
    $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2));

    // Assert
    $this->assertEquals(2, count($newGenomes));
    $this->assertEquals(3, strlen($newGenomes[0]));
    $this->assertEquals(3, strlen($newGenomes[1]));
  }

  public function testSimple_noCrossover_mustReturnSameGenomes()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    GeneticAlgorithmCrossover::$prob = 0;

    // Act
    $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2));

    // Assert
    $this->assertEquals(2, count($newGenomes));
    $this->assertEquals(3, strlen($newGenomes[0]));
    $this->assertEquals('000', $newGenomes[0]);
    $this->assertEquals('111', $newGenomes[1]);
  }

  public function testSimple_genomesWithDifferentSize_mustThrowsException()
  {
    // Arrange
    $genome1 = '00';
    $genome2 = '111';
    GeneticAlgorithmCrossover::$prob = 0;

    // Act & Assert
    try
    {
      $newGenomes = self::callMethod('GeneticAlgorithmCrossover', 'simple', array($genome1, $genome2));
      $this->fail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertEquals('Genomes with different length', $e->getMessage());
      return;
    }

    $this->fail('Exception expected');
  }
}
?>
