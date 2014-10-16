<?php
include_once 'MySelenium_TestCase.php';
class AccessAcceptanceTest extends MySelenium_TestCase
{
  public function testTitle()
  {
    // Arrange
    $this->access();

    // Act

    // Assert
    $this->assertEquals('Server App', $this->driver->getTitle());
  }

  public function testLogin_userThatDoesNotExist_mustShowMessage()
  {
    // Arrange
    $this->access();
    $user = 'user1';
    $password = '123456';

    // Act
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);
    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('msg_txt_user'));

    // Assert
    $this->assertEquals('User does not exist', $this->text(WebDriverBy::id('msg_txt_user')));
  }
}
?>
