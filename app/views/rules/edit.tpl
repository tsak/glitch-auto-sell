<header>
  <h2>Editing &quot;{$view->data.Rule.title|escape}&quot;</h2>
  <p><a href="{$html->url(['action' => 'index'])}" class="action return">Return to overview</a></p>
</header>
{$view->element('item_summary', ['glitch_item' => $view->data.Rule])}
{$form->create('Rule', ['url' => ['action' => 'edit', $view->data.Rule.id]])}
{$form->input('title')}
{$form->input('quantity', ['class' => 'small'])}
{$form->input('price', ['class' => 'small'])}
<p>
  Price per {$view->data.Rule.name_single}:<br /><span id="price-per-item">0</span>&#8353;
</p>
<p>
  <strong>Commission:</strong> <span id="commission">0</span>&#8353; <span class="pale">(8% of final selling price)</span>
  &mdash;
  <strong>Listing fee:</strong> <span id="listing-fee">3</span>&#8353; <span class="pale">(1.5%, min. 3&#8353;)</span>
</p>
<div class="input button">
  <button type="submit">Save changes</button>
</div>
{$form->end()}