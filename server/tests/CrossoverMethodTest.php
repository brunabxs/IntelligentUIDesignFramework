<?php
include_once 'MyUnit_Framework_TestCase.php';
class CrossoverMethodTest extends MyUnit_Framework_TestCase
{
  public function testSimple_point1_mustReturnTwoIndividualsWithGenomeDifferentFromParents()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 3;
    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');
    CrossoverMethod::$prob = 1;

    // Act
    $newIndividuals = CrossoverMethod::simple($ga, $individual1, $individual2, 1);

    // Assert
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('001', $newIndividuals[0]->genome);
    $this->assertEquals('110', $newIndividuals[1]->genome);
  }

  public function testSimple_point0_mustReturnTwoIndividualsWithGenomeDifferentFromParents()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 3;
    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');
    CrossoverMethod::$prob = 1;

    // Act
    $newIndividuals = CrossoverMethod::simple($ga, $individual1, $individual2, 0);

    // Assert
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('011', $newIndividuals[0]->genome);
    $this->assertEquals('100', $newIndividuals[1]->genome);
  }

  public function testSimple_point2_mustReturnTwoIndividualsWithGenomeEqualsToParents()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 3;
    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');
    CrossoverMethod::$prob = 1;

    // Act
    $newIndividuals = CrossoverMethod::simple($ga, $individual1, $individual2, 2);

    // Assert
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('000', $newIndividuals[0]->genome);
    $this->assertEquals('111', $newIndividuals[1]->genome);
  }

  public function testSimple_noPoint_mustReturnTwoIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 3;
    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');
    CrossoverMethod::$prob = 1;

    // Act
    $newIndividuals = CrossoverMethod::simple($ga, $individual1, $individual2);

    // Assert
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals(3, strlen($newIndividuals[0]->genome));
    $this->assertEquals(3, strlen($newIndividuals[1]->genome));
  }

  public function testSimple_noCrossover_mustReturnSameIndividuals()
  {
    // Arrange
    $ga = $this->mockGeneticAlgorithm();
    $ga->genomeSize = 3;
    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');
    CrossoverMethod::$prob = 0;

    // Act
    $newIndividuals = CrossoverMethod::simple($ga, $individual1, $individual2);

    // Assert
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals(3, strlen($newIndividuals[0]->genome));
    $this->assertEquals('000', $newIndividuals[0]->genome);
    $this->assertEquals('111', $newIndividuals[1]->genome);
  }
}
?>