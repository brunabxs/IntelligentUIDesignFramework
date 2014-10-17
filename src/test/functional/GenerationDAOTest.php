<?php
class GenerationDAOTest extends MyDatabase_TestCase
{
  private static $table = 'Generation';
  private static $query1 = 'SELECT generation_oid, number, geneticAlgorithm_oid FROM Generation';
  private static $query2 = 'SELECT number, geneticAlgorithm_oid FROM Generation';

  public function testLoadById_generationWithGenerationOidThatExists_mustSetInstanceToGenerationObject()
  {
    // Arrange
    $generationDAO = new GenerationDAO();

    // Act
    $generationDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->generation_oid);
    $this->assertEquals('0', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testLoadById_generationWithGenerationOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $generationDAO = new GenerationDAO();

    // Act
    $generationDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($generationDAO->instance);
  }

  public function testPersist_generationWithGenerationOidNullWithNumberThatDoesNotExistAndGeneticAlgorithmOidThatDoesNotExist_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_generationWithGenerationOidNullWithNumberThatDoesNotExistAndGeneticAlgorithmOidThatExists_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_generationWithGenerationOidNullWithNumberThatExistsAndGeneticAlgorithmOidThatDoesNotExist_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_generationWithGenerationOidNullWithNumberThatExistsAndGeneticAlgorithmOidThatExists_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_generationWithGenerationOidNotNull_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000002', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_generationWithGenerationOidNull_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_generationWithGenerationOidNotNullThatDoesNotExist_mustNotSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000002', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_generationWithGenerationOidNotNullThatExists_mustSaveGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation('00000000-0000-0000-0000-000000000001', '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_generationWithGeneticAlgorithmOidThatExistsAndNumberThatExists_mustSetGenerationInstance()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->sync();

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->generation_oid);
    $this->assertEquals('0', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testSync_generationWithGeneticAlgorithmOidThatDoesNotExist_mustSetGenerationInstanceToNull()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '0', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $generationDAO->sync();

    // Assert
    $this->assertNull($generationDAO->instance);
  }

  public function testSync_generationWithNumberThatDoesNotExist_mustSetGenerationInstanceToNull()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $generationDAO->instance = new Generation(null, '1', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $generationDAO->sync();

    // Assert
    $this->assertNull($generationDAO->instance);
  }

  public function testLoadLastGeneration_geneticAlgorithmHasThreeGenerations_mustSetGenerationInstanceToThirdGeneration()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $generationDAO->loadLastGeneration($geneticAlgorithm);

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000003', $generationDAO->instance->generation_oid);
    $this->assertEquals('2', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testLoadLastGeneration_geneticAlgorithmHasOneGeneration_mustSetGenerationInstanceToFirstGeneration()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $generationDAO->loadLastGeneration($geneticAlgorithm);

    // Assert
    $this->assertNotNull($generationDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->generation_oid);
    $this->assertEquals('0', $generationDAO->instance->number);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $generationDAO->instance->geneticAlgorithm_oid);
  }

  public function testLoadLastGeneration_geneticAlgorithmHasNoGeneration_mustSetGenerationInstanceNull()
  {
    // Arrange
    $generationDAO = new GenerationDAO();
    $geneticAlgorithm = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', null, null, null, null, null, null, null, null);

    // Act
    $generationDAO->loadLastGeneration($geneticAlgorithm);

    // Assert
    $this->assertNull($generationDAO->instance);
  }
}
?>
