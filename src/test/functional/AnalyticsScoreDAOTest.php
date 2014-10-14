<?php
include_once 'MyDatabase_TestCase.php';
class AnalyticsScoreDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_analyticsScoreWithAnalyticsScoreOidThatExists_mustSetInstanceToAnalyticsScoreObject()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();

    // Act
    $analyticsScoreDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($analyticsScoreDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analyticsScore_oid);
    $this->assertEquals('method1', $analyticsScoreDAO->instance->method);
    $this->assertEquals('methodColumn1', $analyticsScoreDAO->instance->methodColumn);
    $this->assertEquals('1', $analyticsScoreDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analytics_oid);
  }

  public function testLoadById_analyticsScoreWithAnalyticsScoreOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();

    // Act
    $analyticsScoreDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($analyticsScoreDAO->instance);
  }

  public function testPersist_analyticsScoreWithDifferentMethod_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', 'methodColumn1', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testPersist_analyticsScoreWithDifferentColumn_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'methodColumn2', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testPersist_analyticsScoreWithDifferentAnalyticsOid_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'methodColumn1', '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testPersist_analyticsScoreWithSameMethodAndColumnAndAnalyticsOid_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'methodColumn1', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testPersist_analyticsScoreWithAnalyticsScoreOidNotNullThatDoesNotExist_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000002', 'method2', 'methodColumn2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNull_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method2', 'methodColumn2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNotNullThatDoesNotExist_mustNotSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000002', 'method2', 'methodColumn2', '2', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('AnalyticsScore'));
  }

  public function testUpdate_analyticsScoreWithAnalyticsScoreOidNotNullThatExists_mustSaveAnalyticsScoreInstance()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore('00000000-0000-0000-0000-000000000001', 'method2', 'methodColumn2', '2', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('AnalyticsScore');

    // Act
    $result = $analyticsScoreDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('AnalyticsScore', 'SELECT analyticsScore_oid, method, methodColumn, weight, analytics_oid FROM AnalyticsScore');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_analyticsScoreExists_mustSetAnalyticsScoreInstanceByMethodAndColumnAndAnalyticsOid()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'methodColumn1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsScoreDAO->sync();

    // Assert
    $this->assertNotNull($analyticsScoreDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analyticsScore_oid);
    $this->assertEquals('method1', $analyticsScoreDAO->instance->method);
    $this->assertEquals('methodColumn1', $analyticsScoreDAO->instance->methodColumn);
    $this->assertEquals('1', $analyticsScoreDAO->instance->weight);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $analyticsScoreDAO->instance->analytics_oid);
  }

  public function testSync_analyticsScoreDoesNotExist_mustSetAnalyticsScoreInstanceToNull()
  {
    // Arrange
    $analyticsScoreDAO = $this->mockAnalyticsScoreDAO();
    $analyticsScoreDAO->instance = new AnalyticsScore(null, 'method1', 'methodColumn1', null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsScoreDAO->sync();

    // Assert
    $this->assertNull($analyticsScoreDAO->instance);
  }

  protected function mockAnalyticsScoreDAO()
  {
    $stub = $this->getMockBuilder('AnalyticsScoreDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
