<?php
class AnalyticsControllerTest extends MyDatabase_TestCase
{
  public function testCreate_mustPersistAnalytics()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $analyticsController->create($user, 'piwik', '123token', 23, array());

    // Assert
    $this->assertActualAndExpectedTablesEqual('Analytics', 'SELECT token, siteId, type, geneticAlgorithm_oid from Analytics');
  }

  public function testCreate_mustSyncAnalytics()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $analyticsController->create($user, 'piwik', '123token', 23, array());

    // Assert
    $this->assertNotNull($analyticsController->analyticsDAO->instance->analytics_oid);
  }

  public function testCreate_analyticsWithOneMethod_mustPersistOneAnalyticsData()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $method1 = array('method' => 'method1', 'extraParameters' => 'extra', 'weight' => 1);

    // Act
    $analyticsController->create($user, 'piwik', '123token', 23, array($method1));

    // Assert
    $this->assertActualAndExpectedTablesEqual('AnalyticsData', 'SELECT method, extraParameters, weight from AnalyticsData');
  }

  public function testCreate_analyticsWithTwoMethods_mustPersistTwoAnalyticsData()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $method1 = array('method' => 'method1', 'extraParameters' => 'extra', 'weight' => 1);
    $method2 = array('method' => 'method2', 'extraParameters' => 'extra', 'weight' => 2);

    // Act
    $analyticsController->create($user, 'piwik', '123token', 23, array($method1, $method2));

    // Assert
    $this->assertActualAndExpectedTablesEqual('AnalyticsData', 'SELECT method, extraParameters, weight from AnalyticsData');
  }

  public function testCreate_analyticsWithOneMethodAndOneExtraParameterWithoutMethod_mustPersistTwoAnalyticsData()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);
    $method1 = array('method' => 'method1', 'weight' => 1);
    $filter = array('extraParameters' => 'filter');


    // Act
    $analyticsController->create($user, 'google', 'ga:123', null, array($method1, $filter));

    // Assert
    $this->assertActualAndExpectedTablesEqual('AnalyticsData', 'SELECT method, weight, extraParameters from AnalyticsData');
  }

  public function testCreate_analyticsWithNoMethods_mustPersistNoAnalyticsData()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $user = new User('00000000-0000-0000-0000-000000000001', null, null, null);

    // Act
    $analyticsController->create($user, 'piwik', '123token', 23, array());

    // Assert
    $this->assertEquals(0, $this->getConnection()->getRowCount('AnalyticsData'));
  }

  public function testGetType_mustReturnAnalyticsType()
  {
    // Arrange
    $analyticsController = $this->mockAnalyticsController();
    $geneticAlgorithmCode = '123456';

    // Act
    $type = $analyticsController->getType($geneticAlgorithmCode);

    // Assert
    $this->assertEquals('google', $type);
  }

  private function mockAnalyticsController($methods=NULL)
  {
    $mock = $this->getMockBuilder('AnalyticsController')
                 ->setMethods($methods)
                 ->getMock();

    return $mock;
  }
}
?>
