<?php
class IndividualDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('Individual', 'individual_oid');
  }

  public function sync()
  {
    return parent::load(array(array('genome', $this->instance->genome),
                        array('generation_oid', $this->instance->generation_oid)));
  }

  public function loadAllIndividuals($generation)
  {
    return parent::loadAll(array(array('generation_oid', $generation->generation_oid)), ' ORDER BY genome ');
  }

  public static function generateGenome($geneticAlgorithm)
  {
    $genome = '';
    for ($i = 0; $i < $geneticAlgorithm->genomeSize; $i++)
    {
      $rand = rand(0, 1);
      $genome .= "$rand";
    }
    return $genome;
  }

  public static function generateProperties($geneticAlgorithm, $genome)
  {
    $decodedProperties = json_decode($geneticAlgorithm->properties);
    $properties = array();
    $start = 0;
    foreach ($decodedProperties as $element => $classes)
    {
      $numClasses = count($classes);
      $numBits = ceil(log($numClasses+1, 2));
      $genomePart = substr($genome, $start, $numBits);
      $index = bindec($genomePart);
      $start += $numBits;

      if ($index == 0 || $index > $numClasses)
      {
        $properties[$element] = '';
      }
      else
      {
        $properties[$element] = $classes[$index-1];
      }
    }
    return json_encode($properties);
  }
}
