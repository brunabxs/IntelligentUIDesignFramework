QUnit.test("__separateElements string contains two elements", function(assert) {
  var string = "h1 : class1, class2;h2:class3 ";

  var expected = ["h1 : class1, class2", "h2:class3"];
  var actual = __separateElements(string);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElements string ends with ';'", function(assert) {
  var string = "h1 : class1;";

  var expected = ["h1 : class1"];
  var actual = __separateElements(string);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElements string does not end with ';'", function(assert) {
  var string = "h1 : class1";

  var expected = ["h1 : class1"];
  var actual = __separateElements(string);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElements string ends with ';   ;'", function(assert) {
  var string = "h1 : class1;   ;";

  var expected = ["h1 : class1"];
  var actual = __separateElements(string);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElements string contains multiple whitespaces", function(assert) {
  var string = "  h1    :     class1,     class2  ";

  var expected = ["h1 : class1, class2"];
  var actual = __separateElements(string);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElementData element contains two classes separated by ','", function(assert) {
  var element = "h1 : class1,class2";

  var expected = ["h1",["class1", "class2"]];
  var actual = __separateElementData(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElementData element contains two classes separated by ',' and whitespaces", function(assert) {
  var element = "h1    :   class1,  class2";

  var expected = ["h1",["class1", "class2"]];
  var actual = __separateElementData(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElementData element contains two classes together", function(assert) {
  var element = "h1    :   class1 class2";

  var expected = ["h1",["class1 class2"]];
  var actual = __separateElementData(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("__separateElementData element contains two ':'", function(assert) {
  var element = "h1    :   class1, class3 h2 : class2";

  var expected = 'Missing ;';
  try {
    __separateElementData(element);
  }
  catch (actual) {
    assert.equal(actual, expected, actual + ' must be equals to ' + expected);
  }
});

QUnit.test("__separateElementData element does not contain ':'", function(assert) {
  var element = "h1   class1, class3";

  var expected = 'Missing :';
  try {
    __separateElementData(element);
  }
  catch (actual) {
    assert.equal(actual, expected, actual + ' must be equals to ' + expected);
  }
});

QUnit.test("__separateElementData element does not contain an element name", function(assert) {
  var element = "  : class1, class3";

  var expected = 'Missing element in ' + element;
  try {
    __separateElementData(element);
  }
  catch (actual) {
    assert.equal(actual, expected, actual + ' must be equals to ' + expected);
  }
});

QUnit.test("__separateElementData element does not contain classes", function(assert) {
  var element = " h1 : ";

  var expected = 'Missing class(es) in ' + element;
  try {
    __separateElementData(element);
  }
  catch (actual) {
    assert.equal(actual, expected, actual + ' must be equals to ' + expected);
  }
});

QUnit.test("__separateElementData element name contains '#'", function(assert) {
  var element = " #id : class1";

  var expected = ["#id",["class1"]];
  var actual = __separateElementData(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("convertToJSON three different elements", function(assert) {
  var element = "h1 : class1, class2; h2:class3;  #id:class1";

  var expected = {"h1":["class1", "class2"], "h2":["class3"], "#id":["class1"]};
  var actual = convertToJSON(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("convertToJSON two elements with same name", function(assert) {
  var element = "h1 : class1, class2; h1:class3;  h2:class1";

  var expected = {"h1":["class1", "class2", "class3"], "h2":["class1"]};
  var actual = convertToJSON(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("convertToJSON element with same class", function(assert) {
  var element = "h1 : class1, class1; h2:class1";

  var expected = {"h1":["class1"], "h2":["class1"]};
  var actual = convertToJSON(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});

QUnit.test("convertToJSON two elements with same name and class", function(assert) {
  var element = "h1 : class1, class2; h1:class1;  h2:class1";

  var expected = {"h1":["class1", "class2"], "h2":["class1"]};
  var actual = convertToJSON(element);

  assert.deepEqual(actual, expected, actual + ' must be equals to ' + expected);
});
