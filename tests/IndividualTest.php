<?php
class IndividualTest extends PHPUnit_Framework_TestCase
{
  public function testConstructor_jsonStringOneElementAndOneClass_genomeEmpty()
  {
    $jsonString = '{"h1":["class1"]}';
    $individual = new Individual($jsonString);
    $this->assertEquals(2, $individual->genomeSize);
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConstructor_jsonStringOneElementAndTwoClasses_genomeEmpty()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $individual = new Individual($jsonString);
    $this->assertEquals(2, $individual->genomeSize);
    $this->assertEquals(2, strlen($individual->genome));
  }

  public function testConstructor_jsonStringOneElementAndFiveClasses_genomeEmpty()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $individual = new Individual($jsonString);
    $this->assertEquals(3, $individual->genomeSize);
    $this->assertEquals(3, strlen($individual->genome));
  }

  public function testConstructor_jsonStringTwoElementsAndOneClassForEach_genomeEmpty()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    $individual = new Individual($jsonString);
    $this->assertEquals(4, $individual->genomeSize);
    $this->assertEquals(4, strlen($individual->genome));
  }
  
  public function testConstructor_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond_genomeEmpty()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $individual = new Individual($jsonString);
    $this->assertEquals(5, $individual->genomeSize);
    $this->assertEquals(5, strlen($individual->genome));
  }

  public function testConstructor_jsonStringEmpty_genomeEmpty()
  {
    $jsonString = '';
    $individual = new Individual($jsonString);
    $this->assertEquals(0, $individual->genomeSize);
    $this->assertEquals(0, strlen($individual->genome));
  }

  public function testConvertToJSON_jsonStringEmpty_genomeEmpty()
  {
    $jsonString = '';
    $individual = new Individual($jsonString);
    $this->assertEquals('[]', $individual->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $this->assertEquals('{"h1":"class1"}', (new Individual($jsonString, '00'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '01'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $this->assertEquals('{"h1":"class1"}', (new Individual($jsonString, '00'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($jsonString, '01'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndThreeClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3"]}';
    $this->assertEquals('{"h1":"class1"}', (new Individual($jsonString, '00'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($jsonString, '01'))->convertToJSON());
    $this->assertEquals('{"h1":"class3"}', (new Individual($jsonString, '10'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '11'))->convertToJSON());
  }

  public function testConvertToJSON_jsonStringOneElementAndFiveClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $this->assertEquals('{"h1":"class1"}', (new Individual($jsonString, '000'))->convertToJSON());
    $this->assertEquals('{"h1":"class2"}', (new Individual($jsonString, '001'))->convertToJSON());
    $this->assertEquals('{"h1":"class3"}', (new Individual($jsonString, '010'))->convertToJSON());
    $this->assertEquals('{"h1":"class4"}', (new Individual($jsonString, '011'))->convertToJSON());
    $this->assertEquals('{"h1":"class5"}', (new Individual($jsonString, '100'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '101'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '110'))->convertToJSON());
    $this->assertEquals('{"h1":""}', (new Individual($jsonString, '111'))->convertToJSON());
  }
}
?>