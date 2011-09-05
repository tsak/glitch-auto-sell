<header>
  <h2>Edit a rule</h2>
</header>

{$form->create('Rule', ['url' => ['action' => 'edit', $view->data.Rule.id]])}
{$form->input('title')}
{$form->input('quantity')}
{$form->input('price')}

<p>
  <strong>Commission:</strong> <span id="commission">0</span>&#8353; <span class="pale">(8% of final selling price)</span>
  &mdash;
  <strong>Listing fee:</strong> <span id="listing-fee">3</span>&#8353; <span class="pale">(1.5%, min. 3&#8353;)</span>
</p>
<div class="input button">
  <button type="submit">Save changes</button>
</div>
{$form->end()}