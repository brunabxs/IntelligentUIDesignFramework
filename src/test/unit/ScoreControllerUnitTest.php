<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class ScoreControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testGetColumnsURL_twoColumns()
  {
    // Arrange
    $column1 = 'name1';
    $column2 = 'name2';
    $columns = array($column1, $column2);

    // Act
    $url = self::callMethod('ScoreController', 'getColumnsURL', array($columns));

    // Assert
    $this->assertEquals('&columns=name1;name2', $url);
  }

  public function testGetColumnsURL_oneColumn()
  {
    // Arrange
    $column1 = 'name1';
    $columns = array($column1);

    // Act
    $url = self::callMethod('ScoreController', 'getColumnsURL', array($columns));

    // Assert
    $this->assertEquals('&columns=name1', $url);
  }

  public function testGetColumnsURL_noColumn()
  {
    // Arrange
    $columns = array();

    // Act
    $url = self::callMethod('ScoreController', 'getColumnsURL', array($columns));

    // Assert
    $this->assertEquals('', $url);
  }

  public function testGetURLWithOneMethod_withNoColumn_mustReturnURLWithoutBulkAndWithoutColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $methods = array('name'=>'VisitFrequency.get');
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURLWithOneMethod', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURLWithOneMethod_withOneColumn_mustReturnURLWithoutBulkAndWithColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = 'max_actions_returning';
    $methods = array('name'=>'VisitFrequency.get', 'columns'=>array($column1));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURLWithOneMethod', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get&columns=max_actions_returning'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURLWithOneMethod_withTwoColumns_mustReturnURLWithoutBulkAndWithColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = 'max_actions_returning';
    $column2 = 'bounce_count_returning';
    $methods = array('name'=>'VisitFrequency.get', 'columns'=>array($column1, $column2));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURLWithOneMethod', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get&columns=max_actions_returning;bounce_count_returning'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURL_withOneMethod_mustReturnURL()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = 'max_actions_returning';
    $column2 = 'bounce_count_returning';
    $methods = array(0 => array('name'=>'VisitFrequency.get', 'columns'=>array($column1, $column2)));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURL', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get&columns=max_actions_returning;bounce_count_returning'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURL_withOneMethod_mustNotReturnURL()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = 'max_actions_returning';
    $column2 = 'bounce_count_returning';
    $methods = array(0 => array('name'=>'VisitFrequency.get', 'columns'=>array($column1, $column2)),
                     1 => array('name'=>'API.get'));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURL', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('', $url);
  }

/*
  public function testGetScores_threeGenomes_mustReturnThreeScores()
  {
    // Arrange
    $generation = 0;
    $genomes = array(array('1010' => 2), array('1111' => 1), array('0001' => 1));
    $column1 = 'max_actions_returning';
    $column2 = 'bounce_count_returning';
    $methods = array(0 => array('name'=>'VisitFrequency.get', 'columns'=>array($column1, $column2)));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';
    $params = array('methods' => $methods, 'startDate' => $startDate, 'endDate' => $endDate,
                    'siteId' => $siteId, 'token' => $token);

    // Act
    $scores = ScoreController::getScores($generation, $genomes, $params);

    // Assert
    $this->assertEquals(3, count($scores));
  }
*/
}
?>
