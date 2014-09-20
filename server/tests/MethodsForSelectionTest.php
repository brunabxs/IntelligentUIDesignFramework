<?php
include_once 'MyUnit_Framework_TestCase.php';
class MethodsForSelectionTest extends MyUnit_Framework_TestCase
{
  public function testRoulette_oneIndividual_rouletteValuesChooseOneIndividual_firstIndividual()
  {
    // Arrange
    $individual = new Individual('000', null, 0.4);
    $individuals = array($individual);

    // Act
    $selectedIndividuals = MethodsForSelection::roulette($individuals, array(0.6));

    // Assert
    $this->assertEquals(1, count($selectedIndividuals));
    $this->assertEquals($individual, $selectedIndividuals[0]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstIndividualTwoTimes()
  {
    // Arrange
    $individual1 = new Individual('000', null, 0.4);
    $individual2 = new Individual('001', null, 0.2);
    $individuals = array($individual1, $individual2);

    // Act
    $selectedIndividuals = MethodsForSelection::roulette($individuals, array(0.6, 0.66));

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual1, $selectedIndividuals[1]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstAndSecondIndividuals()
  {
    // Arrange
    $individual1 = new Individual('000', null, 0.4);
    $individual2 = new Individual('001', null, 0.2);
    $individuals = array($individual1, $individual2);

    // Act
    $selectedIndividuals = MethodsForSelection::roulette($individuals, array(0.6, 1));

    // Assert
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual2, $selectedIndividuals[1]);
  }
}
?>
