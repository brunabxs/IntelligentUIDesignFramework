<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GoogleScoreControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testPrepareFilters_noFilterIsSet_mustReturnStringWithCustomDimension1()
  {
    // Arrange
    $filter = null;
    $generationNumber = '0';
    $individualGenome = '10';

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

    // Assert
    $this->assertEquals('ga:dimension1==0.10', $result);
  }

  public function testPrepareFilters_ACountryFilterIsSet_mustReturnStringWithCountryAndCustomDimension1()
  {
    // Arrange
    $filter = 'ga:country==United States';
    $generationNumber = '0';
    $individualGenome = '10';

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

    // Assert
    $this->assertEquals('ga:country==United States;ga:dimension1==0.10', $result);
  }

  public function testPrepareMetrics_oneMetric_mustReturnStringWithOneMetric()
  {
    // Arrange
    $metrics = array('ga:bounces');

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('ga:bounces', $result);
  }

  public function testPrepareMetrics_twoMetrics_mustReturnStringWithTwoMetricsSeparatedByComma()
  {
    // Arrange
    $metrics = array('ga:bounces', 'ga:sessions');

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('ga:bounces,ga:sessions', $result);
  }

  public function testPrepareMetrics_noMetric_mustReturnEmptyString()
  {
    // Arrange
    $metrics = array();

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('', $result);
  }
}
?>
