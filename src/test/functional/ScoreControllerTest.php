<?php
class ScoreControllerTest extends MyDatabase_TestCase
{
  public function testUpdateScores_mustUpdateIndividualsScores()
  {
    // Arrange
    $scoreController = $this->mockScoreController(array('calculateScore'));
    $scoreController->method('calculateScore')->will($this->onConsecutiveCalls(2, 3));
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);
    $generation = new Generation('00000000-0000-0000-0000-000000000001', null, null);
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));

    // Act
    $scoreController->updateScores($geneticAlgorithm, $generation, $startDate, $endDate);

    // Assert
    $this->assertActualAndExpectedTablesEqual('Individual', 'SELECT individual_oid, score from Individual');
  }

  private function mockScoreController($methods=NULL)
  {
    $mock = $this->getMockBuilder('ScoreController')
                 ->setMethods($methods)
                 ->getMock();
    return $mock;
  }
}
?>
