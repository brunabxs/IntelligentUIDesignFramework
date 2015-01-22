<?php
class GoogleScoreControllerTest extends MyDatabase_TestCase
{
  public function testCalculateScore_mustMultiplyCollectedAnalyticsDataPerWeight()
  {
    // Arrange
    $googleScoreController = $this->mockGoogleScoreController(array('getScore'));
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
    $googleScoreController = $this->mockGoogleScoreController(array('getScore'));
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

  private function mockGoogleScoreController($methods=NULL)
  {
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    $mock = $this->getMockBuilder('GoogleScoreController')
                 ->setMethods($methods)
                 ->setConstructorArgs(array($geneticAlgorithm))
                 ->getMock();
    return $mock;
  }
}
?>
