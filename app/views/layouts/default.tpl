<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <base href="{$html->url('/', true)}" />
	<title>Glitch Autosell | {$title_for_layout}</title>
	<meta name="description" content="A tool to create Glitch auctions automatically, based on user definable criteria.">
	<meta name="author" content="tsak">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	{*
	<link rel="stylesheet" href="css/style.css">
	*}
  {$html->css('style')}

	<script src="js/modernizr-2.0.min.js"></script>
	<script src="js/respond.min.js"></script>
</head>
<body>
	<div id="header-container">
		<header class="wrapper">
			<h1 id="title"><a href="{$html->url('/')}">Glitch Autosell</a><sup>alpha</sup></h1>
			<nav>
				<ul>
          {if $session->read('Glitch.player.avatar_url')}<li><a href="{$html->url('/rules')}">Your rules</a></li>{/if}
          <li><a href="{$html->url('/pages/faq')}">FAQ</a></li>
					<li><a href="{$html->url('/pages/about')}">About</a></li>
            <li><a href="{$html->url('/pages/contact')}">Contact</a></li>
            <li><a href="{$html->url('/pages/credits')}">Credits</a></li>
				</ul>
			</nav>
		</header>
	</div>
	<div id="main" class="wrapper">
    <article>
      <aside>
        {if $session->read('Glitch.player.avatar_url')}
          <p><a href="{$html->url(['action' => 'create'])}" class="action add">Create a new rule</a></p>
          <img src="{$session->read('Glitch.player.avatar_url')}" />
        {else}
          Before you can use this application, you have to authenticate in order to allow it to create auctions for you. Please click {$view->element('auth_link')} to start authenticating.
        {/if}
      </aside>
      {$content_for_layout}
    </article>
	</div>
	<div id="footer-container">
		<footer class="wrapper">
      <ul class="clearfix">
        <li><a href="http://glitch.com/">Glitch</a></li>
        <li><a href="http://tinyspeck.com/">Tiny Speck</a></li>
        <li><a href="https://github.com/tsak/glitch-auto-sell">Glitch Autosell on Github</a></li>
        <li><a href="http://www.glitch-strategy.com/wiki/Glitch_Wiki">Glitch Wiki</a></li>
        {if Configure::read('debug') == 2}<li><a href="#" onclick="$('#sqldump').toggle(); return false;">Show SQL dump</a></li>{/if}
      </ul>
      <p>&#8353;{$smarty.now|date_format:'Y'} - not affilliated with Tiny Speck</p>
      {if Configure::read('debug') == 2}<div id="sqldump" style="display: none;">{$view->element('sqldump')}</div>{/if}
		</footer>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.6.2.min.js"><\/script>')</script>

{*
<script src="js/script.js"></script>
*}

{$javascript->link('script')}

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