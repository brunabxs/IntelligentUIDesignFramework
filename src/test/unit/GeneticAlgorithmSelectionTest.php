<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GeneticAlgorithmSelectionTest extends MyAnotherUnit_Framework_TestCase
{
  public function testCalculateTotalScore_threeIndividualsWithScore1_mustReturn3()
  {
    // Arrange
    $individual1 = new Individual(null, null, null, null, 1, null);
    $individual2 = new Individual(null, null, null, null, 1, null);
    $individual3 = new Individual(null, null, null, null, 1, null);
    $individuals = array($individual1, $individual2, $individual3);

    // Act
    $totalScore = self::callMethod('GeneticAlgorithmSelection', 'calculateTotalScore', array($individuals));

    // Assert
    $this->assertEquals(3, $totalScore);
  }

  public function testCalculateTotalScore_oneIndividualWithScore3_mustReturn3()
  {
    // Arrange
    $individual = new Individual(null, null, null, null, 3, null);
    $individuals = array($individual);

    // Act
    $totalScore = self::callMethod('GeneticAlgorithmSelection', 'calculateTotalScore', array($individuals));

    // Assert
    $this->assertEquals(3, $totalScore);
  }

  public function testCalculateTotalScore_noIndividual_mustReturn0()
  {
    // Arrange
    $individuals = array();

    // Act
    $totalScore = self::callMethod('GeneticAlgorithmSelection', 'calculateTotalScore', array($individuals));

    // Assert
    $this->assertEquals(0, $totalScore);
  }

  public function testRoulette_oneIndividual_rouletteValuesChooseOneIndividual_firstIndividual()
  {
    // Arrange
    $individual = new Individual(null, '000', null, 1, 0.4, null);
    $individuals = array($individual);

    // Act
    $selectedIndividuals = GeneticAlgorithmSelection::roulette($individuals, array(0.6));

    // Assert
    $this->assertEquals(1, count($selectedIndividuals));
    $this->assertEquals($individual, $selectedIndividuals[0]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstIndividualTwoTimes()
  {
    // Arrange
    $individual1 = new Individual(null, '000', null, 1, 0.4, null);
    $individual2 = new Individual(null, '001', null, 1, 0.2, null);
    $individuals = array($individual1, $individual2);

    // Act
    $selectedIndividuals = GeneticAlgorithmSelection::roulette($individuals, array(0.6, 0.66));

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual1, $selectedIndividuals[1]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstAndSecondIndividuals()
  {
    // Arrange
    $individual1 = new Individual(null, '000', null, 1, 0.4, null);
    $individual2 = new Individual(null, '001', null, 1, 0.2, null);
    $individuals = array($individual1, $individual2);

    // Act
    $selectedIndividuals = GeneticAlgorithmSelection::roulette($individuals, array(0.6, 1));

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual2, $selectedIndividuals[1]);
  }

  public function testRoulette_oneIndividual_rouletteValuesChooseTwoIndividuals_firstIndividualTwice()
  {
    // Arrange
    $individual1 = new Individual(null, '000', null, 2, 0.4, null);
    $individuals = array($individual1);

    // Act
    $selectedIndividuals = GeneticAlgorithmSelection::roulette($individuals, array(0.6, 1));

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual1, $selectedIndividuals[1]);
  }
}
?>
