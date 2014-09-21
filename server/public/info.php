﻿<?php
  session_start();

  require_once('./smarty/Smarty.class.php');

  $smarty = new Smarty();
  $smarty->setTemplateDir('./smarty_templates/');
  $smarty->setCompileDir('./smarty_templates_c/');

  if (!isset($_SESSION['user']))
  {
    header('location:index.php');
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if ($_SESSION['allow_ga_cretion'])
    {
      foreach (glob(dirname(__FILE__) . '/../src/*.php') as $filename)
      {
        include $filename;
      }

      $dir = dirname(__FILE__) . '/../resources/';

      if (isset($_POST['txt_token']) && isset($_POST['txt_versions']) && isset($_POST['txt_prop_json']))
      {
        $json = json_decode($_POST['txt_prop_json']);
        if (!isset($json))
        {
          header('location:error.php');
        }

        try
        {
          $gaDAO = new GeneticAlgorithmDAO();
          $gaDAO->create($dir, $_POST['txt_versions'], json_encode($json), 'roulette', 'simple', 'simple');
          $_SESSION['allow_ga_cretion'] = false;
          header('location:finish.php');
        }
        catch (Exception $e)
        {
          header('location:error.php');
        }
      }
    }
    else
    {
      header('location:error.php');
    }
  }
  else
  {
    if ($_SESSION['allow_ga_cretion'])
    {
      $smarty->assign('AppContentTitle', 'Indique suas informações para configuração do aplicativo');
      $smarty->assign('AppContentInfo', 'Preencha os campos obrigatórios (*) para que seus dados possam ser enviados para nossos servidores.');

      $smarty->assign('AppMenu', array('from'=>1, 'to'=>3, 'current'=>2));
      $smarty->assign('AppContent', 'info-edit.tpl');
      $smarty->assign('Controller', 'info.php');
    }
    else
    {
      $smarty->assign('AppContentTitle', 'Veja as informações de configuração do aplicativo');
      $smarty->assign('AppContentInfo', 'Veja os dados enviados enviados para nossos servidores.');

      $smarty->assign('AppMenu', array('from'=>1, 'to'=>2, 'current'=>2));
      $smarty->assign('AppContent', 'info-view.tpl');
    }
  }

  $smarty->display('main.tpl');
?>
