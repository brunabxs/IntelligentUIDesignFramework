<?php
class WebAnalyticsPiwikControllerTest extends MyDatabase_TestCase
{
  private $analyticsDAO;
  private $analyticsDataDAO;

  public function __construct()
  {
    $this->analyticsDAO = new AnalyticsDAO();
    $this->analyticsDataDAO = new AnalyticsDataDAO();
  }

  public function testGetValue_mustMultiplyCollectedAnalyticsDataPerWeight()
  {
    // Arrange
    $webAnalyticsPiwikController = $this->mockWebAnalyticsPiwikController(array('retrieveDataFromTool'));
    $webAnalyticsPiwikController->method('retrieveDataFromTool')->will($this->returnValue(2));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsPiwikController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2);
  }

  public function testGetValue_mustSumCollectedAnalyticsData()
  {
    // Arrange
    $webAnalyticsPiwikController = $this->mockWebAnalyticsPiwikController(array('retrieveDataFromTool'));
    $webAnalyticsPiwikController->method('retrieveDataFromTool')->will($this->onConsecutiveCalls(array(2, 5)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsPiwikController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2 + 5 * (-1));
  }

  public function testValidate_validData_mustReturnArrayWithSuccess()
  {
    // Arrange
    $analytics = new Analytics(null, 'token123', '1', 'piwik', null);
    $analyticsData = array();
    $analyticsData[] = new AnalyticsData(null, 'method1', null, 1, null);
    $analyticsData[] = new AnalyticsData(null, 'method2', null, 1, null);
    $webAnalyticsGoogleController = $this->mockWebAnalyticsPiwikController(array('retrieveDataFromTool'), $analytics, $analyticsData);
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->onConsecutiveCalls(array(2, 5)));

    // Act
    $result = $webAnalyticsGoogleController->validate();

    // Assert
    $this->assertEquals($result, array('type'=>'success'));
  }

  public function testValidate_invalidData_mustReturnArrayWithError()
  {
    // Arrange
    $analytics = new Analytics(null, 'token123', '1', 'piwik', null);
    $analyticsData = array();
    $analyticsData[] = new AnalyticsData(null, 'method1', null, 1, null);
    $analyticsData[] = new AnalyticsData(null, 'method2', null, 1, null);
    $webAnalyticsGoogleController = $this->mockWebAnalyticsPiwikController(array('retrieveDataFromTool'), $analytics, $analyticsData);
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->returnValue(array()));

    // Act
    $result = $webAnalyticsGoogleController->validate();

    // Assert
    $this->assertEquals($result, array('type'=>'error', 'message'=>'Preencha corretamente os campos'));
  }

  private function mockWebAnalyticsPiwikController($methods=NULL, $analytics=NULL, $analyticsData=NULL)
  {
    if ($analytics == NULL)
    {
      $this->analyticsDAO->instance = new Analytics(null, null, null, null, '00000000-0000-0000-0000-000000000001');
      $this->analyticsDAO->sync();
      $analytics = $this->analyticsDAO->instance;
    }

    if ($analyticsData == NULL)
    {
      $analyticsData = $this->analyticsDataDAO->loadAllAnalyticsData($analytics);
    }

    $mock = $this->getMockBuilder('WebAnalyticsPiwikController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($analytics, $analyticsData))
                 ->getMock();
    return $mock;
  }
}
?>
