<?php
abstract class AbstractDAO
{
  public $instance = null;
  protected $entityName = null;
  protected $entityKey = null;

  protected function __construct($entityName, $entityKey)
  {
    $this->instance = null;
    $this->entityName = $entityName;
    $this->entityKey = $entityKey;
  }

  abstract public function sync();

  public function loadById($id)
  {
    return $this->loadInstance($this->entityName, array(array($this->entityKey, $id)));
  }

  public function persist()
  {
    return $this->persistInstance($this->entityName, $this->entityKey);
  }

  public function update()
  {
    return $this->updateInstance($this->entityName, $this->entityKey);
  }

  protected function load($params, $append='')
  {
    return $this->loadInstance($this->entityName, $params, $append);
  }

  protected function loadAll($params, $append='')
  {
    return $this->loadAllInstances($this->entityName, $params, $append);
  }

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

  private static function getSelectQuery($entityName, $params)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getSelectClause($entityName, $entityAttibutes) .
           QueryBuilder::getFromClause($entityName) .
           QueryBuilder::getWhereClause($entityName, $params);
  }

  private static function getInsertQuery($entityName, $instance, $key)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getInsertClause($entityName, $entityAttibutes) .
           QueryBuilder::getValuesClause($instance, $entityAttibutes, $key);
  }

  private static function getUpdateQuery($entityName, $instance, $key)
  {
    $entityAttibutes = self::getClassAttributes($entityName);
    return QueryBuilder::getUpdateClause($entityName) .
           QueryBuilder::getSetClause($instance, $entityAttibutes, $key) .
           QueryBuilder::getWhereClause($entityName, array(array($key, $instance->$key)));
  }

  private function loadAllInstances($entityName, $params, $append='')
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

  private function loadInstance($entityName, $params, $append='')
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

  private function persistInstance($entityName, $key)
  {
    $result = null;
    if ($this->instance->$key == null)
    {
      $query = self::getInsertQuery($entityName, $this->instance, $key);
      $result = Database::executeInsertQuery($query);
    }
    return $result;
  }

  private function updateInstance($entityName, $key)
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
