<form id="form_analyticsConfiguration" name="form_analyticsConfiguration" method="post" action="index.php" class="appContentDataGroup" onsubmit="join();">

  {include file="component-input.tpl" label="Ferramenta utilizada" name="analyticsTool"
    type="select" required="true" focus="true" values=['', 'piwik', 'google-old', 'google'] labels=['-- Selecione --', 'Piwik', 'Google Analytics (ga.js)', 'Google Analytics (analytics.js)']}

  <div id="analyticsInfo"></div>
  <div id="analyticsWait" style="display: none;">Aguarde...</div>

  <input id="txt_validate" name="txt_validate" type="hidden" value="true" />
  <input id="btn_validate" name="btn_validate" type="submit" value="Validar" class="appContentButton" />
  <span id="msg_validate" class="appContentMessage"></span>
  <input id="btn_submit" name="btn_submit" type="submit" value="Enviar" class="appContentButton" />
</form>
