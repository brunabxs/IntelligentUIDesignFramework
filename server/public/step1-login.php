<?php
  session_start();

  require_once('./smarty/Smarty.class.php');

  $smarty = new Smarty();
  $smarty->setTemplateDir('./smarty_templates/');
  $smarty->setCompileDir('./smarty_templates_c/');

  //$smarty->debugging = true;

  if (!isset($_SESSION['user']))
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      foreach (glob(dirname(__FILE__) . '/../src/*.php') as $filename)
      {
        include $filename;
      }
      $dir = dirname(__FILE__) . '/../resources/';

      if (isset($_POST['txt_user']) && isset($_POST['txt_password']))
      {
        $_SESSION['user'] = $_POST['txt_user'];

        if (is_file(GeneticAlgorithmDAO::getFile($dir)))
        {
          $_SESSION['allow_ga_cretion'] = false;
          header('location:step5-result.php');
        }
        else
        {
          $_SESSION['allow_ga_cretion'] = true;
          header('location:step2-prepare.php');
        }
      }
      else
      {
        header('location:error.php');
      }
    }
    else
    {
      $smarty->assign('AppContentTitle', 'Idenfifique-se');
      $smarty->assign('AppContentInfo', 'Preencha os campos obrigatórios (*) para que possa acessar nossos serviços.');

      $smarty->assign('AppMenu', array('from'=>1, 'to'=>5, 'current'=>1));
      $smarty->assign('AppContent', 'step1-login.tpl');
      $smarty->assign('Controller', 'step1-login.php');
    }
  }
  else
  {
    unset($_SESSION['user']);

    $smarty->assign('AppContentTitle', 'Desloguei você! Idenfifique-se');
    $smarty->assign('AppContentInfo', 'Preencha os campos obrigatórios (*) para que possa acessar nossos serviços.');

    $smarty->assign('AppMenu', array('from'=>1, 'to'=>5, 'current'=>1));
    $smarty->assign('AppContent', 'step1-login.tpl');
    $smarty->assign('Controller', 'step1-login.php');
  }

  $smarty->display('main.tpl');
?>
