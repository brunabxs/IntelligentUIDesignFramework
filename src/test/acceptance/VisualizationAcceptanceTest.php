<?php
class VisualizationAcceptanceTest extends MySelenium_TestCase
{
  public function testVisualization_piwikAsAnalyticsToolWithOneMetric()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Piwik');
    $this->text(WebDriverBy::id('txt_analyticsToken'), '123token');
    $this->text(WebDriverBy::id('txt_analyticsSiteId'), '1');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method (peso: 1)');
  }

  public function testVisualization_piwikAsAnalyticsToolWithTwoMetrics()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Piwik');
    $this->text(WebDriverBy::id('txt_analyticsToken'), '123token');
    $this->text(WebDriverBy::id('txt_analyticsSiteId'), '1');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method1 (peso: 1)');
    $this->text(WebDriverBy::id('txt_analyticsMetric2'), 'method2 (peso: 2)');
  }

  public function testVisualization_googleOldAsAnalyticsToolWithNoFilter()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Google Analytics (ga.js)');
    $this->text(WebDriverBy::id('txt_analyticsId'), 'ga:123token');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method1 (peso: 1)');
  }

  public function testVisualization_googleOldAsAnalyticsToolWithFilter()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Google Analytics (ga.js)');
    $this->text(WebDriverBy::id('txt_analyticsId'), 'ga:123token');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method1 (peso: 1)');
    $this->text(WebDriverBy::id('txt_analyticsMetric2'), 'method2 (peso: 2)');
    $this->text(WebDriverBy::id('txt_analyticsFilter'), 'filter');
  }

  public function testVisualization_googleAsAnalyticsToolWithNoFilter()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Google Analytics (analytics.js)');
    $this->text(WebDriverBy::id('txt_analyticsId'), 'ga:123token');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method1 (peso: 1)');
  }

  public function testVisualization_googleAsAnalyticsToolWithFilter()
  {
    // Arrange
    $this->login('user1', '123456');

    // Act

    // Assert
    $this->text(WebDriverBy::id('txt_analyticsTool'), 'Google Analytics (analytics.js)');
    $this->text(WebDriverBy::id('txt_analyticsId'), 'ga:123token');
    $this->text(WebDriverBy::id('txt_analyticsMetric1'), 'method1 (peso: 1)');
    $this->text(WebDriverBy::id('txt_analyticsMetric2'), 'method2 (peso: 2)');
    $this->text(WebDriverBy::id('txt_analyticsFilter'), 'filter');
  }

  private function login($user, $password)
  {
    $this->access();
    $this->write(WebDriverBy::id('txt_user'), $user);
    $this->write(WebDriverBy::id('txt_password'), $password);

    $this->click(WebDriverBy::id('btn_login'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));
  }
}
?>
