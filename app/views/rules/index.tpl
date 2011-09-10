<header>
  <h2>Your auction rules</h2>
</header>
<ol id="rules">
{foreach $rules as $rule}
  <li{if !$rule.Rule.is_active} class="pale"{/if}>
    <strong>{$rule.Rule.title}</strong> &mdash;
    {$rule.Rule.quantity} for
    {$rule.Rule.price}&#8353;
    <a href="{$html->url(['action' => 'edit', $rule.Rule.id])}">Edit</a>
    {if !$rule.Rule.is_active}
    <a href="{$html->url(['action' => 'activate', $rule.Rule.id, 1])}">Activate</a>
    {else}
    <a href="{$html->url(['action' => 'activate', $rule.Rule.id, 0])}">Deactivate</a>
    {/if}
    {if $rule.Rule.auction_count}
      <a href="{$html->url(['action' => 'auctions', $rule.Rule.id])}">Auctions ({$rule.Rule.auction_count})</a>
    {/if}
    <a href="{$html->url(['action' => 'delete', $rule.Rule.id])}" class="delete">Delete</a>
  </li>
{foreachelse}
  <li>You have no rules defined yet. Click <a href="{$html->url(['action' => 'create'])}">here</a> to create your first one.</li>
{/foreach}
</uL>
