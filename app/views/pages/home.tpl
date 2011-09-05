<header>
  <h2>Welcome</h2>

  <p>Tired of auctioning off the same <a href="http://www.glitch-strategy.com/wiki/Chunk_of_Metal_Rock">50 Chunks of
    Metal Rock</a> over and over again? I was and that's why I created this
    application. In a nutshell, it allows you to create auction templates, that will auction off any given item of a
    predefined quantitiy at a predefined price for you.</p>
</header>
{if $session->read('Glitch.player.avatar_url')}
  <h3>Hello {$session->read('Glitch.player.player_name')}</h3>
  <p>Please head straight to <a href="{$html->url('/rules')}">your rules</a>.</p>
{else}
  <h3>Authenticate</h3>
  <p>Please click {$view->element('auth_link')} to authorize <strong>Glitch Autosell</strong> to:</p>
  <ul>
    <li>Read your inventory</li>
    <li>Post auctions</li>
  </ul>
{/if}