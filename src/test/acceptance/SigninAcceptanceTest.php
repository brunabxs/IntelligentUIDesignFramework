<?php
include_once 'MySelenium_TestCase.php';
class SigninAcceptanceTest extends MySelenium_TestCase
{
  public function testSignin_userThatDoesNotExist_mustGoToServerConfiguration()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_signin'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 2', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testSignin_userThatDoesNotExist_mustShowLogout()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_signin'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuLogout'));

    // Assert
    $this->assertEquals('Logout', $this->text(WebDriverBy::id('appMenuLogout')));
  }

  public function testSignin_userThatDoesNotExist_mustCreateUser()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_signin'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    $this->click(WebDriverBy::id('appMenuLogout'));

    $this->access();
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 2', $this->text(WebDriverBy::id('appMenuSelected')));
  }

  public function testSignin_userThatExists_mustShowMessage()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '654321';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_signin'));
    $this->waitPresenceOfElement(WebDriverBy::id('msg_txt_user'));

    // Assert
    $this->assertEquals('User already exists', $this->text(WebDriverBy::id('msg_txt_user')));
  }
}
?>
