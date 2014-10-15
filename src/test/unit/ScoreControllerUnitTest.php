<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class ScoreControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testGetURL_oneMethod_mustReturnURLWithBulk()
  {
    // Arrange
    $generation = 0;
    $genome = '1';
    $methods = array('VisitsSummary.getVisits');
    $startDate = date('Y-m-d', mktime(0, 0, 0, 10, 13, 2014));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 10, 19, 2014));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURL', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API&method=API.getBulkRequest&format=PHP'.
                        '&urls[0]='.
                        'method%3DVisitsSummary.getVisits'.
                        '%26idSite%3D1%26period%3Drange'.
                        '%26date%3D2014-10-13%2C2014-10-19'.
                        '%26segment%3DcustomVariablePageName1%3D%3DGA%3BcustomVariablePageValue1%3D%3D0.1'.
                        '%26token_auth%3Dabc123', $url);
  }

  public function testGetURL_twoMethods_mustReturnURLWithBulk()
  {
    // Arrange
    $generation = 0;
    $genome = '1';
    $methods = array('VisitsSummary.getVisits', 'VisitsSummary.getActions');
    $startDate = date('Y-m-d', mktime(0, 0, 0, 10, 13, 2014));
    $endDate = date('Y-m-d', mktime(0, 0, 0, 10, 19, 2014));
    $siteId = 1;
    $token = 'abc123';

    // Act
    $url = self::callMethod('ScoreController', 'getURL', array($generation, $genome, $methods, $startDate, $endDate, $siteId, $token));

    // Assert
    $this->assertEquals('http://localhost/piwik?module=API&method=API.getBulkRequest&format=PHP'.
                        '&urls[0]='.
                        'method%3DVisitsSummary.getVisits'.
                        '%26idSite%3D1%26period%3Drange'.
                        '%26date%3D2014-10-13%2C2014-10-19'.
                        '%26segment%3DcustomVariablePageName1%3D%3DGA%3BcustomVariablePageValue1%3D%3D0.1'.
                        '%26token_auth%3Dabc123'.
                        '&urls[1]='.
                        'method%3DVisitsSummary.getActions'.
                        '%26idSite%3D1%26period%3Drange'.
                        '%26date%3D2014-10-13%2C2014-10-19'.
                        '%26segment%3DcustomVariablePageName1%3D%3DGA%3BcustomVariablePageValue1%3D%3D0.1'.
                        '%26token_auth%3Dabc123', $url);
  }
}
?>
