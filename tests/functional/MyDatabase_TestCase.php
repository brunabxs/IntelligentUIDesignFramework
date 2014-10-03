<?php
abstract class MyDatabase_TestCase extends PHPUnit_Extensions_Database_TestCase
{
  private static $pdo = null;

  private $connection = null;

  protected function setUp()
  {
    parent::setUp();
    Database::$dsn = $GLOBALS['DB_DSN'];
    Database::$user = $GLOBALS['DB_USER'];
    Database::$password = $GLOBALS['DB_PASSWD'];
  }

  final public function getConnection()
  {
    if ($this->connection === null)
    {
      if (self::$pdo == null)
      {
        self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
      }
      $this->connection = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
    }
    return $this->connection;
  }

  public function getSetUpOperation()
  {
    // If you want cascading truncates, false otherwise. If unsure choose false.
    $cascadeTruncates = true;
    return new PHPUnit_Extensions_Database_Operation_Composite(array(new TruncateOperation($cascadeTruncates), PHPUnit_Extensions_Database_Operation_Factory::INSERT()));
  }

  final public function getDataSet()
  {
    $datasetDir = dirname(__FILE__) . '/' . get_class($this) . '/dataset/';
    $baseScenario = $this->createFlatXmlDataSet($datasetDir . 'base.xml');
    $myScenarioFile = $datasetDir . $this->getName() . '.xml';

    if (is_file($myScenarioFile))
    {
      $myScenario = $this->createFlatXmlDataSet($myScenarioFile);
      $compositeScenario = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
      $compositeScenario->addDataSet($baseScenario);
      $compositeScenario->addDataSet($myScenario);
      return $compositeScenario;
    }
    return $baseScenario;
  }

  public function getExpectedDataset($file)
  {
    return dirname(__FILE__) . '/' . get_class($this) . '/' . $this->getName() . '_expected/' . $file;
  }
}

class TruncateOperation extends PHPUnit_Extensions_Database_Operation_Truncate
{
  public function execute(PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
  {
    $connection->getConnection()->query("SET foreign_key_checks = 0");
    parent::execute($connection, $dataSet);
    $connection->getConnection()->query("SET foreign_key_checks = 1");
  }
}
?>
