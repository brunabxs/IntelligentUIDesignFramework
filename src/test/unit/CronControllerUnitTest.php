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
    $this->assertEquals('* * * * * curl localhost:8000/newGeneration.php?code=123 -o /tmp/123' . PHP_EOL, $job);
  }
}
?>
