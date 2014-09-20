<?php
include_once 'MyUnit_Framework_TestCase.php';
class MethodsForMutationTest extends MyUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $genome = '01';
    MethodsForMutation::$prob = 1;

    // Act
    $mutatedGenome = MethodsForMutation::simple($genome, 1);

    // Assert
    $this->assertEquals('00', $mutatedGenome);
  }

  public function testSimple_noPoint_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $genome = '01';
    MethodsForMutation::$prob = 1;

    // Act
    $mutatedGenome = MethodsForMutation::simple($genome, 1);

    // Assert
    $this->assertNotEquals('01', $mutatedGenome);
  }

  public function testSimple_noMutation_mustReturnIndividualWithSameGenome()
  {
    // Arrange
    $genome = '01';
    MethodsForMutation::$prob = 0;

    // Act
    $mutatedGenome = MethodsForMutation::simple($genome);

    // Assert
    $this->assertEquals('01', $mutatedGenome);
  }
}
?>
