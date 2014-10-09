<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class CronControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testCreateJob()
  {
    // Arrange
    $code = '123';

    // Act
    $job = self::callMethod('CronController', 'createJob', array($code));

    // Assert
    $this->assertEquals('* * * * * wget localhost/newGeneration.php?code=123' . PHP_EOL, $job);
  }
}
?>
