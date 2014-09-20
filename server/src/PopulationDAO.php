<?php
class PopulationDAO
{
  public function __construct()
  {
    $this->individualDAO = new IndividualDAO();
  }

  public function create($ga, $generation)
  {
    $individuals = array();
    for ($i = 0; $i < $ga->populationSize; $i++)
    {
      $individuals[] = $this->individualDAO->create($ga);
    }

    return new Population($generation, $individuals);
  }

  public function load($dir, $ga, $generation)
  {
    $json = file_get_contents(self::getFile($dir, $generation));
    $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json);
    $json = json_decode($json);

    $individuals = $this->individualDAO->load($dir, $ga, $generation, $json->individuals);

    return new Population($generation, $individuals);
  }

  public function loadLastGeneration($dir, $ga)
  {
    return $this->load($dir, $ga, self::getLastGeneration($dir));
  }

  public function save($dir, $population)
  {
    foreach ($population->individuals as $index => $individual)
    {
      $this->individualDAO->save($dir, $population->generation, $index, $individual);
    }

    $json = self::convertToJSON($population);
    file_put_contents(self::getFile($dir, $population->generation), $json, LOCK_EX);
  }

  public static function getLastGeneration($dir)
  {
    $lastGeneration = null;
    if ($handle = opendir($dir))
    {
      while (($file = readdir($handle)) !== false)
      {
        if (!in_array($file, array('.', '..')) && !is_dir($dir . $file) && strpos($file, '-GA.json'))
        {
          $lastGeneration = max(explode('-', $file)[0], $lastGeneration);
        }
      }
    }
    return $lastGeneration;
  }

  public static function getFile($dir, $generation)
  {
    return $dir . $generation . '-GA.json';
  }

  public static function convertToJSON($population)
  {
    $genomes = array();
    foreach ($population->individuals as $individual)
    {
      $genomes[] = $individual->genome;
    }

    return json_encode(array('generation' => $population->generation,
                             'individuals' => $genomes));
  }
}
