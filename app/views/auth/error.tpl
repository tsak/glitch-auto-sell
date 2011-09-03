<header>
  <h2>Authentication failed</h2>
</header>
<p>The following error occurred:</p>
{$session->flash()}
<p>You can try authenticating again by clicking <a href="http://api.glitch.com/oauth2/authorize?response_type=code&amp;client_id={Configure::read('Glitch.api.key')}&amp;redirect_uri={$html->url('/auth/response', true)|escape}&amp;scope=write&amp;state=test">here</a>.</p>
