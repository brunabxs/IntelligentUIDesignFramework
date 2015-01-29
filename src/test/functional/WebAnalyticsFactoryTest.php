<?php
class WebAnalyticsFactoryTest extends MyDatabase_TestCase
{
  public function testInit_analyticsTypeSetAsPiwik_mustReturnWebAnalyticsPiwikControllerInstance()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $webAnalyticsController = WebAnalyticsFactory::init($geneticAlgorithm);

    // Assert
    $this->assertInstanceOf('WebAnalyticsPiwikController', $webAnalyticsController);
  }

  public function testInit_analyticsTypeSetAsGoogleOld_mustReturnWebAnalyticsGoogleOldControllerInstance()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $webAnalyticsController = WebAnalyticsFactory::init($geneticAlgorithm);

    // Assert
    $this->assertInstanceOf('WebAnalyticsGoogleOldController', $webAnalyticsController);
  }

  public function testInit_analyticsTypeSetAsGoogle_mustReturnWebAnalyticsGoogleControllerInstance()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $webAnalyticsController = WebAnalyticsFactory::init($geneticAlgorithm);

    // Assert
    $this->assertInstanceOf('WebAnalyticsGoogleController', $webAnalyticsController);
  }

  public function testInit_analyticsTypeNotSetAsPiwikNotSetAsGoogleOldNotSetAsGoogle_mustReturnNull()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $webAnalyticsController = WebAnalyticsFactory::init($geneticAlgorithm);

    // Assert
    $this->assertNull($webAnalyticsController);
  }

  public function testInit_geneticAlgorithmNull_mustReturnWebAnalyticsControllerInstance()
  {
    // Arrange
    $analytics = new Analytics(null, '123token', '1', 'piwik', null);
    $analyticsData = array();

    // Act
    $webAnalyticsController = WebAnalyticsFactory::init(null, $analytics, $analyticsData);

    // Assert
    $this->assertInstanceOf('WebAnalyticsPiwikController', $webAnalyticsController);
    $this->assertEquals($analytics, $webAnalyticsController->analytics);
    $this->assertEquals($analyticsData, $webAnalyticsController->analyticsData);
  }
}
?>
