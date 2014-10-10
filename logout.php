<?php
  session_start();

  require 'vendor/autoload.php';

  unset($_SESSION['user']);

  PagesController::loadLogoutPage();
?>
