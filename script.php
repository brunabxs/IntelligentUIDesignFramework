<?php
require 'vendor/autoload.php';

define('RESOURCES_DIR', dirname(__FILE__) . './resources/');

$code = isset($_GET['code']) ? $_GET['code'] : null;

header("Access-Control-Allow-Origin: *");
echo (new Helper())->getIndividualData(RESOURCES_DIR, $code);
?>
