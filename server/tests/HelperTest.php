<?php
include_once 'MyUnit_Framework_TestCase.php';
class HelperTest extends MyUnit_Framework_TestCase
{
  public function testGetIndividualData_codeWithGenerationAndGenomeThatExist_mustReturnIndividual()
  {
    // Arrange
    $code = '1.10';
    $helper = new Helper();

    // Act
    $individualData = $helper->getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_codeWithGenomeThatDoesNotExist_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '1.00';
    $helper = new Helper();

    // Act
    $individualData = $helper->getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_codeWithGenerationThatDoesNotExist_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '3.10';
    $helper = new Helper();

    // Act
    $individualData = $helper->getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }

  public function testGetIndividualData_emptyCode_mustReturnRandomIndividualFromCurrentGeneration()
  {
    // Arrange
    $code = '';
    $helper = new Helper();

    // Act
    $individualData = $helper->getIndividualData(self::$datasetDir, $code);

    // Assert
    $this->assertNotNull($individualData);
  }
}
