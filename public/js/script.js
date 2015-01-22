jQuery(document).ready(function() {
  jQuery('#txt_analyticsTool').change(function() {
    jQuery('#analyticsInfo').hide();
    jQuery('#analyticsWait').show();

    jQuery.post('index.php', {analyticsType:jQuery(this).val()}, function(data) {
      jQuery('#analyticsInfo').html(data.trim());
      jQuery('#analyticsWait').hide();
      jQuery('#analyticsInfo').show();
    });
  });
});
