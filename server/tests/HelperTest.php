<?php
include_once 'MyUnit_Framework_TestCase.php';
class HelperTest extends MyUnit_Framework_TestCase
{
  public function testGetIndividualData_codeWithGenerationAndGenomeThatExist_mustReturnIndividual()
  {
    // Arrange
    $code = '1.0010';

    // Act
    $individualData = Helper::getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_codeWithGenomeThatDoesNotExist_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '1.0011';

    // Act
    $individualData = Helper::getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_codeWithGenerationThatDoesNotExist_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '3.0010';

    // Act
    $individualData = Helper::getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_emptyCode_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '';

    // Act
    $individualData = Helper::getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }
}
