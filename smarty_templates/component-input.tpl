<div class="appContentDataItem {(isset($required) == true) ? 'required' : ''}{(isset($class) == true) ? $class : ''}">
  <label
    for="txt_{$name}"
    class="{(isset($required) == true) ? 'required' : ''}">
    {$label}
  </label>

  {if $type == 'text' || $type == 'password' || $type == 'number'}
    <input
      id="txt_{$name}"
      name="txt_{$name}"
      type="{(isset($type) == true) ? $type : 'text'}"
      title=""
      {if isset($pattern)}
        pattern="{$pattern}"
      {/if}
      {(isset($required) == true) ? 'required' : ''}
      {(isset($focus) == true) ? 'autofocus' : ''}
    />
  {/if}

  {if $type == 'select'}
    <select
      id="txt_{$name}"
      name="txt_{$name}"
      title=""
      {(isset($required) == true) ? 'required' : ''}
      {(isset($focus) == true) ? 'autofocus' : ''}>
      {html_options values=$values output=$labels }
    </select>
  {/if}

  {if $type == 'textarea'}
    <textarea
      id="txt_{$name}"
      name="txt_{$name}"
      title=""
      {(isset($required) == true) ? 'required' : ''}
      {(isset($focus) == true) ? 'autofocus' : ''}>
    </textarea>
  {/if}

  {if isset($message)}
    <span id="msg_txt_{$name}" class="appContentMessage">{$message}</span>
  {/if}

</div>
