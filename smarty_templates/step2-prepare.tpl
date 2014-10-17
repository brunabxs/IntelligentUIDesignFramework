<form name="form_generalInformation" method="post" action="{$Controller}" class="appContentData" onsubmit="return validate();">
  <label>Ferramenta de Web Analytics utilizada</label>
  <span id="txt_analyticsTool">Piwik</span>

  <label for="txt_token" class="required">Token de acesso da Piwik</label>
  <input id="txt_token" name="txt_token" type="text" title="" required autofocus />

  <label for="txt_versions" class="required">Número de versões (apenas pares)</label>
  <input id="txt_versions" name="txt_versions" type="text" pattern="[0-9]*[2468]" title="" required />

  <label>Número máximo de experimentos</label>
  <span id="txt_exp">-</span>

  <label>Tempo máximo de execução de um experimento (dias)</label>
  <span id="txt_time">-</span>

  <label for="txt_prop" class="required">Elementos e classes no formato JSON</label>
  <textarea id="txt_prop" name="txt_prop" title="" required></textarea>
  <input id="txt_prop_json" name="txt_prop_json" type="hidden" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Send" class="appContentButton" />
</form>
