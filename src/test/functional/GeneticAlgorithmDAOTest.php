<?php
include_once 'MyDatabase_TestCase.php';
class GeneticAlgorithmDAOTest extends MyDatabase_TestCase
{
  private static $table = 'GeneticAlgorithm';
  private static $query1 = 'SELECT geneticAlgorithm_oid, code, populationSize, genomeSize, methodForSelection, methodForCrossover, methodForMutation, properties, user_oid FROM GeneticAlgorithm';
  private static $query2 = 'SELECT code, populationSize, genomeSize, methodForSelection, methodForCrossover, methodForMutation, properties, user_oid FROM GeneticAlgorithm';

  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatExists_mustSetInstanceToGeneticAlgorithmObject()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('00000000-0000-0000-0000-000000000001');

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('123456', $geneticAlgorithmDAO->instance->code);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('{"h1":["class1"],"h2":["class2"]}', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testLoadById_geneticAlgorithmWithGeneticAlgorithmOidThatDoesNotExist_mustSetInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();

    // Act
    $geneticAlgorithmDAO->loadById('00000000-0000-0000-0000-000000000002');

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNullWithCodeThatDoesNotExistAndUserOidThatDoesNotExist_mustSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '654321', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query2);
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNullWithCodeThatDoesNotExistAndUserOidThatExists_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '654321', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNullWithCodeThatExistsAndUserOidThatDoesNotExist_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '123456', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNullWithCodeThatExistsAndUserOidThatExists_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '123456', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testPersist_geneticAlgorithmWithGeneticAlgorithmOidNotNull_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000002', '123456', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->persist();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNull_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '123456', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNotNullThatDoesNotExist_mustNotSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000002', '123456', '2', '2', 'roulette', 'simple', 'simple', '{"h1":["class1"],"h2":["class2"]}', '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(0, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testUpdate_geneticAlgorithmWithGeneticAlgorithmOidNotNullThatExists_mustSaveGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm('00000000-0000-0000-0000-000000000001', '654321', '4', '4', 'roulette2', 'simple2', 'simple2', '{"h1":["class1","class2"],"h2":["class3","class4"]}', '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->update();

    // Assert
    $this->assertEquals(1, $result);
    $this->assertActualAndExpectedTablesEqual(self::$table, self::$query1);
  }

  public function testSync_geneticAlgorithmWithUserOidThatExists_mustSetGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, null, '00000000-0000-0000-0000-000000000001');

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('123456', $geneticAlgorithmDAO->instance->code);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('{"h1":["class1"],"h2":["class2"]}', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testSync_geneticAlgorithmWithCodeThatExists_mustSetGeneticAlgorithmInstance()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '123456', null, null, null, null, null, null, null);

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNotNull($geneticAlgorithmDAO->instance);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->assertEquals('123456', $geneticAlgorithmDAO->instance->code);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->populationSize);
    $this->assertEquals('2', $geneticAlgorithmDAO->instance->genomeSize);
    $this->assertEquals('roulette', $geneticAlgorithmDAO->instance->methodForSelection);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForCrossover);
    $this->assertEquals('simple', $geneticAlgorithmDAO->instance->methodForMutation);
    $this->assertEquals('{"h1":["class1"],"h2":["class2"]}', $geneticAlgorithmDAO->instance->properties);
    $this->assertEquals('00000000-0000-0000-0000-000000000001', $geneticAlgorithmDAO->instance->user_oid);
  }

  public function testSync_geneticAlgorithmWithUserOidThatDoesNotExist_mustSetGeneticAlgorithmInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, null, '00000000-0000-0000-0000-000000000002');

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }

  public function testSync_geneticAlgorithmWithCodeThatDoesNotExist_mustSetGeneticAlgorithmInstanceToNull()
  {
    // Arrange
    $geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, '654321', null, null, null, null, null, null, null);

    // Act
    $result = $geneticAlgorithmDAO->sync();

    // Assert
    $this->assertNull($geneticAlgorithmDAO->instance);
  }
}
?>
