<?php
  session_start();

  require_once('./smarty/Smarty.class.php');

  $smarty = new Smarty();
  $smarty->setTemplateDir('./smarty_templates/');
  $smarty->setCompileDir('./smarty_templates_c/');

  if (!isset($_SESSION['user']))
  {
    header('location:step1-login.php');
  }

  $smarty->assign('AppContentTitle', 'Suas configurações foram geradas com sucesso!');
  $smarty->assign('AppContentInfo', 'Siga as instruções indicadas para iniciar os experimentos.');

  $smarty->assign('AppMenu', array('from'=>1, 'to'=>5, 'current'=>3));
  $smarty->assign('AppContent', 'step3-script.tpl');
  $smarty->assign('Content', 'TESTE DE SCRIPT');

  $smarty->display('main.tpl');
?>


