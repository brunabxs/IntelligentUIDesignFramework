<?php
include_once 'MyDatabase_TestCase.php';
class AnalyticsScoreDAOTest extends MyDatabase_TestCase
{
  private static $table = 'AnalyticsScore';
  private static $query1 = 'SELECT analyticsScore_oid, method, columns, weight, analytics_oid FROM AnalyticsScore';
  private static $query2 = 'SELECT method, columns, weight, analytics_oid FROM AnalyticsScore';

  public function testLoadById_analyticsScoreWithAnalyticsScoreOidThatExists_mustSetInstanceToAnalyticsScoreObject()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();

    // Act
    $analyticsScoreDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($analyticsScoreDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analyticsScore_oid);
    $this->assertEquals('method1', $analyticsScoreDAO->instance->method);
    $this->assertEquals('column', $analyticsScoreDAO->instance->columns);
    $this->assertEquals('1', $analyticsScoreDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analytics_oid);
  }

  public function testLoadById_analyticsScoreWithAnalyticsScoreOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();

    // Act
    $analyticsScoreDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($analyticsScoreDAO->instance);
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNullWithMethodThatDoesNotExistAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', 'column', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNullWithMethodThatDoesNotExistAndAnalyticsOidThatExists_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', 'column', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNullWithMethodThatExistsAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'column', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNullWithMethodThatExistsAndAnalyticsOidThatExists_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'column', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNotNull_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000002', 'method2', 'column1;column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNull_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', 'column1;column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }
  
  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNotNullThatDoesNotExist_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000002', 'method2', 'column1;column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNotNullThatExists_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000001', 'method2', 'column1;column2', '2', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_analyticsScoreWithAnalyticsOidThatExistsAndMethodThatExists_mustSetAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->sync();

    // Assert
    $this->assertNotNull($analyticsScoreDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analyticsScore_oid);
    $this->assertEquals('method1', $analyticsScoreDAO->instance->method);
    $this->assertEquals('column', $analyticsScoreDAO->instance->columns);
    $this->assertEquals('1', $analyticsScoreDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analytics_oid);
  }

  public function testSync_analyticsScoreWithAnalyticsOidThatDoesNotExist_mustSetAnalyticsScoreInstanceToNull()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->sync();

    // Assert
    $this->assertNull($analyticsScoreDAO->instance);
  }

  public function testSync_analyticsScoreWithMethodThatDoesNotExist_mustSetAnalyticsScoreInstanceToNull()
  {
    // Arrange
    $analyticsScoreDAO = new AnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->sync();

    // Assert
    $this->assertNull($analyticsScoreDAO->instance);
  }
}
?>
