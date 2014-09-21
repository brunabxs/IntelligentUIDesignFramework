<?php
  session_start();

  $token = $_SESSION['token'];
  $edit = $_SESSION['allow_ga_cretion'];

  if ($edit)
  {
    header('location:error.php');
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
        <span>Login</span>
        <span id="appMenuSelected">Informações Gerais</span>
      </nav>

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">Veja as informações de configuração do aplicativo</h1>
          <p class="appContentInfo">Veja os dados enviados enviados para nossos servidores.</p>
        </header>

        <div class="appContentData">
          <label>Ferramenta de Web Analytics utilizada</label>
          <span id="txt_analyticsTool">Piwik</span>

          <label>Token de acesso da Piwik</label>
          <span id="txt_token"><?php echo $token; ?></span>

          <label>Número de versões</label>
          <span id="txt_versions">-</span>

          <label>Número máximo de experimentos</label>
          <span id="txt_exp">-</span>

          <label>Tempo máximo de execução de um experimento (dias)</label>
          <span id="txt_time">-</span>

          <label for="txt_prop">Elementos e classes no formato JSON</label>
          <div id="txt_prop">-</div>
        </div>

        <footer>Designed by Bruna Xavier</footer>
      </div>
    </div>
  </body>
</html>
