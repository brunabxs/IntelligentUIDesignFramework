<form name="form_createScript" method="post" action="{$Controller}" class="appContentData">
  <label>1. Copie e cole no cabeçalho das páginas de sua aplicação</label>
  <pre>{$Content1}</pre>

  <label>2. Adicione a chamada ao plugin abaixo</label>
  <pre>{$Content2}</pre>

  <label>3. Não esqueça dos estilos para as classes...</label>
  <pre>{$Content3}</pre>

  <label>4. ... e nem das métricas que você deseja coletar com a ferramenta de Web Analytics</label>

  <input id="txt_script" name="txt_script" type="hidden" value="true" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Done!" class="appContentButton" />
</form>
