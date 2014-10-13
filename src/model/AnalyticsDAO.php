<?php
class AnalyticsDAO extends AbstractDAO
{
  private static $entity = 'Analytics';
  private static $entityKey = 'analytics_oid';

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
    return parent::loadInstance(self::$entity, array(array('geneticAlgorithm_oid', $this->instance->geneticAlgorithm_oid)));
  }
}
?>
