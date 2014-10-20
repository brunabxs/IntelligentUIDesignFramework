<form id="form_analyticsConfiguration" name="form_analyticsConfiguration" method="post" action="index.php" class="appContentDataGroup">

  {include file="component-input.tpl" label="Ferramenta utilizada" name="analyticsTool"
    type="select" required="true" focus="true" values=['piwik', 'google'] labels=['Piwik', 'Google Analytics']}

  {include file="component-input.tpl" label="Token de acesso" name="analyticsToken"
    type="text" required="true"}

  {include file="component-input.tpl" label="Identificador do site" name="analyticsSiteId"
    type="number" required="true"}

  {include file="component-input.tpl" label="Peso" name="metricsWeight"
    type="number" required="true"}

  {include file="component-input.tpl" label="Name" name="metricsName"
    type="text" required="true"}

  <input id="btn_submit" name="btn_submit" type="submit" value="Enviar" class="appContentButton" />
</form>
