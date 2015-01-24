{include file="component-input.tpl" label="Token de acesso" name="analyticsToken"
  type="text" required="true" placeholder="ex.: anonymous"}

{include file="component-input.tpl" label="Identificador do site" name="analyticsSiteId"
  type="number" required="true"}

<div class="appContentDataItemGroup">
  {include file="component-input.tpl" label="Métrica 1" name="txt_metricsName1"
    type="text" required="true" placeholder="ex.: VisitsSummary.getVisits" pattern="ga:[a-zA-Z0-9]+"}

  {include file="component-input.tpl" label="Peso para métrica 1" name="txt_metricsWeight1"
    type="number" required="true"}
</div>

{for $index=2 to 3}
  <div class="appContentDataItemGroup">
    {include file="component-input.tpl" label="Métrica {$index}" name="txt_metricsName{$index}"
      type="text" placeholder="ex.: VisitsSummary.getVisits" pattern="ga:[a-zA-Z0-9]+"}

    {include file="component-input.tpl" label="Peso para métrica {$index}" name="txt_metricsWeight{$index}"
      type="number"}
  </div>
{/for}
<input id="txt_metrics_json" name="txt_metrics_json" type="hidden" />
