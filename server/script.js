var _paq = _paq || [];
(function() {
  var u=(("https:" == document.location.protocol) ? "https" : "http") + "://localhost/piwik/";
  _paq.push(['setTrackerUrl', u+'piwik.php']);
  _paq.push(['setSiteId', 1]);
  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
  g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
})();

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

  var pushToWebAnalyticsTool = function()
  {
    _paq.push(['setCustomVariable', 1, 'GA', getCookie(), 'page']);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
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
