<div class="appContentDataItem {(isset($required) == true) ? 'required' : ''}{(isset($class) == true) ? $class : ''}">
  <label
    for="txt_{$name}"
    class="{(isset($required) == true) ? 'required' : ''}">
    {$label}
  </label>

  {if isset($prettify)}
<pre>
{$value}
</pre>
  {else}
    <span id="txt_{$name}">{(isset($value) == true) ? $value : '-'}</span>
  {/if}

</div>
