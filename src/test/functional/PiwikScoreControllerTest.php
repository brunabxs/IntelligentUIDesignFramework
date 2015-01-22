<?php
class PiwikScoreControllerTest extends MyDatabase_TestCase
{
  public function getAnalyticsData_noMethod_mustReturnEmptyArray()
  {
    // Arrange
    $piwikScoreController = $this->mockPiwikScoreController();

    // Act
    $analyticsData = $piwikScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array());
  }

  public function getAnalyticsData_oneMethod_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $piwikScoreController = $this->mockPiwikScoreController();

    // Act
    $analyticsData = $piwikScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1'), 'weight'=>array('2')));
  }

  public function getAnalyticsData_twoMethods_mustReturnArrayWithMethodAndWeight()
  {
    // Arrange
    $piwikScoreController = $this->mockPiwikScoreController();

    // Act
    $analyticsData = $piwikScoreController->getAnalyticsData();

    // Assert
    $this->assertEquals($analyticsData, array('methods'=>array('method1', 'method2'), 'weight'=>array('2', '3')));
  }

  public function testCalculateScore_mustMultiplyCollectedAnalyticsDataPerWeight()
  {
    // Arrange
    $piwikScoreController = $this->mockPiwikScoreController(array('getScore'));
    $piwikScoreController->method('getScore')->will($this->returnValue(2));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $piwikScoreController->calculateScore($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2);
  }

  public function testCalculateScore_mustSumCollectedAnalyticsData()
  {
    // Arrange
    $piwikScoreController = $this->mockPiwikScoreController(array('getScore'));
    $piwikScoreController->method('getScore')->will($this->onConsecutiveCalls(array(2, 5)));
    $generationNumber = 0;
    $individualGenome = '00';
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $score = $piwikScoreController->calculateScore($generationNumber, $individualGenome, $startDate, $endDate);

    // Assert
    $this->assertEquals($score, 2 * 2 + 5 * (-1));
  }

  private function mockPiwikScoreController($methods=NULL)
  {
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    $mock = $this->getMockBuilder('PiwikScoreController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($geneticAlgorithm))
                 ->getMock();
    return $mock;
  }
}
?>
