var _paq = _paq || [];
(function() {
  var url = (("https:" == document.location.protocol) ? "https" : "http") + "://localhost/";

  var myCode;
  var cookie = document.cookie.split(';')
  if ( cookie.length > 0 && cookie[0].indexOf('myCode') != -1)
  {
    myCode = cookie[0].substring('myCode'.length, cookie[0].length);
  }

  // metrics and styles
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
  var myCode;
  var cookie = document.cookie.split(';')
  if ( cookie.length > 0 && cookie[0].indexOf('myCode') != -1)
  {
    myCode = cookie[0].substring('myCode'.length, cookie[0].length);
  }

  if (!myCode)
  {
    myCode = __AppConfig.generation + '.' + __AppConfig.genome;
    document.cookie='myCode=' + myCode + ';expires=' + (new Date((new Date()).getTime() + (1*24*60*60*1000)).toUTCString()) + ';path=/';
  }

  _paq.push(['setCustomVariable', 1, 'GA', myCode, 'page']);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);

  if ( __AppConfig )
  {
    for ( var element in __AppConfig.classes )
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
        elements[i].setAttribute('class', classAttr + __AppConfig.classes[element])
      }
    }
  }
}
