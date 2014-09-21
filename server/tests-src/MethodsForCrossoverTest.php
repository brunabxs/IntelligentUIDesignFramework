<?php
include_once 'MyUnit_Framework_TestCase.php';
class MethodsForCrossoverTest extends MyUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnTwoGenomesDifferentFromParents()
  {
    // Arrange
    $genome1 = '000';
    $genome2 = '111';
    MethodsForCrossover::$prob = 1;

    // Act
    $newGenomes = MethodsForCrossover::simple($genome1, $genome2, 1);

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
    MethodsForCrossover::$prob = 1;

    // Act
    $newGenomes = MethodsForCrossover::simple($genome1, $genome2, 0);

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
    MethodsForCrossover::$prob = 1;

    // Act
    $newGenomes = MethodsForCrossover::simple($genome1, $genome2, 2);

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
    MethodsForCrossover::$prob = 1;

    // Act
    $newGenomes = MethodsForCrossover::simple($genome1, $genome2);

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
    MethodsForCrossover::$prob = 0;

    // Act
    $newGenomes = MethodsForCrossover::simple($genome1, $genome2);

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
    MethodsForCrossover::$prob = 0;

    // Act & Assert
    try
    {
      $newGenomes = MethodsForCrossover::simple($genome1, $genome2);
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
