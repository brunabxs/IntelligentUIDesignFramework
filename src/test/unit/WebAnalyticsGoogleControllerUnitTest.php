<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class WebAnalyticsGoogleControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testExtractAnalyticsData_oneMethodAndNoFilter_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $analytics = null;
    $method1 = new AnalyticsData(null, 'method1', null, 2, null);
    $analyticsData = array($method1);
    $webAnalyticsGoogleController = new WebAnalyticsGoogleController($analytics, $analyticsData);

    // Act
    $analyticsData = $webAnalyticsGoogleController->extractAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1'), 'weights'=>array('2'), 'filter'=>null));
  }

  public function testExtractAnalyticsData_twoMethodsAndNoFilter_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $analytics = null;
    $method1 = new AnalyticsData(null, 'method1', null, 2, null);
    $method2 = new AnalyticsData(null, 'method2', null, 3, null);
    $analyticsData = array($method1, $method2);
    $webAnalyticsGoogleController = new WebAnalyticsGoogleController($analytics, $analyticsData);

    // Act
    $analyticsData = $webAnalyticsGoogleController->extractAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1', 'method2'), 'weights'=>array('2', '3'), 'filter'=>null));
  }

  public function testExtractAnalyticsData_twoMethodsAndFilter_mustReturnArrayWithMethodAndWeightAndFilter()
  {
    // Arrange
    $analytics = null;
    $method1 = new AnalyticsData(null, 'method1', null, 2, null);
    $method2 = new AnalyticsData(null, 'method2', null, 3, null);
    $filter = new AnalyticsData(null, null, 'filter', null, null);
    $analyticsData = array($method1, $method2, $filter);
    $webAnalyticsGoogleController = new WebAnalyticsGoogleController($analytics, $analyticsData);

    // Act
    $analyticsData = $webAnalyticsGoogleController->extractAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1', 'method2'), 'weights'=>array('2', '3'), 'filter'=>'filter'));
  }

  public function testPrepareFilters_noFilterIsSet_mustReturnStringWithCustomDimension1()
  {
    // Arrange
    $filter = null;
    $generationNumber = '0';
    $individualGenome = '10';

    // Act
    $result = self::callMethod('WebAnalyticsGoogleController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

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
    $result = self::callMethod('WebAnalyticsGoogleController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

    // Assert
    $this->assertEquals('ga:country==United States;ga:dimension1==0.10', $result);
  }

  public function testPrepareMetrics_oneMetric_mustReturnStringWithOneMetric()
  {
    // Arrange
    $metrics = array('ga:bounces');

    // Act
    $result = self::callMethod('WebAnalyticsGoogleController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('ga:bounces', $result);
  }

  public function testPrepareMetrics_twoMetrics_mustReturnStringWithTwoMetricsSeparatedByComma()
  {
    // Arrange
    $metrics = array('ga:bounces', 'ga:sessions');

    // Act
    $result = self::callMethod('WebAnalyticsGoogleController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('ga:bounces,ga:sessions', $result);
  }

  public function testPrepareMetrics_noMetric_mustReturnEmptyString()
  {
    // Arrange
    $metrics = array();

    // Act
    $result = self::callMethod('WebAnalyticsGoogleController', 'prepareMetrics', array($metrics));

    // Assert
    $this->assertEquals('', $result);
  }
}
?>
