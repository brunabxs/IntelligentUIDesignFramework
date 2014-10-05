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
    // create genetic algorithm
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);
    $geneticAlgorithm = new GeneticAlgorithm(null, md5(date('YmdHisu')), $populationSize, $genomeSize, 'roulette', 'simple', 'simple', $properties, $user->user_oid);
    $this->geneticAlgorithmDAO->setInstance($geneticAlgorithm);
    $this->geneticAlgorithmDAO->persist();
    $this->geneticAlgorithmDAO->sync();

    // create first generation
    $generation = new Generation(null, '0', $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->generationDAO->setInstance($generation);
    $this->generationDAO->persist();
    $this->generationDAO->sync();

    // generate genomes
    $genomes = array();
    for ($i = 0; $i < $this->geneticAlgorithmDAO->instance->populationSize; $i++)
    {
      $genomes[] = IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance);
    }

    // group genomes
    $genomes = self::countGenomes($genomes);

    // create individuals
    foreach ($genomes as $genome => $count)
    {
      $quantity = $count;
      $properties = IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance, $genome);
      $individual = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->setInstance($individual);
      $this->individualDAO->persist();
    }
  }

  public function createNextGeneration($code)
  {
    // retrieve genetic algorithm
    $geneticAlgorithm = new GeneticAlgorithm(null, $code, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->setInstance($geneticAlgorithm);
    $this->geneticAlgorithmDAO->sync();

    // retrieve last generation
    $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

    // retrieve individuals
    $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

    //TODO: retrieve scores
    //TODO: update individuals' scores
    foreach ($individuals as &$individual)
    {
      $individual->score = 1;
    }
    /*
    $methods = array(0 => array('name'=>'VisitFrequency.get'));
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
    $siteId = 1;
    $token = '09a21a9bf047682b557d6a0193b12189';

    $genomes = array();
    foreach ($individuals as $individual)
    {
      $genomes[] = $individual->genome;
    }
    $scores = PiwikScore::getScores($this->generationDAO->instance->number, $genomes, $methods, $startDate, $endDate, $siteId, $token);
    */

    // apply method for selection
    $selectedIndividuals = call_user_func('GeneticAlgorithmSelection::' . $this->geneticAlgorithmDAO->instance->methodForSelection, $individuals);

    // apply method for crossover
    $newIndividualsGenomes = array();
    for ($i = 0; $i < count($selectedIndividuals); $i += 2)
    {
      $genome1 = $selectedIndividuals[$i]->genome;
      $genome2 = $selectedIndividuals[$i+1]->genome;
      $offsprings = call_user_func('GeneticAlgorithmCrossover::' . $this->geneticAlgorithmDAO->instance->methodForCrossover, $genome1, $genome2);
      $newIndividualsGenomes = array_merge($newIndividualsGenomes, $offsprings);
    }

    // apply method for mutation
    foreach ($newIndividualsGenomes as &$individualGenome)
    {
      $individualGenome = call_user_func('GeneticAlgorithmMutation::' . $this->geneticAlgorithmDAO->instance->methodForMutation, $individualGenome);
    }

    // create generation
    $this->generationDAO->instance->generation_oid = null;
    $this->generationDAO->instance->number += 1;
    $this->generationDAO->persist();
    $this->generationDAO->sync();

    // group genomes
    $genomes = self::countGenomes($newIndividualsGenomes);

    // create individuals
    foreach ($genomes as $genome => $count)
    {
      $quantity = $count;
      $properties = IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance, $genome);
      $individual = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->setInstance($individual);
      $this->individualDAO->persist();
    }
  }

  private static function countGenomes($genomesArray)
  {
    $genomes = array();
    foreach ($genomesArray as $genome)
    {
      if (isset($genomes[$genome]))
      {
        $genomes[$genome] += 1;
      }
      else
      {
        $genomes[$genome] = 1;
      }
    }
    return $genomes;
  }
}
?>
