<?php
function autoload($class)
{
  include 'src/' . $class . '.php';
}

spl_autoload_register('autoload');

$dir = './resources/';

$code = isset($_GET['code']) ? $_GET['code'] : null;

echo Helper::getIndividualData($dir, $code);
?>
