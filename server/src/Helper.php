<?php
class Helper
{
  public function __construct()
  {
    $this->gaDAO = new GeneticAlgorithmDAO();
    $this->individualDAO = new IndividualDAO();
  }

  public function getIndividualData($dir, $code)
  {
    $generation = null;
    $genome = null;

    $code = preg_split('/\./', $code);
    if (count($code) == 2)
    {
      $generation = $code[0];
      $genome = $code[1];
    }

    $ga = $this->gaDAO->load($dir, $generation);

    $generation = $ga->population->generation;
    $index = self::findIndividualIndex($ga->population->individuals, $genome);
    $individual = $ga->population->individuals[$index];

    return $this->individualDAO->getFileContent($dir, $generation, $index, $individual->genome);
  }

  private static function findIndividualIndex($individuals, $genome)
  {
    $genomes = array();
    foreach ($individuals as $individual)
    {
      $genomes[] = $individual->genome;
    }
    
    $index = array_search($genome, $genomes);

    if (!isset($index) || $index == false)
    {
      $index = rand(0, count($genomes) - 1);
    }

    return $index;
  }
}
