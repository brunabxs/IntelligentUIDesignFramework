<?php
  session_start();

  foreach (glob(dirname(__FILE__) . '/../src-public/*.php') as $filename)
  {
    include $filename;
  }

  unset($_SESSION['user']);

  PagesController::build('logout');
?>
