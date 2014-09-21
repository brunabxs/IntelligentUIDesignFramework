var _paq = _paq || [];
var _GA = _GA || {};
_GA.cookie = 'myCode';
_GA.setCookie = function(cvalue)
{
  if (_GA.getCookie()) return;

  var date = new Date();
  date.setTime(date.getTime() + (24*60*60*1000));
  var expires = "expires=" + date.toUTCString();
  document.cookie = _GA.cookie + "=" + cvalue + "; " + expires;
};
_GA.getCookie = function()
{
  var name = _GA.cookie + "=";
  var cookies = document.cookie.split(';');
  for (var i=0; i < cookies.length; i++)
  {
    var cookie = cookies[i];
    while (cookie.charAt(0) == ' ') cookie = cookie.substring(1);
    if (cookie.indexOf(name) != -1) return cookie.substring(name.length, cookie.length);
  }
  return "";
};

(function() {
  var url = (("https:" == document.location.protocol) ? "https" : "http") + "://localhost/";

  var myCode = _GA.getCookie();

  // styleClasses
  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
  g.defer=true; g.async=false; g.src=url+'script.php' + (myCode ? '?code='+myCode : '');
  s.parentNode.insertBefore(g,s);

  _paq.push(['setTrackerUrl', url + 'piwik/piwik.php']);
  _paq.push(['setSiteId', 1]);

  // piwik
  g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
  g.defer=true; g.async=true; g.src=url+'piwik/piwik.js';
  s.parentNode.insertBefore(g,s);
})();

window.onload = function()
{
  _GA.setCookie(__AppConfig.generation + '.' + __AppConfig.genome);

  _paq.push(['setCustomVariable', 1, 'GA', _GA.getCookie(), 'page']);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);

  if ( __AppConfig )
  {
    for ( var element in __AppConfig.properties )
    {
      // find all elements
      var elements;
      if ( element.startsWith('.') )
      {
        elements = document.getElementsByClassName(element.replace('\.', ''));
      }
      else if ( element.startsWith('#') )
      {
        elements = [document.getElementById(element.replace('#', ''))];
      }
      else
      {
        elements = document.getElementsByTagName(element);
      }

      // for each element, append class
      for ( var i = 0; i < elements.length; i++ )
      {
        var classAttr = elements[i].getAttribute('class');
        classAttr = classAttr ? classAttr : '';
        elements[i].setAttribute('class', classAttr + __AppConfig.properties[element])
      }
    }
  }
}
