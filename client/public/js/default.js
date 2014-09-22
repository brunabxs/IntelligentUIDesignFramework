jQuery(document).ready(function() {
  jQuery(this).executeGA();

  jQuery('a').click(function() {
    _paq.push(['trackEvent', 'Link', 'Click', jQuery(this).text()]);
  });
});
