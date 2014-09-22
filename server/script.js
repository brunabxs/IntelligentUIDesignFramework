(function($) {
  $.holdReady(true);

  var url = (('https:' == document.location.protocol) ? 'https' : 'http') + '://localhost/';

  var setCookie = function(newValue, currentValue)
  {
    if (currentValue) return;
    var date = new Date();
    date.setTime(date.getTime() + (24*60*60*1000));
    var expires = 'expires=' + date.toUTCString();
    document.cookie = 'gaCode=' + newValue + '; ' + expires;
  };

  var getCookie = function()
  {
    var name = 'gaCode=';
    var cookies = document.cookie.split(';');
    for (var i=0; i < cookies.length; i++)
    {
      var cookie = cookies[i];
      while (cookie.charAt(0) == ' ') cookie = cookie.substring(1);
      if (cookie.indexOf(name) != -1) return cookie.substring(name.length, cookie.length);
    }
    return '';
  };

  var gaProperties;
  var gaCode = getCookie();
  $.ajax({
    url: url + 'script.php' + (gaCode ? '?code='+gaCode : ''),
    type: 'get',
    crossDomain: true,
    dataType:'json'
  })
  .done(function(config, textStatus)
  {
    setCookie(config.generation + '.' + config.genome);
    gaProperties = config.properties;

    //_paq.push(['setCustomVariable', 1, 'GA', _GA.getCookie(), 'page']);
    //_paq.push(['trackPageView']);
    //_paq.push(['enableLinkTracking']);
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
