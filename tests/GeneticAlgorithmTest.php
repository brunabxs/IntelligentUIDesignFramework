<?php
include_once 'MyUnit_Framework_TestCase.php';
class GeneticAlgorithmTest extends MyUnit_Framework_TestCase
{
  public function testConstructor_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(null, $ga->individuals);

    $this->assertEquals(array('class1'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(2, $ga->genomeSize);
    $this->assertEquals(null, $ga->individuals);

    $this->assertEquals(array('class1', 'class2'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringOneElementAndFiveClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(3, $ga->genomeSize);
    $this->assertEquals(null, $ga->individuals);

    $this->assertEquals(array('class1', 'class2', 'class3', 'class4', 'class5'), $ga->json['h1']['classes']);
    $this->assertEquals(3, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringTwoElementsAndOneClassForEach()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(4, $ga->genomeSize);
    $this->assertEquals(null, $ga->individuals);

    $this->assertEquals(array('class1'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
    $this->assertEquals(array('class2'), $ga->json['h2']['classes']);
    $this->assertEquals(2, $ga->json['h2']['bits']);
  }

  public function testConstructor_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);
    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(5, $ga->genomeSize);
    $this->assertEquals(null, $ga->individuals);

    $this->assertEquals(array('class1'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
    $this->assertEquals(array('class2', 'class3', 'class4'), $ga->json['h2']['classes']);
    $this->assertEquals(3, $ga->json['h2']['bits']);
  }

  public function testConstructor_jsonStringEmpty()
  {
    $jsonString = '';
    try
    {
      $ga = new GeneticAlgorithm(1, null, null, $jsonString);
      $this->assertFail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertEquals('Declare jsonFile or jsonString', $e->getMessage());
      return;
    }
    $this->assertFail('Exception expected');
  }

  public function testCreateIndividuals_twoIndividuals()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(2, null, null, $jsonString);
    $ga->createIndividuals();
    $this->assertEquals(2, count($ga->individuals));
  }

  public function testCreateIndividuals_zeroIndividuals()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(0, null, null, $jsonString);
    $ga->createIndividuals();
    $this->assertEquals(0, count($ga->individuals));
  }

  public function testLoadIndividuals_oneIndividual()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(1, null, null, $jsonString);
    $ga->loadIndividuals(self::$datasetDir);
    $this->assertEquals(1, count($ga->individuals));
    $this->assertEquals('01', $ga->individuals[0]->genome);
  }

  public function testLoadIndividuals_twoIndividuals()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(2, null, null, $jsonString);
    $ga->loadIndividuals(self::$datasetDir);
    $this->assertEquals(2, count($ga->individuals));
    $this->assertEquals('10', $ga->individuals[0]->genome);
    $this->assertEquals('11', $ga->individuals[1]->genome);
  }

  public function testSelectIndividuals_rouletteAsSelectionMethod()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(2, null, null, $jsonString);
    $ga->individuals = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));
    $this->assertEquals(2, count($ga->selectIndividuals()));
  }

  public function testGenerateOffspringIndividuals_rouletteAsSelectionMethod_simpleCrossoverAsCrossoverMethod()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(2, null, null, $jsonString);
    $ga->individuals = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));
    $this->assertEquals(2, count($ga->generateOffspringIndividuals()));
  }

  public function testSaveIndividuals_twoIndividuals()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(2, null, null, $jsonString);
    $ga->individuals = array(new Individual($ga, '01', 0.6), new Individual($ga, '10', 0.4));
    $ga->saveIndividuals(self::$tempDir);
    $this->assertTrue(self::containsFile(self::$tempDir, '0-01.json'));
    $this->assertTrue(self::containsFile(self::$tempDir, '1-10.json'));
  }
}
?>