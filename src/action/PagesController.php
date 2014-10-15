﻿<?php
class PagesController
{
  private static $pages = array(
    1 => array('AppContentTitle' => 'Idenfifique-se',
               'AppContentInfo'  => 'Preencha os campos obrigatórios (*) para que possa acessar nossos serviços.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>1),
               'AppContent'      => 'step1-access.tpl'),

    2 => array('AppContentTitle' => 'Indique suas informações para configuração do aplicativo',
               'AppContentInfo'  => 'Preencha os campos obrigatórios (*) para que seus dados possam ser enviados para nossos servidores.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>2),
               'AppContent'      => 'step2-prepare.tpl',
               'Controller'      => 'index.php'),

    3 => array('AppContentTitle' => 'Suas configurações foram geradas com sucesso!',
               'AppContentInfo'  => 'Siga as instruções indicadas para iniciar os experimentos.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>3),
               'AppContent'      => 'step3-script.tpl',
               'Controller'      => 'index.php',
               'gaCode'          => '1234555'),

    4 => array('AppContentTitle' => 'Está quase tudo pronto',
               'AppContentInfo'  => 'Confirme o início dos experimentos',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>4),
               'AppContent'      => 'step4-start.tpl',
               'Controller'      => 'index.php'),

    5 => array('AppContentTitle' => 'Veja as informações de configuração do aplicativo',
               'AppContentInfo'  => 'Veja os dados enviados enviados para nossos servidores.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>5),
               'AppContent'      => 'step5-result.tpl'),

    'logout' => array('AppContentTitle' => 'Você foi deslogado!',
                      'AppContentInfo'  => 'Entre em contado com email@email e dê seu feedback do serviço.'),

    'error' => array('AppContentTitle' => 'Ooopsie! Ocorreu um erro no nosso servidor',
                     'AppContentInfo'  => 'Entre em contado com email@email e relate o ocorrido.'),
  );

  private static function build($page, $otherParameters=array())
  {
    $smarty = new Smarty();
    $smarty->setTemplateDir('./smarty_templates/');
    $smarty->setCompileDir('./smarty_templates_c/');

    foreach (self::$pages[$page] as $key => $value)
    {
      $smarty->assign($key, $value);
    }

    foreach ($otherParameters as $key => $value)
    {
      $smarty->assign($key, $value);
    }

    $smarty->display('main.tpl');
  }

  public static function loadUserAccessPage($user=NULL, $password=NULL, $userErrorMessage=NULL, $passwordErrorMessage=NULL)
  {
    $otherParameters = array();

    if ($user) $otherParameters['user'] = $user;
    if ($password) $otherParameters['password'] = $password;
    if ($userErrorMessage) $otherParameters['message_user'] = $userErrorMessage;
    if ($passwordErrorMessage) $otherParameters['message_password'] = $passwordErrorMessage;

    PagesController::build(1, $otherParameters);
  }

  public static function loadServerConfigurationPage()
  {
    PagesController::build(2);
  }

  public static function loadClientConfigurationPage($geneticAlgorithm)
  {
    PagesController::build(3, array('code'=>$geneticAlgorithm->code));
  }

  public static function loadScheduleNextGenerationPage()
  {
    PagesController::build(4);
  }

  public static function loadVisualizationPage($geneticAlgorithm)
  {
    PagesController::build(5, array('populationSize'=>$geneticAlgorithm->populationSize,
                                    'properties'=>$geneticAlgorithm->properties));
  }

  public static function loadErrorPage()
  {
    PagesController::build('error');
  }

  public static function loadLogoutPage()
  {
    PagesController::build('logout');
  }
}
?>
