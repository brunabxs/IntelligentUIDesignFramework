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

  public function testCreate_emptyJsonString_GenomeEmpty()
  {
    $jsonString = '';
    $this->assertEquals('', Individual::create($jsonString));
  }

  public function testCreate_jsonStringOneElementAndOneClass_Genome11()
  {
    $jsonString = '{"h1":["class1"]}';
    $genome = Individual::create($jsonString);
    $this->assertEquals(2, strlen($genome));
  }

  public function testCreate_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond_Genome11111()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $genome = Individual::create($jsonString);
    $this->assertEquals(5, strlen($genome));
  }
}
?>