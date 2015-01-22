{include file="component-view.tpl" label="Ferramenta utilizada" name="analyticsTool"
  value="{$analyticsType}"}

{include file="component-view.tpl" label="ID do profile do Google Analytics" name="analyticsId"
  value="{$analyticsId}"}

{foreach from=$analyticsMethods key=index item=value}
  {include file="component-view.tpl" label="Métrica {$index+1}" name="analyticsMetric{$index+1}"
  value="{$analyticsMethods[$index]} (peso: {$analyticsWeights[$index]})"}
{/foreach}

{include file="component-view.tpl" label="Filtro" name="analyticsFilter"
  value="{$analyticsFilter}"}
