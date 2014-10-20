<?php
class ServerConfigurationAcceptanceTest extends MySelenium_TestCase
{
  public function testServerConfiguration_afterComplete_mustGoToAnalyticsConfigurationStep()
  {
    // Arrange
    $this->login('user1', '123456');
    $size = '4';
    $properties = 'h1:class1; h2:class2;';

    // Act
    $this->write(WebDriverBy::id('txt_generationSize'), $size);
    $this->write(WebDriverBy::id('txt_generationProperties'), $properties);
    $this->click(WebDriverBy::id('btn_submit'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 3', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  private function login($user, $password)
  {
    $this->access();
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);

    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));
  }
}
?>
