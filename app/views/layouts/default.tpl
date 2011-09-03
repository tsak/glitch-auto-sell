<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <base href="{$html->url('/', true)}" />
	<title>Glitch Autosell</title>
	<meta name="description" content="A tool to create Glitch auctions automatically, based on user definable criteria.">
	<meta name="author" content="tsak">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="css/style.css">

	<script src="js/libs/modernizr-2.0.min.js"></script>
	<script src="js/libs/respond.min.js"></script>
</head>
<body>
	<div id="header-container">
		<header class="wrapper">
			<h1 id="title"><a href="{$html->url('/')}">Glitch Autosell</a><sup>beta</sup></h1>
			<nav>
				<ul>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Help</a></li>
				</ul>
			</nav>
		</header>
	</div>
	<div id="main" class="wrapper">
    <article>
      <aside>
        {if $session->read('Glitch.player.avatar_url')}
          <img src="{$session->read('Glitch.player.avatar_url')}" />
        {else}
          Before you can use this application, you have to authenticate in order to allow it to create auctions for you. Please click <a href="http://api.glitch.com/oauth2/authorize?response_type=code&amp;client_id={Configure::read('Glitch.api.key')}&amp;redirect_uri={$html->url('/auth/response', true)|escape}&amp;scope=write&amp;state=test">here</a> to start authenticating.
        {/if}
      </aside>
      {$content_for_layout}
    </article>
	</div>
	<div id="footer-container">
		<footer class="wrapper">
			<h3>&#8353;{$smarty.now|date_format:'Y'}</h3>
		</footer>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

<script src="js/script.js"></script>
{*<script>*}
{*	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID*}
{*	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;*}
{*	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';*}
{*	s.parentNode.insertBefore(g,s)}(document,'script'));*}
{*</script>*}

<!--[if lt IE 7 ]>{literal}
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
{/literal}<![endif]-->

</body>
</html>