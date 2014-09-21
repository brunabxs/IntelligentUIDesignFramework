<?php
class PagesController
{
  public static $pages = array(
    1 => array('AppContentTitle' => 'Idenfifique-se',
               'AppContentInfo'  => 'Preencha os campos obrigatórios (*) para que possa acessar nossos serviços.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>1),
               'AppContent'      => 'step1-login.tpl',
               'Controller'      => 'index.php'),

    2 => array('AppContentTitle' => 'Indique suas informações para configuração do aplicativo',
               'AppContentInfo'  => 'Preencha os campos obrigatórios (*) para que seus dados possam ser enviados para nossos servidores.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>2),
               'AppContent'      => 'step2-prepare.tpl',
               'Controller'      => 'index.php'),

    3 => array('AppContentTitle' => 'Suas configurações foram geradas com sucesso!',
               'AppContentInfo'  => 'Siga as instruções indicadas para iniciar os experimentos.',
               'AppMenu'         => array('from'=>1, 'to'=>5, 'current'=>3),
               'AppContent'      => 'step3-script.tpl',
               'Content'         => 'TESTE DE SCRIPT',
               'Controller'      => 'index.php'),

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
  
  public static function build($page)
  {
    require '../public/smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->setTemplateDir('./smarty_templates/');
    $smarty->setCompileDir('./smarty_templates_c/');

    foreach (self::$pages[$page] as $key => $value)
    {
      $smarty->assign($key, $value);
    }

    $smarty->display('main.tpl');
  }
}
?>
