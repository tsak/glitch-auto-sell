<header>
  <h2>Auctions</h2>
</header>
{*debug($rule)*}
<ol id="rules">
{$current_time_stamp = $smarty.now|date_format:'U'}
{foreach $rule.Auction as $auction}
  {$parts = split('-',$auction.ts_auction_id)}
  {$player_ts_id = $parts.0}
  {$auction_id = sprintf('%x', $parts.1)}
  <li {if $current_time_stamp > $auction.endtime|date_format:'U'} class="pale"{/if}>
    {$auction.created|date_format:'M j, g.ia'} &mdash;
    {$auction.title}
    <a href="http://beta.glitch.com/auctions/{$player_ts_id}/{$auction_id}/">View</a>
    <a href="http://beta.glitch.com/auctions/{$player_ts_id}/{$auction_id}/cancel/">Cancel</a>
  </li>
{/foreach}
</ol>