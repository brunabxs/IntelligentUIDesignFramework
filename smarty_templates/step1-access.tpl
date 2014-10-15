<form id="form_redirect" name="form_redirect" method="post" action="index.php" class="appContentData">
  <label for="txt_user" class="required">Usuário</label>
  <input id="txt_user" name="txt_user" type="text" title="" required autofocus />
  {if isset($message_user)}
    <span id="msg_txt_user" class="appContentMessage">{$message_user}</span>
  {/if}

  <label for="txt_password" class="required">Senha</label>
  <input id="txt_password" name="txt_password" type="password" title="" required />
  {if isset($message_password)}
    <span id="msg_txt_password" class="appContentMessage">{$message_password}</span>
  {/if}

  <input id="hidden_type" name="hidden_type" type="hidden" value="" />
  <input id="btn_login" name="btn_login" type="submit" value="Entrar" class="appContentButton" onclick="jQuery('#hidden_type').val('login');" />
  <input id="btn_signin" name="btn_signin" type="submit" value="Criar" class="appContentButton" onclick="jQuery('#hidden_type').val('signin');" />
</form>
