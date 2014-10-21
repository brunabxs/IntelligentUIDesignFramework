<form id="form_clientConfiguration" name="form_clientConfiguration" method="post" action="index.php" class="appContentData">
  <h4>1. Adicione a biblioteca JQuery ao seu projeto e também a chamada à nossa aplicação.</h4>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"&gt;&lt;/script&gt;</span><span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript" src="http://localhost/load-ga.php?code={$code}"&gt;&lt;/script&gt;</span>  &lt;/head&gt;
  &lt;body&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
  </pre>

  <h4>2. Adicione a chamada ao plugin para que os elementos da página possam receber as suas respectivas classes.
  A chamada deve ser feita após o DOM ser carregado.</h4>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
    ...
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript"&gt;
      jQuery(document).ready(function(){
        jQuery(this).executeGA();
      });
    &lt;/script&gt;</span>  &lt;/head&gt;
  &lt;body&gt;
    ...
  &lt;/body&gt;
&lt;/html&gt;
  </pre>

  <h4>3. Não esqueça também de adicionar às páginas os estilos para as classes...</h4>
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

  <h4>4. ... e nem de capturar com a ferramenta de Web Analytics as métricas que serão utilizadas para avaliação dos experimentos!</h4>

  <input id="txt_ready" name="txt_ready" type="hidden" value="true" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Pronto!" class="appContentButton" />
</form>
