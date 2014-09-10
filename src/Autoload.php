<?php
function autoload($class) {
  include 'src/' . $class . '.php';
}

spl_autoload_register('autoload');
?>