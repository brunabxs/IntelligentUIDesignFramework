<?php
  require 'vendor/autoload.php';

  session_start();

  function processUserLoginPage()
  {
    try
    {
      $controller = new UserController();
      $controller->login($_POST['txt_user'], $_POST['txt_password']);
      $_SESSION['user'] = $controller->userDAO->instance;
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processServerConfiguration()
  {
    $json = json_decode($_POST['txt_prop_json']);
    if (!isset($json))
    {
      return false;
    }

    try
    {
      $controller = new GeneticAlgorithmController();
      $controller->create($_SESSION['user'], $_POST['txt_versions'], json_encode($json));

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->serverConfiguration = '1';
      $controller->update();
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processClientConfiguration()
  {
    try
    {
      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->clientConfiguration = '1';
      $controller->update();
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function processScheduleNextGeneration()
  {
    try
    {
      $controller = new GeneticAlgorithmController();
      $controller->load($_SESSION['user']);
      $code = $controller->geneticAlgorithmDAO->instance->code;

      CronController::removeAllJobs();
      CronController::addJob($code);

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->scheduleNextGeneration = '1';
      $controller->update();
      return true;
    }
    catch (Exception $e)
    {
      return false;
    }
  }

  function loadPage()
  {
    if (!isset($_SESSION['user']))
    {
      PagesController::loadUserLoginPage();
    }
    else
    {
      $processController = new ProcessController();
      $processController->load($_SESSION['user']);

      if (!$processController->processDAO->instance->serverConfiguration)
      {
        PagesController::loadServerConfigurationPage();
      }
      else if (!$processController->processDAO->instance->clientConfiguration)
      {
        $controller = new GeneticAlgorithmController();
        $controller->load($_SESSION['user']);

        PagesController::loadClientConfigurationPage($controller->geneticAlgorithmDAO->instance);
      }
      else if (!$processController->processDAO->instance->scheduleNextGeneration)
      {
        PagesController::loadScheduleNextGenerationPage();
      }
      else
      {
        PagesController::loadVisualizationPage();
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    if (isset($_POST['txt_user']) && isset($_POST['txt_password']) && processUserLoginPage())
    {
      loadPage();
    }
    else if (isset($_POST['txt_token']) && isset($_POST['txt_versions']) && isset($_POST['txt_prop_json']) && processServerConfiguration())
    {
      loadPage();
    }
    else if (isset($_POST['txt_script']) && processClientConfiguration())
    {
      loadPage();
    }
    else if (isset($_POST['txt_start']) && processScheduleNextGeneration())
    {
      loadPage();
    }
    else
    {
      header('location:error.php');
    }
  }
  else
  {
    loadPage();
  }
?>
