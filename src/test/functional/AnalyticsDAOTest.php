<?php
include_once 'MyDatabase_TestCase.php';
class AnalyticsDAOTest extends MyDatabase_TestCase
{
  private static $table = 'Analytics';
  private static $query1 = 'SELECT analytics_oid, token, siteId, type, geneticAlgorithm_oid FROM Analytics';
  private static $query2 = 'SELECT token, siteId, type, geneticAlgorithm_oid FROM Analytics';

  public function testLoadById_analyticsWithAnalyticsOidThatExists_mustSetInstanceToAnalyticsObject()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();

    // Act
    $analyticsDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($analyticsDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDAO->instance->analytics_oid);
    $this->assertEquals('123token', $analyticsDAO->instance->token);
    $this->assertEquals('1', $analyticsDAO->instance->siteId);
    $this->assertEquals('piwik', $analyticsDAO->instance->type);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDAO->instance->geneticAlgorithm_oid);
  }

  public function testLoadById_analyticsWithAnalyticsOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();

    // Act
    $analyticsDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($analyticsDAO->instance);
  }

  public function testPersist_analyticsWithAnalyticsOidNullWithGeneticAlgorithmOidThatDoesNotExist_mustSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsWithAnalyticsOidNullGeneticAlgorithmOidThatExists_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_analyticsWithAnalyticsOidNotNull_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000002', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsWithAnalyticsOidNull_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsWithAnalyticsOidNotNullThatDoesNotExist_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000002', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsWithAnalyticsOidNotNullThatExists_mustSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000001', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_analyticsWithGeneticAlgorithmOidThatExists_mustSetAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->sync();

    // Assert
    $this->assertNotNull($analyticsDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDAO->instance->analytics_oid);
    $this->assertEquals('123token', $analyticsDAO->instance->token);
    $this->assertEquals('1', $analyticsDAO->instance->siteId);
    $this->assertEquals('piwik', $analyticsDAO->instance->type);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDAO->instance->geneticAlgorithm_oid);
  }

  public function testSync_analyticsWithGeneticAlgorithmOidThatDoesNotExist_mustSetAnalyticsInstanceToNull()
  {
    // Arrange
    $analyticsDAO = new AnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDAO->sync();

    // Assert
    $this->assertNull($analyticsDAO->instance);
  }
}
?>
