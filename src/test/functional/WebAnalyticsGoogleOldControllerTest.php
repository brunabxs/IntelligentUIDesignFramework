<?php
class WebAnalyticsGoogleOldControllerTest extends MyDatabase_TestCase
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
    $webAnalyticsGoogleOldController = $this->mockWebAnalyticsGoogleOldController(array('retrieveDataFromTool'));
    $webAnalyticsGoogleOldController->method('retrieveDataFromTool')->will($this->returnValue(array('method1' => 2)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsGoogleOldController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2);
  }

  public function testGetValue_mustSumCollectedAnalyticsData()
  {
    // Arrange
    $webAnalyticsGoogleOldController = $this->mockWebAnalyticsGoogleOldController(array('retrieveDataFromTool'));
    $webAnalyticsGoogleOldController->method('retrieveDataFromTool')->will($this->returnValue(array('method1' => 2, 'method2' => 5)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsGoogleOldController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2 + 5 * (-1));
  }

  private function mockWebAnalyticsGoogleOldController($methods=NULL)
  {
    $this->analyticsDAO->instance = new Analytics(null, null, null, null, '00000000-0000-0000-0000-000000000001');
    $this->analyticsDAO->sync();
    $analytics = $this->analyticsDAO->instance;

    $analyticsData = $this->analyticsDataDAO->loadAllAnalyticsData($analytics);

    $mock = $this->getMockBuilder('WebAnalyticsGoogleOldController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($analytics, $analyticsData))
                 ->getMock();
    return $mock;
  }
}
?>
