<?php
class IndividualTest extends PHPUnit_Framework_TestCase
{
  public function testConstructor_genomeEmpty()
  {
    $jsonString = '{"h1":["class1"]}';
    $genome = '';
    $individual = new Individual(new GeneticAlgorithm(1, null, $jsonString), $genome);
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConstructor_genomeNotEmpty()
  {
    $jsonString = '{"h1":["class1"]}';
    $genome = '11';
    $individual = new Individual(new GeneticAlgorithm(1, null, $jsonString), $genome);
    $this->assertEquals('11', $individual->genome);
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConvertToJSON_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $this->assertEquals('{"h1":"class1"}', (new Individual($ga, '00'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '01'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $this->assertEquals('{"h1":"class1"}', (new Individual($ga, '00'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($ga, '01'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndThreeClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $this->assertEquals('{"h1":"class1"}', (new Individual($ga, '00'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($ga, '01'))->convertToJSON());
    $this->assertEquals('{"h1":"class3"}', (new Individual($ga, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndFiveClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $this->assertEquals('{"h1":"class1"}', (new Individual($ga, '000'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($ga, '001'))->convertToJSON());
    $this->assertEquals('{"h1":"class3"}', (new Individual($ga, '010'))->convertToJSON());
    $this->assertEquals('{"h1":"class4"}', (new Individual($ga, '011'))->convertToJSON());
    $this->assertEquals('{"h1":"class5"}', (new Individual($ga, '100'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '101'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '110'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($ga, '111'))->convertToJSON());
  }
}
?>