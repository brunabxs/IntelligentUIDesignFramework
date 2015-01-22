<form id="form_serverConfiguration" name="form_serverConfiguration" method="post" action="index.php" class="appContentDataGroup" onsubmit="validate();">

  {include file="component-input.tpl" label="Número de versões (valor par)"
    type="text" name="generationSize"
    pattern="[0-9]*[2468]" required="true" focus="true"}

  {include file="component-view.tpl" label="Tempo de duração da geração (em minutos)" name="generationTime"
    value="30"}

  {include file="component-view.tpl" label="Número máximo de gerações" name="generationLimit"
    value="∞"}

  {include file="component-input.tpl" label="Elementos e classes (JSON)"
    type="textarea" name="generationProperties" required="true"}
  <input id="txt_generationProperties_json" name="txt_generationProperties_json" type="hidden" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Enviar" class="appContentButton" />
</form>
