<?php
include_once 'MyDatabase_TestCase.php';
class AnalyticsDataDAOTest extends MyDatabase_TestCase
{
  private static $table = 'AnalyticsData';
  private static $query1 = 'SELECT analyticsData_oid, method, extraParameters, weight, analytics_oid FROM AnalyticsData';
  private static $query2 = 'SELECT method, extraParameters, weight, analytics_oid FROM AnalyticsData';

  public function testLoadById_analyticsDataWithAnalyticsDataOidThatExists_mustSetInstanceToAnalyticsDataObject()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();

    // Act
    $analyticsDataDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($analyticsDataDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDataDAO->instance->analyticsData_oid);
    $this->assertEquals('method1', $analyticsDataDAO->instance->method);
    $this->assertEquals('&columns=column1', $analyticsDataDAO->instance->extraParameters);
    $this->assertEquals('1', $analyticsDataDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDataDAO->instance->analytics_oid);
  }

  public function testLoadById_analyticsDataWithAnalyticsDataOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();

    // Act
    $analyticsDataDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($analyticsDataDAO->instance);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatDoesNotExistAndExtraParametersThatDoesNotExistAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column2', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatDoesNotExistAndExtraParametersThatDoesNotExistAndAnalyticsOidThatExists_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column2', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatExistsAndExtraParametersThatDoesNotExistAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column2', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatExistsAndExtraParametersThatDoesNotExistAndAnalyticsOidThatExists_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column2', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatDoesNotExistAndExtraParametersThatExistsAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column1', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatDoesNotExistAndExtraParametersThatExistsAndAnalyticsOidThatExists_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column1', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatExistsAndExtraParametersThatExistsAndAnalyticsOidThatDoesNotExist_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column1', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNullWithMethodThatExistsAndExtraParametersThatExistsAndAnalyticsOidThatExists_mustNotSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column1', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_analyticsDataWithAnalyticsDataOidNotNull_mustNotSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData('00000000-0000-0000-0000-000000000002', 'method2', '&columns=column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsDataWithAnalyticsDataOidNull_mustNotSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }
  
  public function testUpdate_analyticsDataWithAnalyticsDataOidNotNullThatDoesNotExist_mustNotSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData('00000000-0000-0000-0000-000000000002', 'method2', '&columns=column2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_analyticsDataWithAnalyticsDataOidNotNullThatExists_mustSaveAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData('00000000-0000-0000-0000-000000000001', 'method2', '&columns=column2', '2', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_analyticsDataWithAnalyticsOidThatExistsAndMethodThatExistsAndExtraParametersThatExists_mustSetAnalyticsDataInstance()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->sync();

    // Assert
    $this->assertNotNull($analyticsDataDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDataDAO->instance->analyticsData_oid);
    $this->assertEquals('method1', $analyticsDataDAO->instance->method);
    $this->assertEquals('&columns=column1', $analyticsDataDAO->instance->extraParameters);
    $this->assertEquals('1', $analyticsDataDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsDataDAO->instance->analytics_oid);
  }

  public function testSync_analyticsDataWithAnalyticsOidThatDoesNotExist_mustSetAnalyticsDataInstanceToNull()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column1', null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDataDAO->sync();

    // Assert
    $this->assertNull($analyticsDataDAO->instance);
  }

  public function testSync_analyticsDataWithMethodThatDoesNotExist_mustSetAnalyticsDataInstanceToNull()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method2', '&columns=column1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->sync();

    // Assert
    $this->assertNull($analyticsDataDAO->instance);
  }

  public function testSync_analyticsDataWithExtraParametersThatDoesNotExist_mustSetAnalyticsDataInstanceToNull()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analyticsDataDAO->instance = new AnalyticsData(null, 'method1', '&columns=column2', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDataDAO->sync();

    // Assert
    $this->assertNull($analyticsDataDAO->instance);
  }

  public function testLoadAllAnalyticsData_analyticsHasTwoAnalyticsData_mustReturnTwoAnalyticsData()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analytics = new Analytics('00000000-0000-0000-0000-000000000001', null, null, null, null);

    // Act
    $analyticsData = $analyticsDataDAO->loadAllAnalyticsData($analytics);

    // Assert
    $this->assertEquals(2, count($analyticsData));
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsData[0]->analyticsData_oid);
    $this->assertEquals('00000000-0000-0000-0000-000000000002', $analyticsData[1]->analyticsData_oid);
  }

  public function testLoadAllAnalyticsData_analyticsHasNoAnalyticsData_mustReturnNoAnalyticsData()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analytics = new Analytics('00000000-0000-0000-0000-000000000001', null, null, null, null);

    // Act
    $analyticsData = $analyticsDataDAO->loadAllAnalyticsData($analytics);

    // Assert
    $this->assertEquals(0, count($analyticsData));
  }

  public function testLoadAllAnalyticsData_mustSetAnalyticsDataInstanceToNull()
  {
    // Arrange
    $analyticsDataDAO = new AnalyticsDataDAO();
    $analytics = new Analytics('00000000-0000-0000-0000-000000000001', null, null, null, null);

    // Act
    $analyticsData = $analyticsDataDAO->loadAllAnalyticsData($analytics);

    // Assert
    $this->assertNull($analyticsDataDAO->instance);
  }
}
?>
