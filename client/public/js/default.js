jQuery(document).ready(function() {
  jQuery('a').click(function() {
    _paq.push(['trackEvent', 'Link', 'Click', jQuery(this).text()]);
  });
});
