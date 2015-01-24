<form id="form_analyticsConfiguration" name="form_analyticsConfiguration" method="post" action="index.php" class="appContentDataGroup" onsubmit="join();">

  {include file="component-input.tpl" label="Ferramenta utilizada" name="analyticsTool"
    type="select" required="true" focus="true" values=['', 'piwik', 'google-old', 'google'] labels=['-- Selecione --', 'Piwik', 'Google Analytics (ga.js)', 'Google Analytics (analytics.js)']}

  <div id="analyticsInfo"></div>
  <div id="analyticsWait" style="display: none;">Aguarde...</div>

  <input id="btn_submit" name="btn_submit" type="submit" value="Enviar" class="appContentButton" />
</form>
