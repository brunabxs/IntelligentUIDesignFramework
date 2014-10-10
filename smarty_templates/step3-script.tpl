<form name="form_createScript" method="post" action="{$Controller}" class="appContentData">
  <label>1. Copie e cole no cabeçalho das páginas de sua aplicação</label>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"&gt;&lt;/script&gt;</span><span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript" src="http://localhost/load-ga.php?code={$code}}"&gt;&lt;/script&gt;</span>  &lt;/head&gt;
  &lt;body&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
  </pre>

  <label>2. Adicione a chamada ao plugin abaixo</label>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
    ...
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript"&gt;jQuery(document).ready(function(){ jQuery(this).executeGA(); });&lt;/script&gt;</span>  &lt;/head&gt;
  &lt;body&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
  </pre>

  <label>3. Não esqueça dos estilos para as classes...</label>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
<span style="font-weight:bold;margin:0;display:block;">    &lt;link ... /&gt;</span>    ...
  &lt;/head&gt;
  &lt;body&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
  </pre>

  <label>4. ... e nem das métricas que você deseja coletar com a ferramenta de Web Analytics</label>

  <input id="txt_script" name="txt_script" type="hidden" value="true" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Done!" class="appContentButton" />
</form>
