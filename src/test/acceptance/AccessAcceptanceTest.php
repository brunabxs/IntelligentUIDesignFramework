<?php
class AccessAcceptanceTest extends PHPUnit_Extensions_Selenium2TestCase
{
  protected function setUp()
  {
    $this->setBrowser('firefox');
    $this->setBrowserUrl('http://localhost:8000/');
  }

  public function testTitle()
  {
    $this->url('http://localhost:8000/index.php');
    $this->assertEquals('Server App', $this->title());
  }
}
?>
