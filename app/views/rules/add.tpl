<header>
  <h2>2. Set price and quantity</h2>
</header>
<p>
  <img src="{$item.item_def.iconic_url}" align="left" style="margin-right: 10px;" />
  You've selected <a href="http://www.glitch-strategy.com/w/index.php?title=Special%3ASearch&search={$item.item_def.name_single|escape:'url'}">{$item.item_def.name_plural|escape}</a>
  <span class="pale">(<a href="{$html->url(['action' => 'create'])}">Select a different item</a>)</span><br />
  Worth about <strong>{$item.item_def.base_cost}</strong>&#8353;, fits <strong>{$item.item_def.max_stack}</strong> in a backpack slot.
</p>
{$form->create('Rule', ['url' => ['action' => 'add', $item.tsid]])}
{$form->input('title', ['label' => 'Title', 'value' => "Autosell `$item.item_def.name_plural`"])}
{$form->input('quantity', ['label' => 'Quantity <span class="pale">(Defaults to max. slot capacity)</span>', 'value' => $item.item_def.max_stack, 'class' => 'small'])}
{$form->input('price', ['label' => 'Price <span class="pale">(Defaults to max. quantity x base price)</span>', 'value' => $item.item_def.base_cost*$item.item_def.max_stack, 'class' => 'small'])}

<p>
  <strong>Commission:</strong> <span id="commission">0</span>&#8353; <span class="pale">(8% of final selling price)</span>
  &mdash;
  <strong>Listing fee:</strong> <span id="listing-fee">3</span>&#8353; <span class="pale">(1.5%, min. 3&#8353;)</span>
</p>
<div class="input button">
  <button type="submit">Create</button> <a href="{$html->url(['action' => 'create'])}">Select a different item</a>
</div>
{$form->end()}
