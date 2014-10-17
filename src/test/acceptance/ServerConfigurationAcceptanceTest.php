<?php
class ServerConfigurationAcceptanceTest extends MySelenium_TestCase
{
  public function testServerConfiguration_afterComplete_mustGoToClientConfigurationStep()
  {
    // Arrange
    $this->login('user1', '123456');
    $token = 'token123';
    $versions = '4';
    $properties = 'h1:class1; h2:class2;';

    // Act
    $this->write(WebDriverBy::id('txt_token'), $token);
    $this->write(WebDriverBy::id('txt_versions'), $versions);
    $this->write(WebDriverBy::id('txt_prop'), $properties);
    $this->click(WebDriverBy::id('btn_submit'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 3', $this->text(WebDriverBy::id('appMenuSelected')));
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
