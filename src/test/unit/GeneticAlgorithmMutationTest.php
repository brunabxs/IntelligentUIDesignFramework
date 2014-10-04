<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GeneticAlgorithmMutationTest extends MyAnotherUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $genome = '01';
    $point = 1;
    GeneticAlgorithmMutation::$prob = 1;

    // Act
    $mutatedGenome = self::callMethod('GeneticAlgorithmMutation', 'simple', array($genome, $point));

    // Assert
    $this->assertEquals('00', $mutatedGenome);
  }

  public function testSimple_noPoint_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $genome = '01';
    $point = 1;
    GeneticAlgorithmMutation::$prob = 1;

    // Act
    $mutatedGenome = self::callMethod('GeneticAlgorithmMutation', 'simple', array($genome, $point));

    // Assert
    $this->assertNotEquals('01', $mutatedGenome);
  }

  public function testSimple_noMutation_mustReturnIndividualWithSameGenome()
  {
    // Arrange
    $genome = '01';
    GeneticAlgorithmMutation::$prob = 0;

    // Act
    $mutatedGenome = self::callMethod('GeneticAlgorithmMutation', 'simple', array($genome));

    // Assert
    $this->assertEquals('01', $mutatedGenome);
  }
}
?>
