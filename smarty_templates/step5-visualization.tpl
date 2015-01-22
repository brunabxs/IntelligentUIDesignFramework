<div class="appContentData">
  <h3>Web Analytics</h3>
  {include file="{$analyticsTpl}"}

  <h3>Configurações da aplicação</h3>
  {include file="component-view.tpl" label="Número de versões (valor par)" name="generationSize"
    value="{$populationSize}"}

  {include file="component-view.tpl" label="Tempo de duração da geração (em minutos)" name="generationTime"
    vaue="1"}

  {include file="component-view.tpl" label="Número máximo de gerações" name="generationLimit"
    value="∞"}

  {include file="component-view.tpl" label="Elementos e classes (JSON)" name="generationProperties"
    value="{$properties}"}
</div>
