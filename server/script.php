<?php
function autoload($class)
{
  include 'src/' . $class . '.php';
}

spl_autoload_register('autoload');

$dir = './resources/';

$code = isset($_GET['code']) ? $_GET['code'] : null;

header("Access-Control-Allow-Origin: *");
echo (new Helper())->getIndividualData($dir, $code);
?>
