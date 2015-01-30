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

  jQuery('form#form_analyticsConfiguration').submit(function(event) {
    var form = jQuery(this);
    var source = jQuery(document.activeElement);
    if (source) {
      source = source.attr('id');
    }

    if (source === 'btn_validate') {
      form.find('#txt_validate').val('true');
      jQuery.post('index.php', form.serialize(), function(data) {
        data = JSON.parse(data.trim());
        if (data.type === 'success') {
          jQuery('#msg_validate').addClass('success').text('Dados válidos');
          allowSubmit();
        }
        else if (data.type === 'error') {
          jQuery('#msg_validate').removeClass('success').text(data.message);
          allowNoAction();
        }
      });
    }
    else if (source === 'btn_submit') {
      form.find('#txt_validate').val('false');
      jQuery.post('index.php', form.serialize(), function(data) {
        location.reload();
      });
    }

    return false;
  });

  jQuery('form#form_analyticsConfiguration #btn_validate').hide();
  jQuery('form#form_analyticsConfiguration #btn_submit').hide();
  jQuery('form#form_analyticsConfiguration #msg_validate').hide();
});
