<?php
include_once 'MySelenium_TestCase.php';
class LoginAcceptanceTest extends MySelenium_TestCase
{
  public function testLogin_userThatExists_mustGoToServerConfigurationStep()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 2', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testLogin_userThatExists_mustShowLogout()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuLogout'));

    // Assert
    $this->assertEquals('Logout', $this->text(WebDriverBy::id('appMenuLogout')));
  }

  public function testLogin_userThatDoesNotExist_mustShowMessage()
  {
    // Arrange
    $this->access();
    $user = 'user2';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('msg_txt_user'));

    // Assert
    $this->assertEquals('User does not exist', $this->text(WebDriverBy::id('msg_txt_user')));
  }

  public function testLogin_passwordThatDoesNotExist_mustShowMessage()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123457';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('msg_txt_password'));

    // Assert
    $this->assertEquals('Password is not correct', $this->text(WebDriverBy::id('msg_txt_password')));
  }
}
?>
