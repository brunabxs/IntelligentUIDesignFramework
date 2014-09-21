<?php
  session_start();

  include dirname(__FILE__) . '/../src/PagesController.php';

  unset($_SESSION['user']);

  PagesController::build('error');
?>
