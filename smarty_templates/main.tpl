<!DOCTYPE html>
<html>
  <head>
    <title>Server App</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
    <script type="text/javascript" src="js/lib/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
  </head>
  <body>
    <div id="appModal"><p></p></div>
    <div id="appWrapper">
      {if isset($AppMenu)}
        <nav id="appMenu">
          {for $index={$AppMenu['from']} to {$AppMenu['current']}-1}
            <span>Passo {$index}</span>
          {/for}

          <span id="appMenuSelected">Passo {$AppMenu['current']}</span>

          {for $index={$AppMenu['current']}+1 to {$AppMenu['to']}}
            <span>Passo {$index}</span>
          {/for}

          {if isset($smarty.session.user)}
            <a id="appMenuLogout" href="logout.php">Logout</a>
          {/if}
        </nav>
      {/if}

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">{$AppContentTitle}</h1>
          <p class="appContentInfo">{$AppContentInfo}</p>
        </header>

        {if isset($AppContent)}
          <div class="appContentData">
            {include file={$AppContent}}
          </div>
        {/if}

        <footer>Designed by Bruna Xavier</footer>
      </section>
    </div>
  </body>
</html>

