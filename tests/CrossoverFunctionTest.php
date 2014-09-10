<?php
class CrossoverFunctionTest extends PHPUnit_Framework_TestCase
{
  public function testSimple_twoIndividuals_genomeSize3_point1()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->getMock();
    $ga->genomeSize = 3;

    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');

    CrossoverFunction::$prob = 1;
    $newIndividuals = CrossoverFunction::simple($ga, $individual1, $individual2, 1);
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('001', $newIndividuals[0]->genome);
    $this->assertEquals('110', $newIndividuals[1]->genome);
  }

  public function testSimple_twoIndividuals_genomeSize3_point0()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->getMock();
    $ga->genomeSize = 3;

    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');

    CrossoverFunction::$prob = 1;
    $newIndividuals = CrossoverFunction::simple($ga, $individual1, $individual2, 0);
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('011', $newIndividuals[0]->genome);
    $this->assertEquals('100', $newIndividuals[1]->genome);
  }

  public function testSimple_twoIndividuals_genomeSize3_point2()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->getMock();
    $ga->genomeSize = 3;

    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');

    CrossoverFunction::$prob = 1;
    $newIndividuals = CrossoverFunction::simple($ga, $individual1, $individual2, 2);
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals('000', $newIndividuals[0]->genome);
    $this->assertEquals('111', $newIndividuals[1]->genome);
  }

  public function testSimple_twoIndividuals_genomeSize3_noPoint()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->getMock();
    $ga->genomeSize = 3;

    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');

    CrossoverFunction::$prob = 1;
    $newIndividuals = CrossoverFunction::simple($ga, $individual1, $individual2);
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals(3, strlen($newIndividuals[0]->genome));
    $this->assertEquals(3, strlen($newIndividuals[1]->genome));
  }

  public function testSimple_twoIndividuals_genomeSize3_noCrossover()
  {
    $ga = $this->getMockBuilder('GeneticAlgorithm')
               ->disableOriginalConstructor()
               ->getMock();
    $ga->genomeSize = 3;

    $individual1 = new Individual($ga, '000');
    $individual2 = new Individual($ga, '111');

    CrossoverFunction::$prob = 0;
    $newIndividuals = CrossoverFunction::simple($ga, $individual1, $individual2);
    $this->assertEquals(2, count($newIndividuals));
    $this->assertEquals(3, strlen($newIndividuals[0]->genome));
    $this->assertEquals('000', $newIndividuals[0]->genome);
    $this->assertEquals('111', $newIndividuals[1]->genome);
  }
}
?>