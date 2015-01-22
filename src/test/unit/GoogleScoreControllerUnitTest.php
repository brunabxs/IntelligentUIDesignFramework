<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class GoogleScoreControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testPrepareFilters_noFilterIsSet_mustReturnOnlyCustomVariableFilter()
  {
    // Arrange
    $filter = null;
    $generationNumber = '0';
    $individualGenome = '10';

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

    // Assert
    $this->assertEquals('customVarName1==GA,customVarValue1==0.10', $result);
  }

  public function testPrepareFilters_AFilterIsSet_mustReturnOnlyCustomVariableFilter()
  {
    // Arrange
    $filter = 'ga:country==United States';
    $generationNumber = '0';
    $individualGenome = '10';

    // Act
    $result = self::callMethod('GoogleScoreController', 'prepareFilters', array($filter, $generationNumber, $individualGenome));

    // Assert
    $this->assertEquals('ga:country==United States,customVarName1==GA,customVarValue1==0.10', $result);
  }
}
?>
