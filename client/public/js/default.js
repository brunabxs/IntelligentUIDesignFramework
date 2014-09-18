jQuery(document).ready(function() {
  jQuery('a').click(function() {
    trackEvent('click', 1);
  });
});

var trackEvent = function(name, value) {
  _paq.push(['trackEvent', 'GA', __AppConfig.generation + '.' + __AppConfig.genome, name, value]);
}
