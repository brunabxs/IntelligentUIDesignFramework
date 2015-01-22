{include file="component-input.tpl" label="Token de acesso" name="analyticsToken"
  type="text" required="true"}

{include file="component-input.tpl" label="Identificador do site" name="analyticsSiteId"
  type="number" required="true"}

<h4>Métricas utilizadas para avaliação</h4>
<table>
  <tr>
    <td></td>
    <td>Peso</td>
    <td>Nome</td>
    <td>Parâmetros extras</td>
  </tr>
{for $index=1 to 3}
  <tr>
    <td>{$index}.</td>
    <td><input id="txt_metricsWeight{$index}" name="txt_metricsWeight{$index}"
          type="number" title="" {if $index == 1}required="true"{/if} /></td>
    <td><input id="txt_metricsName{$index}" name="txt_metricsName{$index}"
          type="text" title="" {if $index == 1}required="true"{/if} /></td>
    <td><input id="txt_metricsExtra{$index}" name="txt_metricsExtra{$index}"
          type="text" title="" /></td>
  </tr>
{/for}
</table>
<input id="txt_metrics_json" name="txt_metrics_json" type="hidden" />
