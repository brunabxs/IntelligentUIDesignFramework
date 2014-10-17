<?php
class IndividualDAOTest extends MyDatabase_TestCase
{
  private static $table = 'Individual';
  private static $query1 = 'SELECT individual_oid, genome, properties, quantity, generation_oid FROM Individual';
  private static $query2 = 'SELECT genome, properties, quantity, generation_oid FROM Individual';

  public function testLoadById_individualWithIndividualOidThatExists_mustSetInstanceToIndividualObject()
  {
    // Arrange
    $individualDAO = new IndividualDAO();

    // Act
    $individualDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($individualDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->individual_oid);
    $this->assertEquals('0', $individualDAO->instance->genome);
    $this->assertEquals('{"h1":""}', $individualDAO->instance->properties);
    $this->assertEquals('1', $individualDAO->instance->quantity);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->generation_oid);
  }

  public function testLoadById_individualWithIndividualOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $individualDAO = new IndividualDAO();

    // Act
    $individualDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($individualDAO->instance);
  }

  public function testPersist_individualWithIndividualOidNullWithGenomeThatDoesNotExistAndGenerationOidThatExists_mustSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '1', '{"h1":"class1"}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_individualWithIndividualOidNullWithGenomeThatExistsAndGenerationOidThatExists_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '0', '{"h1":""}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_individualWithIndividualOidNotNull_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000002', '0', '{"h1":""}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_individualWithIndividualOidNull_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '0', '{"h1":""}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_individualWithIndividualOidNotNullThatDoesNotExist_mustNotSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000002', '0', '{"h1":""}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_individualWithIndividualOidNotNullThatExists_mustSaveIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual('00000000-0000-0000-0000-000000000001', '1', '{"h1":"class1"}', '1', null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_individualWithGenomeThatExistsAndGenerationOidThatExists_mustSetIndividualInstance()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '0', null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->sync();

    // Assert
    $this->assertNotNull($individualDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->individual_oid);
    $this->assertEquals('0', $individualDAO->instance->genome);
    $this->assertEquals('{"h1":""}', $individualDAO->instance->properties);
    $this->assertEquals('1', $individualDAO->instance->quantity);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individualDAO->instance->generation_oid);
  }

  public function testSync_individualWithGenerationOidThatDoesNotExist_mustSetIndividualInstanceToNull()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '0', null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $individualDAO->sync();

    // Assert
    $this->assertNull($individualDAO->instance);
  }

  public function testSync_individualWithGenomeThatDoesNotExist_mustSetIndividualInstanceToNull()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $individualDAO->instance = new Individual(null, '1', null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $individualDAO->sync();

    // Assert
    $this->assertNull($individualDAO->instance);
  }

  public function testLoadAllIndividuals_generationHasTwoIndividuals_mustReturnTwoIndividuals()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $generation = new Generation('00000000-0000-0000-0000-000000000001', null, null);

    // Act
    $individuals = $individualDAO->loadAllIndividuals($generation);

    // Assert
    $this->assertEquals(2, count($individuals));
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $individuals[0]->individual_oid);
    $this->assertEquals('00000000-0000-0000-0000-000000000002', $individuals[1]->individual_oid);
  }

  public function testLoadAllIndividuals_generationHasNoIndividual_mustReturnNoIndividual()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $generation = new Generation('00000000-0000-0000-0000-000000000001', null, null);

    // Act
    $individuals = $individualDAO->loadAllIndividuals($generation);

    // Assert
    $this->assertEquals(0, count($individuals));
  }

  public function testLoadAllIndividuals_mustSetIndividualInstanceToNull()
  {
    // Arrange
    $individualDAO = new IndividualDAO();
    $generation = new Generation('00000000-0000-0000-0000-000000000001', null, null);

    // Act
    $individuals = $individualDAO->loadAllIndividuals($generation);

    // Assert
    $this->assertNull($individualDAO->instance);
  }
}
?>
