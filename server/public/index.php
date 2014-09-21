<?php
  session_start();

  foreach (glob(dirname(__FILE__) . '/../src/*.php') as $filename)
  {
    include $filename;
  }

  function processStep1()
  {
    $_SESSION['user'] = $_POST['txt_user'];
    return true;
  }

  function processStep2()
  {
    $dir = dirname(__FILE__) . '/../resources/';
    $json = json_decode($_POST['txt_prop_json']);
    if (!isset($json))
    {
      return false;
    }
    try
    {
      $gaDAO = new GeneticAlgorithmDAO();
      $gaDAO->create($dir, $_POST['txt_versions'], json_encode($json), 'roulette', 'simple', 'simple');
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processStep3()
  {
    $dir = dirname(__FILE__) . '/../resources/';
    try
    {
      file_put_contents($dir . 'script-ready.txt', '');
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processStep4()
  {
    $dir = dirname(__FILE__) . '/../resources/';
    try
    {
      $controller = new GeneticAlgorithmController($dir);
      $controller->execute();
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function redirectToError()
  {
    header('location:error.php');
  }

  function redirect()
  {
    $dir = dirname(__FILE__) . '/../resources/';

    if (!isset($_SESSION['user']))
    {
      $_SESSION['step'] = 1;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file(GeneticAlgorithmDAO::getFile($dir)))
    {
      $_SESSION['step'] = 2;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file($dir . 'script-ready.txt'))
    {
      $_SESSION['step'] = 3;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file(PopulationDAO::getFile($dir, 0)))
    {
      $_SESSION['step'] = 4;
      PagesController::build($_SESSION['step']);
    }
    else
    {
      $_SESSION['step'] = 5;
      PagesController::build($_SESSION['step']);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if (!isset($_SESSION['user']) && isset($_POST['txt_user']) && isset($_POST['txt_password']))
    {
      if (processStep1())
      {
        $_SESSION['step'] = 1;
        redirect();
      }
      else
      {
        redirectToError();
      }
    }
    else if ($_SESSION['step'] == 2 && isset($_POST['txt_token']) && isset($_POST['txt_versions']) && isset($_POST['txt_prop_json']))
    {
      if (processStep2())
      {
        redirect();
      }
      else
      {
        redirectToError();
      }
    }
    else if ($_SESSION['step'] == 3 && isset($_POST['txt_script']))
    {
      if (processStep3())
      {
        redirect();
      }
      else
      {
        redirectToError();
      }
    }
    else if ($_SESSION['step'] == 4 && isset($_POST['txt_start']))
    {
      if (processStep4())
      {
        redirect();
      }
      else
      {
        redirectToError();
      }
    }
  }
  else
  {
    redirect();
  }
?>
