<?php
class AnalyticsConfigurationAcceptanceTest extends MySelenium_TestCase
{
  public function testAnalyticsConfiguration_afterComplete_mustGoToClientConfigurationStep()
  {
    // Arrange
    $this->login('user1', '123456');
    $token = 'analyticsToken';
    $siteId = 1;
    $weight = '1';
    $name = 'VisitsSummary.getVisits';

    // Act
    $this->write(WebDriverBy::id('txt_analyticsToken'), $token);
    $this->write(WebDriverBy::id('txt_analyticsSiteId'), $siteId);
    $this->write(WebDriverBy::id('txt_metricsWeight1'), $weight);
    $this->write(WebDriverBy::id('txt_metricsName1'), $name);
    $this->click(WebDriverBy::id('btn_submit'));
    $this->waitPresenceOfElement(WebDriverBy::id('appMenuSelected'));

    // Assert
    $this->assertEquals('Passo 4', $this->text(WebDriverBy::id('appMenuSelected')));
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
