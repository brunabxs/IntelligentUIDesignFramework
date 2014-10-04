<?php
class GenerationDAO extends AbstractDAO
{
  private static $entity = 'Generation';
  private static $entityKey = 'generation_oid';

  public function __constructor()
  {
    parent::__constructor();
  }

  public function loadById($id)
  {
    return parent::loadInstance(self::$entity, array(array(self::$entityKey, $id)));
  }

  public function persist()
  {
    return parent::persistInstance(self::$entity, self::$entityKey);
  }

  public function update()
  {
    return parent::updateInstance(self::$entity, self::$entityKey);
  }

  public function setInstance($instance)
  {
    $this->instance = $instance;
  }

  public function sync()
  {
    return parent::loadInstance(self::$entity, array(array('number', $this->instance->number),
                                                     array('geneticAlgorithm_oid', $this->instance->geneticAlgorithm_oid)));
  }

  public function loadLastGeneration($geneticAlgorithm)
  {
    return parent::loadInstance(self::$entity, array(array('geneticAlgorithm_oid', $geneticAlgorithm->geneticAlgorithm_oid)), ' ORDER BY number DESC LIMIT 1');
  }
}
?>
