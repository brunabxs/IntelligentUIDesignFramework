<?php
abstract class AbstractDAO
{
  public $instance = null;

  protected function __constructor()
  {
    $this->instance = null;
  }

  abstract public function loadById($id);
  abstract public function persist();
  abstract public function update();
  abstract public function setInstance($instance);
  abstract public function sync();

  private static function getClassAttributes($className)
  {
    $return = array();
    $attributes = get_class_vars($className);
    foreach ($attributes as $name => $value)
    {
      $return[] = $name;
    }
    return $return;
  }

  private static function initInstance($entityName, $params)
  {
    $reflector = new ReflectionClass($entityName);
    return $reflector->newInstanceArgs($params);
  }

  protected static function getSelectQuery($entityName, $params)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getSelectClause($entityName, $entityAttibutes) .
           QueryBuilder::getFromClause($entityName) .
           QueryBuilder::getWhereClause($entityName, $params);
  }

  protected static function getInsertQuery($entityName, $instance, $key)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getInsertClause($entityName, $entityAttibutes) .
           QueryBuilder::getValuesClause($instance, $entityAttibutes, $key);
  }

  protected static function getUpdateQuery($entityName, $instance, $key)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getUpdateClause($entityName) .
           QueryBuilder::getSetClause($instance, $entityAttibutes, $key) .
           QueryBuilder::getWhereClause($entityName, array(array($key, $instance->$key)));
  }

  protected function loadAllInstances($entityName, $params, $append='')
  {
    $this->instance = null;
    $instances = array();

    $query = self::getSelectQuery($entityName, $params) . $append;
    $result = Database::executeSelectQuery($query);
    foreach ($result as $row)
    {
      $instances[] = self::initInstance($entityName, $row);
    }
    return $instances;
  }

  protected function loadInstance($entityName, $params, $append='')
  {
    $this->instance = null;

    $query = self::getSelectQuery($entityName, $params) . $append;
    $result = Database::executeSelectQuery($query);
    if (count($result) === 1)
    {
      $this->instance = self::initInstance($entityName, $result[0]);
    }
    return $result;
  }

  protected function persistInstance($entityName, $key)
  {
    $result = null;
    if ($this->instance->$key == null)
    {
      $query = self::getInsertQuery($entityName, $this->instance, $key);
      $result = Database::executeInsertQuery($query);
    }
    return $result;
  }

  protected function updateInstance($entityName, $key)
  {
    $result = null;
    if ($this->instance->$key != null)
    {
      $query = self::getUpdateQuery($entityName, $this->instance, $key);
      $result = Database::executeUpdateQuery($query);
    }
    return $result;
  }
}

class QueryBuilder
{
  public static function getSelectClause($entityName, $entityAttributes)
  {
    $select = implode(', ', $entityAttributes);
    return 'SELECT ' . $select;
  }

  public static function getFromClause($entityName)
  {
    return ' FROM ' . $entityName;
  }

  public static function getWhereClause($entityName, $params)
  {
    if (count($params) > 0)
    {
      $where = array();
      foreach ($params as $param)
      {
        $where[] = $param[0] . '=\'' . $param[1] . '\'';
      }
      $where = implode(' AND ', $where);
      return ' WHERE ' . $where;
    }
    return '';
  }

  public static function getInsertClause($entityName, $entityAttributes)
  {
    return 'INSERT INTO ' . $entityName . ' (' . implode(', ', $entityAttributes) . ')';
  }

  public static function getValuesClause($instance, $entityAttributes, $entityKeyAttribute)
  {
    $values = array();
    foreach ($entityAttributes as $attribute)
    {
      if ($entityKeyAttribute == $attribute)
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
    return ' VALUES (' . implode(', ', $values) . ')';
  }

  public static function getUpdateClause($entityName)
  {
    return 'UPDATE ' . $entityName;
  }

  public static function getSetClause($instance, $entityAttributes)
  {
    $set = array();
    foreach ($entityAttributes as $attribute)
    {
      if ($instance->$attribute != null)
      {
        $set[] = $attribute . '=\'' . $instance->$attribute . '\'';
      }
      else
      {
        $set[] = $attribute . '=null';
      }
    }
    return ' SET ' . implode(', ', $set);
  }
}
?>
