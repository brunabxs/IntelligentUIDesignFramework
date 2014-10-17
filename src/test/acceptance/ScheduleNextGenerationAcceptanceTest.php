<?php
include_once 'MySelenium_TestCase.php';
class ScheduleNextGenerationAcceptanceTest extends MySelenium_TestCase
{
  public function testClientConfiguration_afterComplete_mustGoToScheduleNextGenerationStep()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act
    $this->click(WebDriverBy::id('btn_submit'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 5', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  private function login($user, $password)
  {
    $this->access();
    $user = 'user1';
    $password = '123456';
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);

    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));
  }
}
?>
