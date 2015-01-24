<div class="appContentData">
  <div class="appContentGroup">
    <div>
      <h3>Web Analytics</h3>
      {include file="{$analyticsTpl}"}
    </div>

    <div>
      <h3>Configurações da aplicação</h3>
      {include file="component-view.tpl" label="Número de versões (valor par)" name="generationSize"
        value="{$populationSize}"}

      {include file="component-view.tpl" label="Tempo de duração da geração (em minutos)" name="generationTime"
        value="30"}

      {include file="component-view.tpl" label="Número máximo de gerações" name="generationLimit"
        value="∞"}

      {include file="component-view.tpl" label="Elementos e classes (JSON)" name="generationProperties"
        value="{$properties}" prettify="true"}
    </div>
  </div>

  <h3>Melhores indivíduos por experimento</h3>
  {foreach from=$bestIndividualsPerGeneration|@array_reverse key=generation item=individual}
    {if isset($individual)}
      {include file="component-view.tpl" label="Melhor solução experimento {$generation+1}" name="bestSolution{$generation}"
        value="{$individual}" prettify="true"}
    {else}
      {include file="component-view.tpl" label="Melhor solução experimento {$generation+1}" name="bestSolution{$generation}NotFound"
        value="Ainda não foi encontrada" prettify="true"}
    {/if}
  {/foreach}
</div>
