<header>
  <h2>Your auction rules</h2>
  {if $stats.total_auction_count}<p>Your rules have spawned <strong>{number_format($stats.total_auction_count)}</strong> auctions so far.</p>{/if}
</header>
{if $rules}
  <p><a href="{$html->url(['action' => 'create'])}" class="action add">Create a new rule</a></p>
  <table>
    <thead>
    <tr>
      <th>Title</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Auctions</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {foreach $rules as $rule}
    <tr{if !$rule.Rule.is_active} class="inactive"{/if}>
      <td><a href="{$html->url(['action' => 'edit', $rule.Rule.id])}" title="Edit">{$rule.Rule.title|escape}</a></td>
      <td class="number">{$rule.Rule.quantity}</td>
      <td class="price">{$rule.Rule.price}&#8353;</td>
      <td class="number">{$rule.Rule.auction_count|default:'-'}</td>
      <td class="actions clearfix">
        <a href="{$html->url(['action' => 'edit', $rule.Rule.id])}" class="edit" title="Edit">Edit</a>
        {if !$rule.Rule.is_active}
        <a href="{$html->url(['action' => 'activate', $rule.Rule.id, 1])}" class="activate" title="Activate">Activate</a>
        {else}
        <a href="{$html->url(['action' => 'activate', $rule.Rule.id, 0])}" class="deactivate" title="Deactivate">Deactivate</a>
        {/if}
        {if $rule.Rule.auction_count}
          <a href="{$html->url(['action' => 'auctions', $rule.Rule.id])}" class="auctions" title="Auctions">Auctions</a>
        {/if}
        <a href="{$html->url(['action' => 'delete', $rule.Rule.id])}" class="delete" title="Delete">Delete</a>
      </td>
    </tr>
    {/foreach}
    </tbody>
  </table>
{else}
  <p><a href="{$html->url(['action' => 'create'])}" class="action add">Create your first rule</a></p>
{/if}
