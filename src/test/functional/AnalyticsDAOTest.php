<?php
include_once 'MyDatabase_TestCase.php';
class AnalyticsDAOTest extends MyDatabase_TestCase
{
  public function testLoadById_analyticsWithAnalyticsOidThatExists_mustSetInstanceToAnalyticsObject()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();

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
    $analyticsDAO = $this->mockAnalyticsDAO();

    // Act
    $analyticsDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($analyticsDAO->instance);
  }

  public function testPersist_analyticsWithDifferentGeneticAlgorithmOid_mustSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertEquals(2, $this->getConnection()->getRowCount('Analytics'));
  }

  public function testPersist_analyticsWithSameGeneticAlgorithmOid_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Analytics'));
  }

  public function testPersist_analyticsWithAnalyticsOidNotNullThatDoesNotExist_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000002', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Analytics'));
  }

  public function testUpdate_analyticsWithAnalyticsOidNull_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Analytics'));
  }

  public function testUpdate_analyticsWithAnalyticsOidNotNullThatDoesNotExist_mustNotSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000002', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertEquals(1, $this->getConnection()->getRowCount('Analytics'));
  }

  public function testUpdate_analyticsWithAnalyticsOidNotNullThatExists_mustSaveAnalyticsInstance()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics('00000000-0000-0000-0000-000000000001', '456token', '2', 'piwik', '00000000-0000-0000-0000-000000000001');
    $expectedTable = $this->createFlatXmlDataSet($this->getExpectedDataset('expected.xml'))->getTable('Analytics');

    // Act
    $result = $analyticsDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $queryTable = $this->getConnection()->createQueryTable('Analytics', 'SELECT analytics_oid, token, siteId, type, geneticAlgorithm_oid FROM Analytics');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }

  public function testSync_analyticsExists_mustSetAnalyticsInstanceByGeneticAlgorithmOid()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
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

  public function testSync_analyticsDoesNotExist_mustSetAnalyticsInstanceToNull()
  {
    // Arrange
    $analyticsDAO = $this->mockAnalyticsDAO();
    $analyticsDAO->instance = new Analytics(null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $analyticsDAO->sync();

    // Assert
    $this->assertNull($analyticsDAO->instance);
  }

  protected function mockAnalyticsDAO()
  {
    $stub = $this->getMockBuilder('AnalyticsDAO')
                 ->disableOriginalConstructor()
                 ->setMethods(NULL)
                 ->getMock();
    return $stub;
  }
}
?>
