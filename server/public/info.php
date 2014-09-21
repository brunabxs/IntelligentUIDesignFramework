<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if (isset($_POST['txt_token']) && isset($_POST['txt_versions']) && isset($_POST['txt_prop_json']))
    {
      $json = json_decode($_POST['txt_prop_json']);
      if (!isset($json))
      {
        header('location:error.php');
      }

      $properties = array("populationSize"     => $_POST['txt_versions'],
                          "methodForSelection" => "roulette",
                          "methodForCrossover" => "simple",
                          "methodForMutation"  => "simple",
                          "properties"         => json_encode($json));
      // salvar

      die (json_encode($properties));

      //header('location:finish.php');
    }
    else
    {
      header('location:error.php');
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Server App</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
  </head>
  <body>
    <div id="appWrapper">
      <nav id="appMenu">
        <span>Cadastro</span>
        <span id="appMenuSelected">Informações Gerais</span>
        <span>Finalização</span>
      </nav>

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">Indique suas informações para configuração do aplicativo</h1>
          <p class="appContentInfo">Preencha os campos obrigatórios (*) para que seus dados possam ser enviados para nossos servidores.</p>
        </header>

        <form name="form_generalInformation" method="post" action="info.php" class="appContentData" onsubmit="return validate();">
          <label>Ferramenta de Web Analytics utilizada</label>
          <span id="txt_analyticsTool">Piwik</span>

          <label for="token" class="required">Token de acesso da Piwik</label>
          <input id="txt_token" name="txt_token" type="text" title="" required autofocus />

          <label for="versions" class="required">Número de versões</label>
          <input id="txt_versions" name="txt_versions" type="number" min="1" step="1" title="" required />

          <label>Número máximo de experimentos</label>
          <span id="txt_exp">-</span>

          <label>Tempo máximo de execução de um experimento (dias)</label>
          <span id="txt_time">-</span>

          <label for="app3" class="required">Elementos e classes no formato JSON</label>
          <textarea id="txt_prop" name="txt_prop" title="" required></textarea>
          <input id="txt_prop_json" name="txt_prop_json" type="hidden" />

          <input id="btn_submit" name="btn_submit" type="submit" value="Send" class="appContentButton" />
        </form>

        <footer>Designed by Bruna Xavier</footer>
      </div>
    </div>
  </body>
</html>
