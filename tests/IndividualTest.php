<?php
class IndividualTest extends PHPUnit_Framework_TestCase
{
  public function testSetGenomeSize_jsonStringOneElementAndOneClass_GenomeSize2()
  {
    $jsonString = '{"h1":["class1"]}';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(2, Individual::$genomeSize);
  }

  public function testSetGenomeSize_jsonStringOneElementAndTwoClasses_GenomeSize2()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(2, Individual::$genomeSize);
  }

  public function testSetGenomeSize_jsonStringOneElementAndFiveClasses_GenomeSize3()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(3, Individual::$genomeSize);
  }

  public function testSetGenomeSize_jsonStringTwoElementsAndOneClassForEach_GenomeSize4()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(4, Individual::$genomeSize);
  }

  public function testSetGenomeSize_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond_GenomeSize5()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(5, Individual::$genomeSize);
  }

  public function testSetGenomeSize_emptyJsonString_GenomeSize0()
  {
    $jsonString = '';
    Individual::setGenomeSize($jsonString);
    $this->assertEquals(0, Individual::$genomeSize);
  }
}
?>