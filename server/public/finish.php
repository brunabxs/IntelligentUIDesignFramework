<?php
  $txt_script = 'TESTE DE SCRIPT';
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
        <span>Informações Gerais</span>
        <span id="appMenuSelected">Finalização</span>
      </nav>

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">Suas configurações foram geradas com sucesso!</h1>
          <p class="appContentInfo">Siga as instruções indicadas para iniciar os experimentos.</p>
        </header>

        <div class="appContentData">
          <label>Copie e cole no cabeçalho das páginas de sua aplicação</label>
          <pre><?php echo $txt_script; ?></pre>
        </div>

        <footer>Designed by Bruna Xavier</footer>
      </div>
    </div>
  </body>
</html>

