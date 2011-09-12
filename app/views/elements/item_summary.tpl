<p>
  <img src="{$glitch_item.iconic_url}" align="left" style="margin-right: 10px;" />
  This rule is for <a href="http://www.glitch-strategy.com/w/index.php?title=Special%3ASearch&search={$glitch_item.name_single|escape:'url'}">{$glitch_item.name_plural|escape}</a>
  {if $view->action eq 'add'}<span class="pale">(<a href="{$html->url(['action' => 'create'])}">Select a different item</a>)</span>{/if}<br />
  Worth about <strong>{$glitch_item.base_cost}</strong>&#8353;, fits <strong>{$glitch_item.max_stack}</strong> in a backpack slot.
</p>
