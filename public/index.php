<?php
  require '../vendor/autoload.php';

  session_start();

  function processUserLogin()
  {
    try
    {
      $controller = new UserController();
      $controller->login($_POST['txt_user'], $_POST['txt_password']);
      $_SESSION['user'] = $controller->userDAO->instance;

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      if ($e->getMessage() === 'User does not exist')
      {
        PagesController::loadUserAccessPage($_POST['txt_user'], NULL, 'User does not exist', NULL);
        return;
      }

      if ($e->getMessage() === 'Password is not correct')
      {
        PagesController::loadUserAccessPage($_POST['txt_user'], $_POST['txt_password'], NULL, 'Password is not correct');
        return;
      }

      PagesController::loadErrorPage();
    }
  }

  function processUserSignin()
  {
    try
    {
      $controller = new UserController();
      $controller->create($_POST['txt_user'], $_POST['txt_password']);
      $_SESSION['user'] = $controller->userDAO->instance;

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      if ($e->getMessage() === 'User already exists')
      {
        PagesController::loadUserAccessPage($_POST['txt_user'], NULL, 'User already exists', NULL);
        return;
      }

      PagesController::loadErrorPage();
    }
  }

  function processServerConfiguration()
  {
    $json = json_decode($_POST['txt_generationProperties_json']);
    if (!isset($json))
    {
      PagesController::loadErrorPage();
      return;
    }

    try
    {
      $controller = new GeneticAlgorithmController();
      $controller->create($_SESSION['user'], $_POST['txt_generationSize'], json_encode($json));

      $code = $controller->geneticAlgorithmDAO->instance->code;
      CronController::addJob($code);

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->serverConfiguration = '1';
      $controller->update();

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      PagesController::loadErrorPage();
      return;
    }
  }

  function processAnalyticsConfigurationType()
  {
    if ($_POST['analyticsType'] == 'piwik')
    {
      PagesController::loadAnalyticsConfigurationPiwikContent();
      return;
    }
    else if ($_POST['analyticsType'] == 'google-old')
    {
      PagesController::loadAnalyticsConfigurationGoogleOldContent();
      return;
    }
    else if ($_POST['analyticsType'] == 'google')
    {
      PagesController::loadAnalyticsConfigurationGoogleContent();
      return;
    }
  }

  function processAnalyticsConfigurationPiwik()
  {
    try
    {
      $json = json_decode($_POST['txt_metrics_json'], true);

      $controller = new AnalyticsController();
      $controller->create($_SESSION['user'], $_POST['txt_analyticsTool'], $_POST['txt_analyticsToken'], $_POST['txt_analyticsSiteId'], $json);

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->analyticsConfiguration = '1';
      $controller->update();

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      PagesController::loadErrorPage();
      return;
    }
  }

  function processAnalyticsConfigurationGoogleOld()
  {
    try
    {
      $json = json_decode($_POST['txt_metrics_json'], true);

      $controller = new AnalyticsController();
      $controller->create($_SESSION['user'], $_POST['txt_analyticsTool'], $_POST['txt_analyticsId'], null, $json);

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->analyticsConfiguration = '1';
      $controller->update();

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      PagesController::loadErrorPage();
      return;
    }
  }


  function processAnalyticsConfigurationGoogle()
  {
    try
    {
      $json = json_decode($_POST['txt_metrics_json'], true);

      $controller = new AnalyticsController();
      $controller->create($_SESSION['user'], $_POST['txt_analyticsTool'], $_POST['txt_analyticsId'], null, $json);

      $controller = new ProcessController();
      $controller->load($_SESSION['user']);
      $controller->processDAO->instance->analyticsConfiguration = '1';
      $controller->update();

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      PagesController::loadErrorPage();
      return;
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

      loadPage();
      return;
    }
    catch (Exception $e)
    {
      PagesController::loadErrorPage();
      return;
    }
  }

  function loadPage()
  {
    if (!isset($_SESSION['user']))
    {
      PagesController::loadUserAccessPage();
    }
    else
    {
      $processController = new ProcessController();
      $processController->load($_SESSION['user']);

      if (!$processController->processDAO->instance->serverConfiguration)
      {
        PagesController::loadServerConfigurationPage();
      }
      else if (!$processController->processDAO->instance->analyticsConfiguration)
      {
        PagesController::loadAnalyticsConfigurationPage();
      }
      else if (!$processController->processDAO->instance->clientConfiguration)
      {
        $controller = new GeneticAlgorithmController();
        $controller->load($_SESSION['user']);

        PagesController::loadClientConfigurationPage($controller->geneticAlgorithmDAO->instance);
      }
      else
      {
        $controller = new GeneticAlgorithmController();
        $controller->load($_SESSION['user']);
        $geneticAlgorithm = $controller->geneticAlgorithmDAO->instance;

        $controller = WebAnalyticsFactory::init($geneticAlgorithm);
        $analytics = $controller->analytics;
        $analyticsData = $controller->extractAnalyticsData();

        if ($analytics->type == 'piwik')
        {
          PagesController::loadVisualizationPiwikPage($geneticAlgorithm, $analytics, $analyticsData);
        }
        else if ($analytics->type == 'google-old')
        {
          PagesController::loadVisualizationGoogleOldPage($geneticAlgorithm, $analytics, $analyticsData);
        }
        else if ($analytics->type == 'google')
        {
          PagesController::loadVisualizationGooglePage($geneticAlgorithm, $analytics, $analyticsData);
        }
        else
        {
          PagesController::loadErrorPage();
        }
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    if (isset($_POST['txt_user']) && isset($_POST['txt_password']) && isset($_POST['hidden_type']) && $_POST['hidden_type'] === 'login')
    {
      processUserLogin();
    }
    else if (isset($_POST['txt_user']) && isset($_POST['txt_password']) && isset($_POST['hidden_type']) && $_POST['hidden_type'] === 'signin')
    {
      processUserSignin();
    }
    else if (isset($_POST['txt_generationSize']) && isset($_POST['txt_generationProperties_json']))
    {
      processServerConfiguration();
    }
    else if (isset($_POST['analyticsType']))
    {
      processAnalyticsConfigurationType();
    }
    else if (isset($_POST['txt_analyticsTool']) && $_POST['txt_analyticsTool'] == 'piwik' && isset($_POST['txt_analyticsToken']) && isset($_POST['txt_analyticsSiteId']) && isset($_POST['txt_metrics_json']))
    {
      processAnalyticsConfigurationPiwik();
    }
    else if (isset($_POST['txt_analyticsTool']) && $_POST['txt_analyticsTool'] == 'google-old' && isset($_POST['txt_metrics_json']))
    {
      processAnalyticsConfigurationGoogleOld();
    }
    else if (isset($_POST['txt_analyticsTool']) && $_POST['txt_analyticsTool'] == 'google' && isset($_POST['txt_metrics_json']))
    {
      processAnalyticsConfigurationGoogle();
    }
    else if (isset($_POST['txt_ready']))
    {
      processClientConfiguration();
    }
    else
    {
      PagesController::loadErrorPage();
    }
  }
  else
  {
    loadPage();
  }
?>
