<form id="form_clientConfiguration" name="form_clientConfiguration" method="post" action="index.php" class="appContentData">
  <h4>1. Adicione a biblioteca JQuery ao seu projeto e também a chamada à nossa aplicação.</h4>
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript"
       src="{$jquery}"&gt;&lt;/script&gt;</span><span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript"
       src="{$app}"&gt;&lt;/script&gt;</span>  &lt;/head&gt;
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
  <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
    ...
  &lt;/head&gt;
  &lt;body&gt;
    ...
<span style="font-weight:bold;margin:0;display:block;">    &lt;script type="text/javascript"&gt;
      jQuery(document).ready(function(){
        jQuery('a').click(function() {
          // track some event
        });
      });
    &lt;/script&gt;</span>  &lt;/body&gt;
&lt;/html&gt;
  </pre>  

  <h4>5. Se você está utilizando a versão mais nova do Google Analytics (analytics.js) ...</h4>
  <p>Cadastre o usuário "{$user}" com permissão de "Ler e analisar" no seu Google Analytics. <a href="https://support.google.com/analytics/answer/1009702?hl=pt-BR" target="_blank">Veja como fazer clicando aqui.</a>.</p>
  <p>Cadastre a dimensão personalizada 1 no seu Google Analytics. <a href="https://support.google.com/analytics/answer/2709829?hl=pt-BR" target="_blank">Veja como fazer clicando aqui.</a>.</p>

  <h4>6. ... mas se você está utilizando a versão mais antiga do Google Analytics (ga.js)</h4>
  <p>Cadastre o usuário "{$user}" com permissão de "Ler e analisar" no seu Google Analytics. <a href="https://support.google.com/analytics/answer/1009702?hl=pt-BR" target="_blank">Veja como fazer clicando aqui.</a>.</p>

  <input id="txt_ready" name="txt_ready" type="hidden" value="true" />

  <input id="btn_submit" name="btn_submit" type="submit" value="Pronto!" class="appContentButton" />
</form>
