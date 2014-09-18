<?php
include_once 'MyUnit_Framework_TestCase.php';
class PiwikScoreTest extends MyUnit_Framework_TestCase
{
  public function testGetURL_oneMethodWithNoColumn_mustReturnURLWithoutBulkAndWithoutColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $methods = array(0 => array('name'=>'VisitFrequency.get'));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = PiwikScore::getURL($generation, $genome, $methods, $startDate, $endDate, $siteId, $token);

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURL_oneMethodWithOneColumn_mustReturnURLWithoutBulkAndWithColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = array('name'=>'max_actions_returning', 'weight'=>1);
    $methods = array(0 => array('name'=>'VisitFrequency.get', 'columns'=>array($column1)));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = PiwikScore::getURL($generation, $genome, $methods, $startDate, $endDate, $siteId, $token);

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get&columns=max_actions_returning'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }

  public function testGetURL_oneMethodWithTwoColumns_mustReturnURLWithoutBulkAndWithColumns()
  {
    // Arrange
    $generation = 0;
    $genome = '1010';
    $column1 = array('name'=>'max_actions_returning', 'weight'=>1);
    $column2 = array('name'=>'bounce_count_returning', 'weight'=>1);
    $methods = array(0 => array('name'=>'VisitFrequency.get', 'columns'=>array($column1, $column2)));
    $startDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 7, 1, 2000));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = PiwikScore::getURL($generation, $genome, $methods, $startDate, $endDate, $siteId, $token);

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API'.
                        '&method=VisitFrequency.get&columns=max_actions_returning;bounce_count_returning'.
                        '&idSite=1&period=range'.
                        '&date=2000-07-01,2000-07-01&format=PHP'.
                        '&segment=customVariablePageName1==GA;customVariablePageValue1==0.1010'.
                        '&token_auth=abc123', $url);
  }
}
