<?php
class GeneticAlgorithmTest extends PHPUnit_Framework_TestCase
{
  private static $dir = './tests/temp/';

  protected function tearDown()
  {
    $files = glob(self::$dir . '*');
    foreach ($files as $file)
    {
      if (is_file($file))
      {
        unlink($file);
      }
    }
  }

  public function testConstructor_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(2, $ga->genomeSize);

    $this->assertEquals(array('class1'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(2, $ga->genomeSize);

    $this->assertEquals(array('class1', 'class2'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringOneElementAndFiveClasses()
  {
    $jsonString = '{"h1":["class1","class2","class3","class4","class5"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(3, $ga->genomeSize);

    $this->assertEquals(array('class1', 'class2', 'class3', 'class4', 'class5'), $ga->json['h1']['classes']);
    $this->assertEquals(3, $ga->json['h1']['bits']);
  }

  public function testConstructor_jsonStringTwoElementsAndOneClassForEach()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);

    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(4, $ga->genomeSize);

    $this->assertEquals(array('class1'), $ga->json['h1']['classes']);
    $this->assertEquals(2, $ga->json['h1']['bits']);
    $this->assertEquals(array('class2'), $ga->json['h2']['classes']);
    $this->assertEquals(2, $ga->json['h2']['bits']);
  }

  public function testConstructor_jsonStringTwoElementsAndOneClassForFirstAndThreeClassesForSecond()
  {
    $jsonString = '{"h1":["class1"],"h2":["class2","class3","class4"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $this->assertEquals(1, $ga->maxIndividuals);
    $this->assertEquals(5, $ga->genomeSize);

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
      $ga = new GeneticAlgorithm(1, null, $jsonString);
      $this->assertFail('Exception expected');
    }
    catch (Exception $e)
    {
      $this->assertEquals('Declare jsonFile or jsonString', $e->getMessage());
      return;
    }
    $this->assertFail('Exception expected');
  }

  public function testCreateIndividuals_jsonStringOneElementAndOneClass()
  {
    $jsonString = '{"h1":["class1"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $ga->createIndividuals(self::$dir);
    $this->assertEquals(1, self::helperCountFiles(self::$dir));
  }

  public function testCreateIndividuals_jsonStringOneElementAndTwoClasses()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(2, null, $jsonString);
    $ga->createIndividuals(self::$dir);
    $this->assertEquals(2, self::helperCountFiles(self::$dir));
  }

  public function testLoadIndividuals()
  {
    $jsonString = '{"h1":["class1","class2"]}';
    $ga = new GeneticAlgorithm(1, null, $jsonString);
    $ga->loadIndividuals('./tests/testLoadIndividuals-GeneticAlgorithm/');
    $this->assertEquals(1, count($ga->individuals));
    $this->assertEquals('01', $ga->individuals[0]->genome);
  }

  public function testSelectIndividuals_rouletteAsSelectionMethod()
  {
    $jsonString = '{"h1":["class1","class2","class3"]}';
    $ga = new GeneticAlgorithm(2, null, $jsonString);
    $ga->loadIndividuals('./tests/testSelectIndividuals_rouletteAsSelectionMethod-GeneticAlgorithm/');
    $ga->individuals[0]->score = 0.6;
    $ga->individuals[1]->score = 0.4;
    $selectIndividuals = $ga->selectIndividuals();
    $this->assertEquals(2, count($selectIndividuals));
  }

  private static function helperCountFiles($dir)
  {
    $numFiles = 0;
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
        {
          $numFiles++;
        }
      }
    }
    return $numFiles;
  }
}
?>