<?php
class IndividualTest extends PHPUnit_Framework_TestCase
{
  public function testGetGenomeSize_jsonStringOneElementAndOneClass_GenomeSize2()
  {
    $jsonString = '{"h1":["class1"]}';
    $this->assertEquals(2, Individual::getGenomeSize($jsonString));
  }

  public function testGetGenomeSize_jsonStringOneElementAndTwoClasses_GenomeSize2()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $this->assertEquals(2, Individual::getGenomeSize($jsonString));
  }

  public function testGetGenomeSize_jsonStringOneElementAndFiveClasses_GenomeSize3()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $this->assertEquals(3, Individual::getGenomeSize($jsonString));
  }

  public function testGetGenomeSize_jsonStringTwoElementsAndOneClassForEach_GenomeSize4()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    $this->assertEquals(4, Individual::getGenomeSize($jsonString));
  }

  public function testGetGenomeSize_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond_GenomeSize5()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $this->assertEquals(5, Individual::getGenomeSize($jsonString));
  }

  public function testGetGenomeSize_emptyJsonString_GenomeSize0()
  {
    $jsonString = '';
    $this->assertEquals(0, Individual::getGenomeSize($jsonString));
  }

  public function testCreateGenome_emptyJsonString_GenomeEmpty()
  {
    $jsonString = '';
    $this->assertEquals('', Individual::createGenome($jsonString));
  }

  public function testCreateGenome_jsonStringOneElementAndOneClass_Genome11()
  {
    $jsonString = '{"h1":["class1"]}';
    $genome = Individual::createGenome($jsonString);
    $this->assertEquals(2, strlen($genome));
  }

  public function testCreateGenome_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond_Genome11111()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $genome = Individual::createGenome($jsonString);
    $this->assertEquals(5, strlen($genome));
  }

  public function testCreateJSON_emptyJsonString()
  {
    $jsonString = '';
    $this->assertEquals('[]', Individual::createJSON($jsonString, ''));
  }

  public function testCreateJSON_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $this->assertEquals('{"h1":"class1"}', Individual::createJSON($jsonString, '00'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '01'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '10'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '11'));
  }

  public function testCreateJSON_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $this->assertEquals('{"h1":"class1"}', Individual::createJSON($jsonString, '00'));
    $this->assertEquals('{"h1":"class2"}', Individual::createJSON($jsonString, '01'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '10'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '11'));
  }

  public function testCreateJSON_jsonStringOneElementAndThreeClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3"]}';
    $this->assertEquals('{"h1":"class1"}', Individual::createJSON($jsonString, '00'));
    $this->assertEquals('{"h1":"class2"}', Individual::createJSON($jsonString, '01'));
    $this->assertEquals('{"h1":"class3"}', Individual::createJSON($jsonString, '10'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '11'));
  }

  public function testCreateJSON_jsonStringOneElementAndFiveClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $this->assertEquals('{"h1":"class1"}', Individual::createJSON($jsonString, '000'));
    $this->assertEquals('{"h1":"class2"}', Individual::createJSON($jsonString, '001'));
    $this->assertEquals('{"h1":"class3"}', Individual::createJSON($jsonString, '010'));
    $this->assertEquals('{"h1":"class4"}', Individual::createJSON($jsonString, '011'));
    $this->assertEquals('{"h1":"class5"}', Individual::createJSON($jsonString, '100'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '101'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '110'));
    $this->assertEquals('{"h1":""}', Individual::createJSON($jsonString, '111'));
  }
}
?>