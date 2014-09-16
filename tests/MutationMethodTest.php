<?php
include_once 'MyUnit_Framework_TestCase.php';
class MutationMethodTest extends MyUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $individual = new Individual($ga, '01');
    MutationMethod::$prob = 1;

    // Act
    $mutatedIndividual = MutationMethod::simple($ga, $individual, 1);

    // Assert
    $this->assertEquals('00', $mutatedIndividual->genome);
  }

  public function testSimple_noPoint_mustReturnIndividualWithGenomeDifferentFromParents()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $individual = new Individual($ga, '01');
    MutationMethod::$prob = 1;

    // Act
    $mutatedIndividual = MutationMethod::simple($ga, $individual, 1);

    // Assert
    $this->assertNotEquals('01', $mutatedIndividual->genome);
  }

  public function testSimple_noMutation_mustReturnIndividualWithSameGenome()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $individual = new Individual($ga, '01');
    MutationMethod::$prob = 0;

    // Act
    $mutatedIndividual = MutationMethod::simple($ga, $individual);

    // Assert
    $this->assertEquals('01', $mutatedIndividual->genome);
  }
}
?>