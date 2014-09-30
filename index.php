<?php
  session_start();

  require 'vendor/autoload.php';
  define('RESOURCES_DIR', dirname(__FILE__) . '/resources/');

  function processStep1()
  {
    $_SESSION['user'] = $_POST['txt_user'];
    return true;
  }

  function processStep2()
  {
    $json = json_decode($_POST['txt_prop_json']);
    if (!isset($json))
    {
      return false;
    }
    try
    {
      $gaDAO = new GeneticAlgorithmDAO();
      $gaDAO->create(RESOURCES_DIR, $_POST['txt_versions'], json_encode($json), 'roulette', 'simple', 'simple');
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processStep3()
  {
    try
    {
      file_put_contents(RESOURCES_DIR . 'script-ready.txt', '');
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processStep4()
  {
    try
    {
      $controller = new GeneticAlgorithmController(RESOURCES_DIR);
      $controller->execute();

      CronController::removeAllJobs();
      CronController::addJob();
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
    if (!isset($_SESSION['user']))
    {
      $_SESSION['step'] = 1;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file(GeneticAlgorithmDAO::getFile(RESOURCES_DIR)))
    {
      $_SESSION['step'] = 2;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file(RESOURCES_DIR . 'script-ready.txt'))
    {
      $_SESSION['step'] = 3;
      PagesController::build($_SESSION['step']);
    }
    else if (!is_file(PopulationDAO::getFile(RESOURCES_DIR, 0)))
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
