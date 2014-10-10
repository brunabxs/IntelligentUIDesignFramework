<?php
class Database
{
  public static $dsn = 'mysql:host=localhost;dbname=db_dev';
  public static $user = 'root';
  public static $password = '';

  private static $connection = null;

  public static function getConnection()
  {
    if (self::$connection == null)
    {
      self::$connection = new PDO(self::$dsn, self::$user, self::$password);
    }
    return self::$connection;
  }

  public static function closeConnection()
  {
    self::$connection = null;
  }

  public static function executeSelectQuery($query)
  {
    $resultSQL = self::getConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    self::closeConnection();
    return $resultSQL;
  }

  public static function executeInsertQuery($query)
  {
    $resultSQL = self::getConnection()->exec($query);
    self::closeConnection();
    return $resultSQL;
  }

  public static function executeUpdateQuery($query)
  {
    $resultSQL = self::getConnection()->exec($query);
    self::closeConnection();
    return $resultSQL;
  }
}
?>
