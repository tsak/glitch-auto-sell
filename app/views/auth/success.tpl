{if $returning_player}
  <header>
    <h2>Welcome back {$player.player_name}</h2>
  </header>
  <p>Please go on and see how <a href="{$html->url('/rules')}">your rules</a> are doing.</p>
{else}
  <header>
    <h2>Hi {$player.player_name}</h2>
  </header>
  <p>Thanks for authenticating. You can now define <a href="{$html->url('/rules/create')}">your first</a> rule and start getting rid of those items.</p>
{/if}