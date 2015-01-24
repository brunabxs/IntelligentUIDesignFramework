{include file="component-input.tpl" label="ID do profile do Google Analytics" name="analyticsId"
  type="text" required="true" placeholder="exemplo: ga:12345" pattern="ga:[0-9]+"}

<h4>Métricas utilizadas para avaliação</h4>
<table>
  <tr>
    <td></td>
    <td>Peso</td>
    <td>Nome</td>
  </tr>
{for $index=1 to 3}
  <tr>
    <td>{$index}.</td>
    <td><input id="txt_metricsWeight{$index}" name="txt_metricsWeight{$index}"
          type="number" title="" {if $index == 1}required="true"{/if} pattern="ga:[a-zA-Z0-9]+" /></td>
    <td><input id="txt_metricsName{$index}" name="txt_metricsName{$index}"
          type="text" title="" {if $index == 1}required="true"{/if} pattern="ga:[a-zA-Z0-9]+" /></td>
  </tr>
{/for}
</table>

{include file="component-input.tpl" label="Filtro" name="analyticsFilter"
  type="text"}

<input id="txt_metrics_json" name="txt_metrics_json" type="hidden" />
