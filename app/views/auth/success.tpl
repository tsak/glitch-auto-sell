{if $returning_player}
  <header>
    <h2>Welcome back {$player.player_name}</h2>
  </header>
  <p>Before you go on and see how <a href="{$html->url('/rules')}">your rules</a> are doing, please take a moment and join the
    <a href="http://www.glitch.com/groups/RNVN2BUHK4D2995/">Glitch Autosell group</a>. It's a great place to
    learn about updates to Glitch Autosell as well as to get help and suggest features.</p>
{else}
  <header>
    <h2>Hi {$player.player_name}</h2>
  </header>
  <p>Thanks for authenticating. You can now define <a href="{$html->url('/rules/create')}">your first</a> rule and start getting rid of those items.</p>
  <p>And why don't you join the
    <a href="http://www.glitch.com/groups/RNVN2BUHK4D2995/">Glitch Autosell group</a>? It's a great place to
    learn about updates to Glitch Autosell as well as to get help and suggest features.</p>
{/if}