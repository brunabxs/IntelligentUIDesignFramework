{include file="component-input.tpl" label="ID do profile do Google Analytics" name="analyticsId"
  type="text" required="true" placeholder="ex.: ga:12345" pattern="ga:[0-9]+"}

<div class="appContentDataItemGroup">
  {include file="component-input.tpl" label="Métrica 1" name="metricsName1"
    type="text" required="true" placeholder="ex.: ga:sessions" pattern="ga:[a-zA-Z0-9]+"}

  {include file="component-input.tpl" label="Peso para métrica 1" name="metricsWeight1"
    type="number" required="true"}
</div>

{for $index=2 to 3}
  <div class="appContentDataItemGroup">
    {include file="component-input.tpl" label="Métrica {$index}" name="metricsName{$index}"
      type="text" placeholder="ex.: ga:sessions" pattern="ga:[a-zA-Z0-9]+"}

    {include file="component-input.tpl" label="Peso para métrica {$index}" name="metricsWeight{$index}"
      type="number"}
  </div>
{/for}

{include file="component-input.tpl" label="Filtro" name="analyticsFilter"
  type="text" placeholder="ex.: ga:county==Brazil"}

<input id="txt_metrics_json" name="txt_metrics_json" type="hidden" />
