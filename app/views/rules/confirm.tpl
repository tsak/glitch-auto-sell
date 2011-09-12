<header class="no-shadow">
  <h2>3. Confirm and activate</h2>
  <p><a href="{$html->url(['action' => 'edit', $rule.Rule.id])}" class="action return">Edit the rule</a></p>
</header>
<p>Almost done. Please review your auction rule below.</p>
<p>
  <strong>{$rule.Rule.title|escape}:</strong><br/>
  You've chosen to create a new auction of <strong>{$rule.Rule.quantity}</strong> <a
  href="http://www.glitch-strategy.com/w/index.php?title=Special%3ASearch&search={$rule.Rule.name_single|escape:'url'}">{$rule.Rule.name_plural}</a>
  for <strong>{$rule.Rule.price}</strong>&#8353;
  whenever this type of item with at least the selected quantity becomes available in your inventory.<br />
  {$listing_fee = $rule.Rule.price*0.015}
  <span class="pale">Please note that this will deduct a listing fee of <strong>{if $listing_fee < 3}3{else}{round($listing_fee)}{/if}</strong>&#8353; whenever an auction is created.</span>
</p>
<form method="get" action="{$html->url(['action' => 'activate', $rule.Rule.id])}">
  <button type="submit">Yes, that's exactly what I want!</button>
  <a href="{$html->url(['action' => 'delete', $rule.Rule.id])}">Nooooooooooooooo!</a>
</form>