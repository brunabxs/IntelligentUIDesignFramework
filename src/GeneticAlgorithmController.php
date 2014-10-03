<?php
class GeneticAlgorithmController
{
  public $geneticAlgorithmDAO;

  public function __construct()
  {
    $this->geneticAlgorithmDAO = new GeneticAlgorithmDAO();
  }

  public function create($user, $populationSize, $properties)
  {
    $geneticAlgorithm = new GeneticAlgorithm(null, $populationSize, null, 'roulette', 'simple', 'simple', $properties, $user->user_oid);
    $this->geneticAlgorithmDAO->setInstance($geneticAlgorithm);
    $this->geneticAlgorithmDAO->persist();
  }

  public function execute()
  {
    $lastGeneration = PopulationDAO::getLastGeneration($this->dir);
    if (isset($lastGeneration))
    {
      $generation = $this->ga->population->generation;

      $genomes = array();
      foreach ($this->ga->population->individuals as $individual)
      {
        $genomes[] = $individual->genome;
      }

      $methods = array(0 => array('name'=>'VisitFrequency.get'));
      $startDate = date('Y-m-d');
      $endDate = date('Y-m-d');
      $siteId = 1;
      $token = '09a21a9bf047682b557d6a0193b12189';

      $scores = PiwikScore::getScores($generation, $genomes, $methods, $startDate, $endDate, $siteId, $token);

      foreach ($this->ga->population->individuals as $individual)
      {
        $individual->score = $scores[$individual->genome];
      }

      $this->ga->population = $this->createNewGeneration($scores);
    }
    $this->gaDAO->save($this->dir, $this->ga);
  }

  private function createNewGeneration($scores)
  {
    // select
    $selectedIndividuals = call_user_func('MethodsForSelection::' . $this->ga->methodForSelection, $this->ga->population->individuals);

    // crossover
    $newIndividuals = array();
    for ($i = 0; $i < count($selectedIndividuals); $i += 2)
    {
      $genome1 = $selectedIndividuals[$i]->genome;
      $genome2 = $selectedIndividuals[$i+1]->genome;
      $offsprings = call_user_func('MethodsForCrossover::' . $this->ga->methodForCrossover, $genome1, $genome2);
      $newIndividuals = array_merge($newIndividuals, $offsprings);
    }

    // mutation
    foreach ($newIndividuals as &$individualGenome)
    {
      $individualGenome = call_user_func('MethodsForMutation::' . $this->ga->methodForMutation, $individualGenome);
    }

    return $this->populationDAO->create($this->ga, $this->ga->population->generation + 1, $newIndividuals);
  }
}
?>
