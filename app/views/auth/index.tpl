<header>
  <h2>Authentication status</h2>
</header>
{if $status.ok}
  <p>You have authenticated Glitch Autosell.</p>
{else}
  <p>Glitch Autosell does not seem to be authenticated. Click {$view->element('auth_link')} to do that now.</p>
{/if}