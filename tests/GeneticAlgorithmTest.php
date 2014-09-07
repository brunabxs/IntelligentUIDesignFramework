<?php
class GeneticAlgorithmTest extends PHPUnit_Framework_TestCase
{
  public function testCreateIndividuals_jsonStringEmpty()
  {
    $ga = new GeneticAlgorithm(1);
    $ga->jsonString = '';
    $this->assertEquals(0, count($ga->createIndividuals()));
  }

  public function testCreateIndividuals_jsonStringOneElementAndOneClass()
  {
    $ga = new GeneticAlgorithm(2);
    $ga->jsonString = '{"h1":["class1"]}';
    $this->assertEquals(2, count($ga->createIndividuals()));
  }
  
  public function testCreateIndividuals_jsonStringOneElementAndTwoClasses()
  {
    $ga = new GeneticAlgorithm(2);
    $ga->jsonString = '{"h1":["class1","class2"]}';
    $this->assertEquals(2, count($ga->createIndividuals()));
  }
}
?>