<?php
include_once 'MyAnotherUnit_Framework_TestCase.php';
class UserControllerUnitTest extends MyAnotherUnit_Framework_TestCase
{
  public function testEncrypt_mustReturnMD5()
  {
    // Arrange
    $data = '123456';

    // Act
    $encryptedData = self::callMethod('UserController', 'encrypt', array($data));

    // Assert
    $this->assertEquals('e10adc3949ba59abbe56e057f20f883e', $encryptedData);
  }
}
?>
