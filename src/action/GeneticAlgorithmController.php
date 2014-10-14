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
    $this->geneticAlgorithmDAO->instance = $geneticAlgorithm;
    $this->geneticAlgorithmDAO->persist();
    $this->geneticAlgorithmDAO->sync();

    // create first generation
    $generation = new Generation(null, '0', $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
    $this->generationDAO->instance = $generation;
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
      $properties = IndividualDAO::generateProperties($this->geneticAlgorithmDAO->instance, $genome);
      $individual = new Individual(null, $genome, $properties, $quantity, null, $this->generationDAO->instance->generation_oid);
      $this->individualDAO->instance = $individual;
      $this->individualDAO->persist();
    }
  }

  public function load($user)
  {
    // retrieve genetic algorithm
    $geneticAlgorithm = new GeneticAlgorithm(null, null, null, null, null, null, null, null, $user->user_oid);
    $this->geneticAlgorithmDAO->instance = $geneticAlgorithm;
    $this->geneticAlgorithmDAO->sync();
  }

  public function createNextGeneration($code)
  {
    // retrieve genetic algorithm
    $geneticAlgorithm = new GeneticAlgorithm(null, $code, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->instance = $geneticAlgorithm;
    $this->geneticAlgorithmDAO->sync();

    // retrieve last generation
    $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

    // retrieve individuals
    $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

    // group genomes
    $genomes = array();
    foreach ($individuals as $individual)
    {
      $genomes[$individual->genome] = $individual->quantity;
    }

    // retrieve scores
    $methods = array(0 => array('name'=>'VisitFrequency.get'));
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d');
    $siteId = 1;
    $token = '09a21a9bf047682b557d6a0193b12189';
    $params = array('methods' => $methods, 'startDate' => $startDate, 'endDate' => $endDate, 'siteId' => $siteId, 'token' => $token);

    $scores = PiwikScoreController::getScores($this->generationDAO->instance->number, $genomes, $params);

    // update individuals' scores
    foreach ($individuals as &$individual)
    {
      $individual->score = $scores[$individual->genome];
      $this->individualDAO->instance = $individual;
      $this->individualDAO->update();
    }

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
    $geneticAlgorithm = new GeneticAlgorithm(null, $geneticAlgorithmCode, null, null, null, null, null, null, null);
    $this->geneticAlgorithmDAO->instance = $geneticAlgorithm;
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
      $individual = $individuals[rand(0, count($individuals) - 1)];
      $this->individualDAO->instance = $individual;
    }
    else
    {
      // retrieve generation
      $generation = new Generation(null, $generation, $this->geneticAlgorithmDAO->instance->geneticAlgorithm_oid);
      $this->generationDAO->instance = $generation;
      $this->generationDAO->sync();

      if ($this->generationDAO->instance !== null)
      {
        // retrieve individual
        $individual = new Individual(null, $genome, null, null, null, $this->generationDAO->instance->generation_oid);
        $this->individualDAO->instance = $individual;
        $this->individualDAO->sync();
      }

      if ($this->generationDAO->instance === null || $this->individualDAO->instance === null)
      {
        // retrieve last generation
        $this->generationDAO->loadLastGeneration($this->geneticAlgorithmDAO->instance);

        // retrieve individuals
        $individuals = $this->individualDAO->loadAllIndividuals($this->generationDAO->instance);

        // retrieve individual
        $individual = $individuals[rand(0, count($individuals) - 1)];
        $this->individualDAO->instance = $individual;
      }
    }

    return self::generateJSON($this->generationDAO->instance, $this->individualDAO->instance);
  }

  private static function generateJSON($generation, $individual)
  {
    $part1 = '"generation":' . $generation->number;
    $part2 = '"genome":"' . $individual->genome . '"';
    $part3 = '"properties":' . $individual->properties;
    return '{' . $part1 . ',' . $part2 . ',' . $part3 . '}';
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
