<?php
abstract class MySelenium_TestCase extends PHPUnit_Extensions_Database_TestCase
{
  private static $pdo = null;

  private $connection = null;

  private static $waitTime = 10;

  private static $defaultURL = null;

  protected $driver = null;

  protected function setUp()
  {
    parent::setUp();

    self::$defaultURL = 'http://' . SERVER . ':' . PORT . '/';

    $host = 'http://localhost:4444/wd/hub';
    $capabilities = DesiredCapabilities::firefox();
    $this->driver = RemoteWebDriver::create($host, $capabilities, 5000);
  }

  protected function tearDown()
  {
    parent::tearDown();

    exec('crontab -r');

    $this->driver->quit();
  }

  final public function getConnection()
  {
    if ($this->connection === null)
    {
      if (self::$pdo == null)
      {
        self::$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWD);
      }
      $this->connection = $this->createDefaultDBConnection(self::$pdo, DB_DBNAME);
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
    $datasetDir = dirname(__FILE__) . '/' . get_class($this) . '/';

    $myScenarioFile = $datasetDir . $this->getName() . '.xml';
    if (is_file($myScenarioFile))
    {
      return $this->createFlatXmlDataSet($myScenarioFile);
    }

    $baseScenarioFile = $datasetDir . 'base.xml';
    if (is_file($baseScenarioFile))
    {
      return $this->createFlatXmlDataSet($datasetDir . 'base.xml');
    }

    return null;
  }

  final protected function access($page='index.php')
  {
    $this->driver->get(self::$defaultURL . $page);
  }

  final protected function getElement($by)
  {
    return $this->driver->findElement($by);
  }

  final protected function text($by)
  {
    return $this->getElement($by)->getText();
  }

  final protected function write($by, $text)
  {
    $this->getElement($by)->clear()->sendKeys($text);
  }

  final protected function select($by, $label)
  {
    (new WebDriverSelect($this->getElement($by)))->selectByVisibleText($label);
  }

  final protected function click($by)
  {
    $this->getElement($by)->click();
  }

  final protected function waitPresenceOfElement($by)
  {
    $this->driver->wait(self::$waitTime)->until(WebDriverExpectedCondition::presenceOfAllElementsLocatedBy($by));
  }
}
?>
