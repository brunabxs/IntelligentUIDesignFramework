<?php
  session_start();

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    foreach (glob(dirname(__FILE__) . '/../src/*.php') as $filename)
    {
      include $filename;
    }

    $dir = dirname(__FILE__) . '/../resources/';

    if (isset($_POST['txt_user']) && isset($_POST['txt_password']))
    {
      $_SESSION['token'] = $_POST['txt_user'];

      // login / signin
      if (is_file(GeneticAlgorithmDAO::getFile($dir)))
      {
        // login
        $_SESSION['allow_ga_cretion'] = false;
        header('location:info-view.php');
      }
      else
      {
        // signin
        $_SESSION['allow_ga_cretion'] = true;
        header('location:info-edit.php');
      }
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
        <span id="appMenuSelected">Login</span>
      </nav>

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">Idenfifique-se</h1>
          <p class="appContentInfo">Preencha os campos obrigatórios (*) para que possa acessar nossos serviços.</p>
        </header>

        <form name="form_redirect" method="post" action="index.php" class="appContentData">
          <label for="txt_user" class="required">Usuário</label>
          <input id="txt_user" name="txt_user" type="text" title="" required autofocus />

          <label for="txt_password" class="required">Senha</label>
          <input id="txt_password" name="txt_password" type="password" title="" required />

          <input id="btn_login" name="btn_login" type="submit" value="Entrar" class="appContentButton" />
          <input id="btn_signin" name="btn_signin" type="submit" value="Cadastrar" class="appContentButton" />
        </form>

        <footer>Designed by Bruna Xavier</footer>
      </div>
    </div>
  </body>
</html>
