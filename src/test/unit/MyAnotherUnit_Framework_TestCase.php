<?php
abstract class MyAnotherUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{
  public static function callMethod($className, $methodName, $args)
  {
    $class = new ReflectionClass($className);
    $method = $class->getMethod($methodName);
    $method->setAccessible(true);
    return $method->invokeArgs(null, $args);
  }
}
?>
