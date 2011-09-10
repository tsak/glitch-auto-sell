<ul class="{$class|default:'inventory'} clearfix">
{foreach $inventory.contents as $slot_id => $slot}
  {if isset($slot.contents)}
    <li class="bag clearfix">
      <strong class="icon"><img src="{$slot.item_def.iconic_url}" title="{$slot.label|escape}" /></strong>
      {$view->element('inventory', ['inventory' => $slot, 'class' => 'bag'])}
    </li>
  {else}
    {if $slot}
      <li>
        {* TODO: Find out if some items can not be auctioned and fill regex accordingly *}
        {if !$slot.item_def.base_cost}
          <a class="no-auction"><img src="{$slot.item_def.iconic_url}" title="{$slot.label|escape} (can not be auctioned)" /><span>{$slot.count}</span></a>
        {else}
          <a href="{$html->url("/rules/add/`$slot.tsid`")}"><img src="{$slot.item_def.iconic_url}" title="{$slot.label|escape}" /><span>{$slot.count}</span></a>
        {/if}
      </li>
    {/if}
  {/if}
{/foreach}
</ul>
