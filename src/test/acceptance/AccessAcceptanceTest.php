<?php
class AccessAcceptanceTest extends MySelenium_TestCase
{
  public function testAccess_userNotLoggedIn_mustShowUserLoginStep()
  {
    // Arrange

    // Act
    $this->access();

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());

    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));
    $this->assertEquals('Passo 1', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testAccess_userLoggedInServerConfigurationStepNotCompleted_mustShowServerConfigurationStep()
  {
    // Arrange
    $user = 'user1';
    $password = '123456';

    // Act
    $this->login($user, $password);

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());

    $this->assertEquals('Passo 2', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testAccess_userLoggedInAnalyticsConfigurationStepNotCompleted_mustShowAnalyticsConfigurationStep()
  {
    // Arrange
    $user = 'user1';
    $password = '123456';

    // Act
    $this->login($user, $password);

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());

    $this->assertEquals('Passo 3', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testAccess_userLoggedInClientConfigurationStepNotCompleted_mustShowClientConfigurationStep()
  {
    // Arrange
    $user = 'user1';
    $password = '123456';

    // Act
    $this->login($user, $password);

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());

    $this->assertEquals('Passo 4', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testAccess_userLoggedInAllStepsCompleted_mustShowVisualizationStep()
  {
    // Arrange
    $user = 'user1';
    $password = '123456';

    // Act
    $this->login($user, $password);

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());

    $this->assertEquals('Passo 5', $this->text(WebDriverBy::id('appMenuSelected')));
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
