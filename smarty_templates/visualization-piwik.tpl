{include file="component-view.tpl" label="Ferramenta utilizada" name="analyticsTool"
  value="{$analyticsType}"}

{include file="component-view.tpl" label="Token de acesso" name="analyticsToken"
  value="{$analyticsToken}"}

{include file="component-view.tpl" label="Identificador do site" name="analyticsSiteId"
  value="{$analyticsSiteId}"}

{foreach from=$analyticsMethods key=index item=value}
  {include file="component-view.tpl" label="Métrica {$index+1}" name="analyticsMetric{$index+1}"
  value="{$analyticsMethods[$index]} (peso: {$analyticsWeights[$index]})"}
{/foreach}
