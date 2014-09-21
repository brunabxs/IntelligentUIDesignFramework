<?php
  session_start();

  require_once('./smarty/Smarty.class.php');

  $smarty = new Smarty();
  $smarty->setTemplateDir('./smarty_templates/');
  $smarty->setCompileDir('./smarty_templates_c/');

  if (!isset($_SESSION['user']))
  {
    header('location:index.php');
  }

  $smarty->assign('AppContentTitle', 'Suas configurações foram geradas com sucesso!');
  $smarty->assign('AppContentInfo', 'Siga as instruções indicadas para iniciar os experimentos.');

  $smarty->assign('AppMenu', array('from'=>1, 'to'=>3, 'current'=>3));
  $smarty->assign('AppContent', 'finish.tpl');
  $smarty->assign('Content', 'TESTE DE SCRIPT');

  $smarty->display('main.tpl');
?>


