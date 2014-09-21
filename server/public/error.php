<?php
  session_start();

  foreach (glob(dirname(__FILE__) . '/../src-public/*.php') as $filename)
  {
    include $filename;
  }

  require './smarty/Smarty.class.php';

  unset($_SESSION['user']);

  $smarty = new Smarty();
  $smarty->setTemplateDir('./smarty_templates/');
  $smarty->setCompileDir('./smarty_templates_c/');
  PagesController::build($smarty, 'error');
  $smarty->display('main.tpl');
?>
