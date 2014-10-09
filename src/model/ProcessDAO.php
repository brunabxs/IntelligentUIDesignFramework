<?php
class ProcessDAO extends AbstractDAO
{
  private static $entity = 'Process';
  private static $entityKey = 'process_oid';

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
    return parent::loadInstance(self::$entity, array(array('user_oid', $this->instance->user_oid)));
  }
}
?>
