var _paq = _paq || [];
(function() {
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);

  var url = (("https:" == document.location.protocol) ? "https" : "http") + "://localhost/";
  _paq.push(['setTrackerUrl', url + 'piwik/piwik.php']);
  _paq.push(['setSiteId', 1]);

  // metrics and styles
  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
  g.defer=true; g.async=true; g.src=url+'script.php';
  s.parentNode.insertBefore(g,s);

  // piwik
  g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
  g.defer=true; g.async=true; g.src=url+'piwik/piwik.js';
  s.parentNode.insertBefore(g,s);
})();

window.onload = function() {
  // TODO load classes
}
