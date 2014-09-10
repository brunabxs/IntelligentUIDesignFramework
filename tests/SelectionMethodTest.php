<?php
include_once 'MyUnit_Framework_TestCase.php';
class SelectionMethodTest extends MyUnit_Framework_TestCase
{
  public function testRoulette_oneIndividual()
  {
    $individual = new Individual(null, '000');
    $individual->score = 0.4;

    $individuals = array($individual);

    $selectedIndividuals = SelectionMethod::roulette($individuals, array(0.6));
    $this->assertEquals(1, count($selectedIndividuals));
    $this->assertEquals($individual, $selectedIndividuals[0]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstIndividualTwoTimes()
  {
    $individual1 = new Individual(null, '000');
    $individual1->score = 0.4;
    $individual2 = new Individual(null, '001');
    $individual2->score = 0.2;

    $individuals = array($individual1, $individual2);

    $selectedIndividuals = SelectionMethod::roulette($individuals, array(0.6, 0.66));
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual1, $selectedIndividuals[1]);
  }

  public function testRoulette_twoIndividuals_rouletteValuesChooseTwoIndividuals_firstAndSecondIndividuals()
  {
    $individual1 = new Individual(null, '000');
    $individual1->score = 0.4;
    $individual2 = new Individual(null, '001');
    $individual2->score = 0.2;

    $individuals = array($individual1, $individual2);

    $selectedIndividuals = SelectionMethod::roulette($individuals, array(0.6, 1));
    $this->assertEquals(2, count($selectedIndividuals));
    $this->assertEquals($individual1, $selectedIndividuals[0]);
    $this->assertEquals($individual2, $selectedIndividuals[1]);
  }
}
?>