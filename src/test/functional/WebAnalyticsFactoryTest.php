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
}
?>
