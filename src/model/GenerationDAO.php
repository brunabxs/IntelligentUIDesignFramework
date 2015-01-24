<?php
class GenerationDAO extends AbstractDAO
{
  public function __construct()
  {
    parent::__construct('Generation', 'generation_oid');
  }

  public function sync()
  {
    return parent::load(array(array('number', $this->instance->number),
                        array('geneticAlgorithm_oid', $this->instance->geneticAlgorithm_oid)));
  }

  public function loadAllGenerations($geneticAlgorithm)
  {
    return parent::loadAll(array(array('geneticAlgorithm_oid', $geneticAlgorithm->geneticAlgorithm_oid)), ' ORDER BY number ');
  }

  public function loadLastGeneration($geneticAlgorithm)
  {
    return parent::load(array(array('geneticAlgorithm_oid', $geneticAlgorithm->geneticAlgorithm_oid)), ' ORDER BY number DESC LIMIT 1');
  }
}
?>
