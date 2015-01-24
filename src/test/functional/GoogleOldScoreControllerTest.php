<?php
class GoogleOldScoreControllerTest extends MyDatabase_TestCase
{
  public function getAnalyticsData_noMethodAndNoFilter_mustReturnEmptyArray()
  {
    // Arrange
    $googleOldScoreController = $this->mockGoogleOldScoreController();

    // Act
    $analyticsData = $googleOldScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array());
  }

  public function getAnalyticsData_oneMethodAndNoFilter_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $googleOldScoreController = $this->mockGoogleOldScoreController();

    // Act
    $analyticsData = $googleOldScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1'), 'weight'=>array('2')));
  }

  public function getAnalyticsData_twoMethodsAndNoFilter_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $googleOldScoreController = $this->mockGoogleOldScoreController();

    // Act
    $analyticsData = $googleOldScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1', 'method2'), 'weight'=>array('2', '3')));
  }

  public function getAnalyticsData_twoMethodsAndFilter_mustReturnArrayWithMethodAndWeightAndFilter()
  {
    // Arrange
    $googleOldScoreController = $this->mockGoogleOldScoreController();

    // Act
    $analyticsData = $googleOldScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1', 'method2'), 'weight'=>array('2', '3'), 'filter'=>'filter'));
  }

  public function testCalculateScore_mustMultiplyCollectedAnalyticsDataPerWeight()
  {
    // Arrange
    $googleScoreController = $this->mockGoogleOldScoreController(array('getScore'));
    $googleScoreController->method('getScore')->will($this->returnValue(array('method1' => 2)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $googleScoreController->calculateScore($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2);
  }

  public function testCalculateScore_mustSumCollectedAnalyticsData()
  {
    // Arrange
    $googleScoreController = $this->mockGoogleOldScoreController(array('getScore'));
    $googleScoreController->method('getScore')->will($this->returnValue(array('method1' => 2, 'method2' => 5)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $googleScoreController->calculateScore($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2 + 5 * (-1));
  }

  private function mockGoogleOldScoreController($methods=NULL)
  {
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    $mock = $this->getMockBuilder('GoogleOldScoreController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($geneticAlgorithm))
                 ->getMock();
    return $mock;
  }
}
?>
