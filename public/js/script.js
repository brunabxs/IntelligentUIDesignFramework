jQuery(document).ready(function() {
  jQuery('form#form_analyticsConfiguration #txt_analyticsTool').change(function() {
    jQuery('#btn_validate').hide();
    jQuery('#btn_submit').hide();
    jQuery('#msg_validate').hide();
    jQuery('#analyticsInfo').hide();
    jQuery('#analyticsWait').show();

    jQuery.post('index.php', {analyticsType:jQuery(this).val()}, function(data) {
      jQuery('#analyticsInfo').html(data.trim());
      jQuery('#analyticsWait').hide();
      jQuery('#analyticsInfo').show();
      jQuery('#btn_validate').show();

      loadAnalyticsConfigurationContent();
    });
  });

  jQuery('form#form_analyticsConfiguration #btn_validate').hide();
  jQuery('form#form_analyticsConfiguration #btn_submit').hide();
  jQuery('form#form_analyticsConfiguration #msg_validate').hide();
});
