<form id="form_access" name="form_access" method="post" action="index.php" class="appContentDataGroup">

  {include file="component-input.tpl" label="Usuário" name="user"
    type="text" required="true" focus="true"
    message=((isset($message_user)) ? $message_user : null)}

  {include file="component-input.tpl" label="Senha" name="password"
    type="password" required="true" focus="true"
    message=((isset($message_password)) ? $message_password : null)}

  <input id="hidden_type" name="hidden_type" type="hidden" value="" />
  <input id="btn_login" name="btn_login" type="submit" value="Entrar" class="appContentButton" onclick="jQuery('#hidden_type').val('login');" />
  <input id="btn_signin" name="btn_signin" type="submit" value="Criar" class="appContentButton" onclick="jQuery('#hidden_type').val('signin');" />
</form>
