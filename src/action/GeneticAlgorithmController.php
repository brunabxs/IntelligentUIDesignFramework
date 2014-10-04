<?php
class GeneticAlgorithmController
{
  public $geneticAlgorithmDAO;
  public $generationDAO;
  public $individualDAO;

  public function __construct()
  {
    $this->geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $this->generationDAO = new GenerationDAO();
    $this->individualDAO = new IndividualDAO();
  }

  public function create($user, $populationSize, $properties)
  {
    $geneticAlgorithm = new GeneticAlgorithm(null, $populationSize, null, 'roulette', 'simple', 'simple', $properties, $user->user_oid);
    $this->geneticAlgorithmDAO->setInstance($geneticAlgorithm);
    $this->geneticAlgorithmDAO->persist();
    $this->geneticAlgorithmDAO->sync();

    $generation = new Generation(null, '0', $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->generationDAO->setInstance($generation);
    $this->generationDAO->persist();
    $this->generationDAO->sync();

    $genomes = array();
    for ($i = 0; $i < $this->geneticAlgorithmDAO->instance->populationSize; $i++)
    {
      $genome = IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance);
      if (isset($genomes[$genome]))
      {
        $genomes[$genome] += 1;
      }
      else
      {
        $genomes[$genome] = 1;
      }
    }

    foreach ($genomes as $genome => $count)
    {
      $quantity = $count;
      $properties = IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance, $genome);
      $individual = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->setInstance($individual);
      $this->individualDAO->persist();
    }
  }
}
?>
