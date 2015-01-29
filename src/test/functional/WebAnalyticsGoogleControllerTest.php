<?php
class WebAnalyticsGoogleControllerTest extends MyDatabase_TestCase
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
    $webAnalyticsGoogleController = $this->mockWebAnalyticsGoogleController(array('retrieveDataFromTool'));
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->returnValue(array('method1' => 2)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsGoogleController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2);
  }

  public function testGetValue_mustSumCollectedAnalyticsData()
  {
    // Arrange
    $webAnalyticsGoogleController = $this->mockWebAnalyticsGoogleController(array('retrieveDataFromTool'));
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->returnValue(array('method1' => 2, 'method2' => 5)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $webAnalyticsGoogleController->getValue($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2 + 5 * (-1));
  }

  public function testValidate_validData_mustReturnArrayWithSuccess()
  {
    // Arrange
    $analytics = new Analytics(null, 'ga:123', null, 'google', null);
    $analyticsData = array();
    $analyticsData[] = new AnalyticsData(null, 'method1', null, 1, null);
    $analyticsData[] = new AnalyticsData(null, 'method2', null, 1, null);
    $webAnalyticsGoogleController = $this->mockWebAnalyticsGoogleController(array('retrieveDataFromTool'), $analytics, $analyticsData);
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->returnValue(array('method1' => 2, 'method2' => 5)));

    // Act
    $result = $webAnalyticsGoogleController->validate();

    // Assert
    $this->assertEquals($result, array('type'=>'success'));
  }

  public function testValidate_invalidData_mustReturnArrayWithError()
  {
    // Arrange
    $analytics = new Analytics(null, 'ga:123', null, 'google', null);
    $analyticsData = array();
    $analyticsData[] = new AnalyticsData(null, 'method1', null, 1, null);
    $analyticsData[] = new AnalyticsData(null, 'method2', null, 1, null);
    $webAnalyticsGoogleController = $this->mockWebAnalyticsGoogleController(array('retrieveDataFromTool'), $analytics, $analyticsData);
    $webAnalyticsGoogleController->method('retrieveDataFromTool')->will($this->returnValue(array()));

    // Act
    $result = $webAnalyticsGoogleController->validate();

    // Assert
    $this->assertEquals($result, array('type'=>'error', 'message'=>'Preencha corretamente os campos'));
  }

  private function mockWebAnalyticsGoogleController($methods=NULL, $analytics=NULL, $analyticsData=NULL)
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

    $mock = $this->getMockBuilder('WebAnalyticsGoogleController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($analytics, $analyticsData))
                 ->getMock();
    return $mock;
  }
}
?>
