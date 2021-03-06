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
      var url = (('https:' == document.location.protocol) ? 'https' : 'http') + '://" . SERVER_WO_PROTOCOL . "/';

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
    else if ($type == 'google-old')
    {
      echo
      "
        var pushToWebAnalyticsTool = function()
        {
          _gaq.push(['_setCustomVar', 1, 'GA', getCookie(), 'page']);
          _gaq.push(['_trackPageview']);
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
      var newGaCode = '';
      $.ajax({
        url: url + 'load-indiv.php?code=" . $geneticAlgorithmCode . "' + (gaCode ? '&indiv=' + gaCode : ''),
        type: 'get',
        crossDomain: true
      })
      .done(function(config, textStatus)
      {
        try
        {
          config = JSON.parse(config.trim());
          newGaCode = config.generation + '.' + config.genome;
          if (config != newGaCode)
          {
            setCookie(newGaCode);
          }
          gaProperties = config.properties;
          pushToWebAnalyticsTool();
        }
        catch (e)
        {
        }
      })
      .fail(function(jqxhr, settings, exception)
      {
        console.log('ERROR!');
      })
      .always(function()
      {
        $(document).executeGA();
      });

      $.fn.executeGA = function()
      {
        if (gaProperties)
        {
          for (var element in gaProperties)
          {
            this.find(element).addClass(gaProperties[element]);
          }
        }
        return this;
      }
    }( jQuery ));
  ";
?>
