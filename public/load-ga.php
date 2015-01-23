<?php
  require '../vendor/autoload.php';
  header('Content-Type: text/javascript; charset=UTF-8');

  $geneticAlgorithmCode = $_GET['code'];
  $cookieName = 'gaCode';
  $cookieExpirationTime = 24 * 60 * 60 * 1000; //ms

  $controller = new AnalyticsController();
  $type = $controller->getType($geneticAlgorithmCode);

  echo
  "
    (function($) {
      $.holdReady(true);

      var url = (('https:' == document.location.protocol) ? 'https' : 'http') + '://" . SERVER_WO_PROTOCOL . ":" . PORT . "/';

      var setCookie = function(newValue, currentValue)
      {
        if (currentValue) return;
        var date = new Date();
        date.setTime(date.getTime() + (" . $cookieExpirationTime . "));
        var expires = 'expires=' + date.toUTCString();
        document.cookie = '" . $cookieName . "=' + newValue + '; ' + expires;
      };

      var getCookie = function()
      {
        var name = '" . $cookieName . "=';
        var cookies = document.cookie.split(';');
        for (var i=0; i < cookies.length; i++)
        {
          var cookie = cookies[i];
          while (cookie.charAt(0) == ' ') cookie = cookie.substring(1);
          if (cookie.indexOf(name) != -1) return cookie.substring(name.length, cookie.length);
        }
        return '';
      };
    ";

    if ($type == 'piwik')
    {
      echo
      "
        var pushToWebAnalyticsTool = function()
        {
          _paq.push(['setCustomVariable', 1, 'GA', getCookie(), 'page']);
          _paq.push(['trackPageView']);
          _paq.push(['enableLinkTracking']);
        };
      ";
    }
    else if ($type == 'google')
    {
      echo
      "
        var pushToWebAnalyticsTool = function()
        {
          ga('set', 'dimension1', getCookie());
        };
      ";
    }
    else
    {
      echo
      "
        var pushToWebAnalyticsTool = function()
        {
        };
      ";

    }

    echo
    "
      var gaProperties;
      var gaCode = getCookie();
      $.ajax({
        url: url + 'load-indiv.php?code=" . $geneticAlgorithmCode . "' + (gaCode ? '&indiv=' + gaCode : ''),
        type: 'get',
        crossDomain: true
      })
      .done(function(config, textStatus)
      {
        config = JSON.parse(config.trim());
        setCookie(config.generation + '.' + config.genome);
        gaProperties = config.properties;
        pushToWebAnalyticsTool();
      })
      .fail(function(jqxhr, settings, exception)
      {
        console.log('ERROR!');
      })
      .always(function()
      {
        $.holdReady(false);
      });

      $.fn.executeGA = function()
      {
        for (var element in gaProperties)
        {
          this.find(element).addClass(gaProperties[element]);
        }
        return this;
      }
    }( jQuery ));
  ";
?>

