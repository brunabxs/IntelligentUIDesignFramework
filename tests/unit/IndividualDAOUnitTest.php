<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class IndividualDAOUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testGenerateGenome_genomeSize2_genomeMustBeCreatedWith2Bits()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 2, null, null, null, '{"h1":["class1","class2"]}', null);

    // Act
    $genome = self::callMethod('IndividualDAO', 'generateGenome', array($geneticAlgorithm));

    // Assert
    $this->assertEquals(2, strlen($genome));
  }

  public function testGenerateGenome_genomeSize1_genomeMustBeCreatedWith1Bit()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"]}', null);

    // Act
    $genome = self::callMethod('IndividualDAO', 'generateGenome', array($geneticAlgorithm));

    // Assert
    $this->assertEquals(1, strlen($genome));
  }

  public function testGenerateProperties_genome1_propertiesMustContainOneElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"]}', null);
    $genome = '1';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class1"}', $properties);
  }

  public function testGenerateProperties_genome0_propertiesMustContainOneElementWithoutClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"]}', null);
    $genome = '0';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":""}', $properties);
  }

  public function testGenerateProperties_genome00_propertiesMustContainTwoElementsBothWithoutClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"], "h2":["class2"]}', null);
    $genome = '00';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":""}', $properties);
  }

  public function testGenerateProperties_genome01_propertiesMustContainTwoElementsWithSecondElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"], "h2":["class2"]}', null);
    $genome = '01';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":"class2"}', $properties);
  }

  public function testGenerateProperties_genome10_propertiesMustContainTwoElementsWithFistElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"], "h2":["class2"]}', null);
    $genome = '10';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class1","h2":""}', $properties);
  }

  public function testGenerateProperties_genome11_propertiesMustContainTwoElementsWithBothWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1"], "h2":["class2"]}', null);
    $genome = '11';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class1","h2":"class2"}', $properties);
  }

  public function testGenerateProperties_genome000_propertiesMustContainTwoElementsWithBothWithoutClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '000';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":""}', $properties);
  }

  public function testGenerateProperties_genome010_propertiesMustContainTwoElementsWithFirstElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '010';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class1","h2":""}', $properties);
  }

  public function testGenerateProperties_genome100_propertiesMustContainTwoElementsWithFirstElementWithSecondClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '100';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class2","h2":""}', $properties);
  }

  public function testGenerateProperties_genome110_propertiesMustContainTwoElementsWithBothWithoutClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '110';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":""}', $properties);
  }

  public function testGenerateProperties_genome001_propertiesMustContainTwoElementsWithSecondWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '001';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":"class3"}', $properties);
  }

  public function testGenerateProperties_genome011_propertiesMustContainTwoElementsWithFirstElementWithFirstClassAndSecondElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '011';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class1","h2":"class3"}', $properties);
  }

  public function testGenerateProperties_genome101_propertiesMustContainTwoElementsWithFirstElementWithSecondClassAndSecondElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '101';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"class2","h2":"class3"}', $properties);
  }

  public function testGenerateProperties_genome111_propertiesMustContainTwoElementsWithSecondElementWithFirstClass()
  {
    // Arrange
    $geneticAlgorithm = new GeneticAlgorithm(null, null, 1, null, null, null, '{"h1":["class1", "class2"], "h2":["class3"]}', null);
    $genome = '111';

    // Act
    $properties = self::callMethod('IndividualDAO', 'generateProperties', array($geneticAlgorithm, $genome));

    // Assert
    $this->assertEquals('{"h1":"","h2":"class3"}', $properties);
  }
}
?>
