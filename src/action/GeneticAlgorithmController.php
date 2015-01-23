<?php
class GeneticAlgorithmController
{
  public $geneticAlgorithmDAO;
  public $generationDAO;
  public $individualDAO;
  public $scoreController;

  public function __construct()
  {
    $this->geneticAlgorithmDAO = new GeneticAlgorithmDAO();
    $this->generationDAO = new GenerationDAO();
    $this->individualDAO = new IndividualDAO();
    $this->scoreController = new ScoreController();
  }

  public function create($user, $populationSize, $properties)
  {
    // create genetic algorithm
    $genomeSize = GeneticAlgorithmDAO::generateGenomeSize($properties);
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, md5(date('YmdHisu')), $populationSize, $genomeSize, 'roulette', 'simple', 'simple', $properties, $user->user_oid);
    $this->geneticAlgorithmDAO->persist();
    $this->geneticAlgorithmDAO->sync();

    // create first generation
    $this->generationDAO->instance = new Generation(null, '0', $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->generationDAO->persist();
    $this->generationDAO->sync();

    // generate genomes
    $genomes = array();
    for ($i = 0; $i < $this->geneticAlgorithmDAO->instance->populationSize; $i++)
    {
      $genomes[] = $this->generateGenome();
    }

    // group genomes
    $genomes = self::countGenomes($genomes);

    // create individuals
    foreach ($genomes as $genome => $count)
    {
      $quantity = $count;
      $properties = IndividualDAO::generateProperties($this->geneticAlgorithmDAO->instance, $genome);
      $this->individualDAO->instance = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->persist();
    }
  }

  public function generateGenome()
  {
    return IndividualDAO::generateGenome($this->geneticAlgorithmDAO->instance);
  }

  public function load($user)
  {
    // retrieve genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, null, null, null, null, null, null, null, $user->user_oid);
    $this->geneticAlgorithmDAO->sync();
  }

  public function createNextGeneration($code)
  {
    // retrieve genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, $code, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->sync();

    // retrieve last generation
    $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

    // update individuals' scores
    $startDate = date('Y-m-d', strtotime('-1 month'));
    $endDate = date('Y-m-d');
    $this->scoreController->updateScores($this->geneticAlgorithmDAO->instance, $this->generationDAO->instance, $startDate, $endDate);

    // retrieve last generation's individuals
    $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

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
      $properties = IndividualDAO::generateProperties($this->geneticAlgorithmDAO->instance, $genome);
      $individual = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->instance = $individual;
      $this->individualDAO->persist();
    }
  }

  public function exportIndividualJSON($geneticAlgorithmCode, $generationAndIndividualCode)
  {
    // retrieve genetic algorithm
    $this->geneticAlgorithmDAO->instance = new GeneticAlgorithm(null, $geneticAlgorithmCode, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->sync();

    if ($this->geneticAlgorithmDAO->instance === null)
    {
      return null;
    }

    $generation = null;
    $genome = null;

    $generationAndIndividualCode = preg_split('/\./', $generationAndIndividualCode);
    if (count($generationAndIndividualCode) == 2)
    {
      $generation = $generationAndIndividualCode[0];
      $genome = $generationAndIndividualCode[1];
    }

    if ($generation === null && $genome === null)
    {
      // retrieve last generation
      $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

      // retrieve individuals
      $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

      // retrieve individual
      $this->individualDAO->instance = $individuals[rand(0, count($individuals) - 1)];
    }
    else
    {
      // retrieve generation
      $this->generationDAO->instance = new Generation(null, $generation, $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
      $this->generationDAO->sync();

      if ($this->generationDAO->instance !== null)
      {
        // retrieve individual
        $this->individualDAO->instance = new Individual(null, $genome, null, null, null, $this->generationDAO->instance->generation_oid);
        $this->individualDAO->sync();
      }

      if ($this->generationDAO->instance === null || $this->individualDAO->instance === null)
      {
        // retrieve last generation
        $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

        // retrieve individuals
        $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

        // retrieve individual
        $this->individualDAO->instance = $individuals[rand(0, count($individuals) - 1)];
      }
    }

    return self::generateJSON($this->generationDAO->instance, $this->individualDAO->instance);
  }

  private static function generateJSON($generation, $individual)
  {
    $array = array('generation'=>$generation->number,
          'genome'=>$individual->genome,
          'properties'=>json_decode($individual->properties, true));
    return json_encode($array);
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
