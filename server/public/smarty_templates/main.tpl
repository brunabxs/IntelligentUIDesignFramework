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
        {for $index={$AppMenu['from']} to {$AppMenu['current']}-1}
          <span>Passo {$index}</span>
        {/for}
        <span id="appMenuSelected">Passo {$AppMenu['current']}</span>
        {for $index={$AppMenu['current']}+1 to {$AppMenu['to']}}
          <span>Passo {$index}</span>
        {/for}
      </nav>

      <section id="appContent">
        <header>
          <h1 class="appContentTitle">{$AppContentTitle}</h1>
          <p class="appContentInfo">{$AppContentInfo}</p>
        </header>

        {include file={$AppContent}}

        <footer>Designed by Bruna Xavier</footer>
      </div>
    </div>
  </body>
</html>

