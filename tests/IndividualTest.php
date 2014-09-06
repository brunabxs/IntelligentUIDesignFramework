<?php
class IndividualTest extends PHPUnit_Framework_TestCase
{
  public function testSetGenomeMask_jsonStringOneElementAndOneClass_0GenomeMask()
  {
    $jsonString = '{"h1":["class1"]}';
    Individual::setGenomeMask($jsonString);
    $this->assertEquals('0', Individual::$genomeMask);
  }

  public function testSetGenomeMask_jsonStringOneElementAndTwoClasses_00GenomeMask()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    Individual::setGenomeMask($jsonString);
    $this->assertEquals('00', Individual::$genomeMask);
  }

  public function testSetGenomeMask_jsonStringTwoElementsAndOneClassForEach_00GenomeMask()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    Individual::setGenomeMask($jsonString);
    $this->assertEquals('00', Individual::$genomeMask);
  }

  public function testSetGenomeMask_jsonStringTwoElementsAndOneClassForFirstAndTwoClassesForSecond_000GenomeMask()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3"]}';
    Individual::setGenomeMask($jsonString);
    $this->assertEquals('000', Individual::$genomeMask);
  }

  public function testSetGenomeMask_emptyJsonString_emptyGenomeMask()
  {
    $jsonString = '';
    Individual::setGenomeMask($jsonString);
    $this->assertEquals('', Individual::$genomeMask);
  }
}
?>