<header>
  <h2>1. Select a type of item</h2>
</header>
<p>Please select an (auctionable) item from your inventory. In the next step, you will set price and quantity.</p>
{*debug($inventory)*}
{$view->element('inventory', ['inventory' => $inventory])}
