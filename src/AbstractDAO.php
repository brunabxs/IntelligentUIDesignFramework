<?php
class AbstractDAO
{
  public $instance = null;

  public function __constructor()
  {
    $this->instance = null;
  }

  public static function getClassAttributes($className)
  {
    $return = array();
    $attributes = get_class_vars($className);
    foreach ($attributes as $name => $value)
    {
      $return[] = $name;
    }
    return $return;
  }

  public static function getSelectQuery($entityName, $params)
  {
    $select = implode(', ', self::getClassAttributes($entityName));

    if (count($params) === 0)
    {
      $where = '';
    }
    else
    {
      $where = array();
      foreach ($params as $param)
      {
        $where[] = $param[0] . '=\'' . $param[1] . '\'';
      }
      $where = implode(' and ', $where);
      $where = ' where ' . $where;
    }
    return 'SELECT ' . $select . ' from ' . $entityName . $where;
  }

  public static function getInstance($entityName, $params)
  {
    $reflector = new ReflectionClass($entityName);
    return $reflector->newInstanceArgs($params);
  }

  public function loadInstance($entityName, $params)
  {
    $this->instance = null;

    $query = self::getSelectQuery($entityName, $params);
    $result = Database::executeSelectQuery($query);
    if (count($result) === 1)
    {
      $this->instance = self::getInstance($entityName, $result[0]);
    }
    return $result;
  }
}
?>
