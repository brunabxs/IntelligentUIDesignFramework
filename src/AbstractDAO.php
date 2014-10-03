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
      $where = implode(' AND ', $where);
      $where = ' WHERE ' . $where;
    }

    return 'SELECT ' . $select . ' FROM ' . $entityName . $where;
  }

  public static function getInsertQuery($entityName, $instance, $key)
  {
    $attributes = self::getClassAttributes($entityName);
    $insert = implode(', ', $attributes);

    $values = array();
    foreach ($attributes as $attribute)
    {
      if ($key == $attribute)
      {
        $values[] = 'UUID()';
      }
      else if ($instance->$attribute != null)
      {
        $values[] = '\'' . $instance->$attribute . '\'';
      }
      else
      {
        $values[] = 'null';
      }
    }
    $values = implode(', ', $values);
    $values = ' VALUES (' . $values . ')';

    return 'INSERT INTO ' . $entityName . ' (' . $insert . ')' . $values;
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

  public function persistInstance($entityName, $key)
  {
    $result = null;
    if ($this->instance->$key == null)
    {
      $query = self::getInsertQuery($entityName, $this->instance, $key);
      $result = Database::executeInsertQuery($query);
    }
    return $result;
  }
}
?>
