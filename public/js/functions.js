Array.prototype.unique = function() {
  var a = this.concat();
  for(var i=0; i<a.length; ++i) {
    for(var j=i+1; j<a.length; ++j) {
      if(a[i] === a[j]) {
        a.splice(j--, 1);
      }
    }
  }
  return a;
};

function __separateElements(jsonString) {
  var parsed = [];

  var elements = jsonString.split(';');
  for (var i = 0; i < elements.length; i++)
  {
    var element = elements[i].trim().replace(/[ ]+/g, ' ');
    if (element === '') continue;
    parsed.push(element);
  }

  return parsed;
}

function __separateElementData(element) {
  var counter = element.match(/:/g);
  if (counter === null) {
    throw 'Missing :';
  }
  else if (counter.length > 1) {
    throw 'Missing ;';
  }

  var elementData = element.split(':');
  var elementName = elementData[0].trim();
  var elementClasses = elementData[1].trim().split(/[ ]*,[ ]*/g);

  if (elementName === '') {
    throw 'Missing element in ' + element;
  }
  else if (elementClasses[0] === '') {
    throw 'Missing class(es) in ' + element;
  }

  return [elementName, elementClasses];
}

function convertToJSON(jsonString) {
  var json = {};
  var elements = __separateElements(jsonString).map(__separateElementData);
  for (var i = 0; i < elements.length; i++) {
    if (json[elements[i][0]] === undefined) {
      json[elements[i][0]] = elements[i][1];
    }
    else {
      json[elements[i][0]] = json[elements[i][0]].concat(elements[i][1]);
    }
    json[elements[i][0]] = json[elements[i][0]].unique();
  }
  return json;
}

function validate() {
  try {
    jQuery('#txt_generationProperties_json').val(JSON.stringify(convertToJSON(jQuery('#txt_generationProperties').val())));
    return true;
  }
  catch (error) {
    jQuery('#appModal p').text(error);
    jQuery('#appModal').dialog({
      title: 'Opsie! Ocorreu algum erro',
      modal: true,
      resizable: false,
      buttons: [{
        text: "OK", click: function() {
          jQuery(this).dialog("close");
        }
      }]
    });
    return false;
  }
}

function join() {
  var metrics = [];

  for (var i = 1; i <= 3; i++) {
    var weight = jQuery('#txt_metricsWeight' + i).val();
    var name = jQuery('#txt_metricsName' + i).val();
    var extra = jQuery('#txt_metricsExtra' + i).val();

    if (name && weight) {
      metrics.push({'method':name, 'weight':weight, 'extraParameters':extra});
    }
  }

  if (jQuery('#txt_analyticsFilter').size() == 1) {
    metrics.push({'method':undefined, 'weight':weight, 'extraParameters':jQuery('#txt_analyticsFilter').val()});
  }

  jQuery('#txt_metrics_json').val(JSON.stringify(metrics));
}
