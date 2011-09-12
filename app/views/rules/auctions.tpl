<header>
  <h2>Auctions for &quot;{$rule.Rule.title|escape}&quot;</h2>
  <p>
    <a href="{$html->url(['action' => 'index'])}" class="action return">Return to overview</a> &mdash;
    <a href="{$html->url(['action' => 'edit', $rule.Rule.id])}" class="action edit">Edit this rule</a>
  </p>
</header>
<table>
  <thead>
  <tr>
    <th>Posted</th>
    <th>Status<sup>1</sup></th>
    <th>Description</th>
    <th>Actions</th>
  </tr>
  </thead>
  <tbody>
  {$current_time_stamp = $smarty.now|date_format:'U'}
  {foreach $rule.Auction as $auction}
  {$parts = split('-',$auction.ts_auction_id)}
  {$player_ts_id = $parts.0}
  {$auction_id = sprintf('%x', $parts.1)}
  {if $current_time_stamp > $auction.endtime|date_format:'U' && $auction@first}
  <tr>
    <td colspan="99" class="info"> - There are currently no active auctions - </td>
  </tr>
  {/if}
  <tr{if $current_time_stamp > $auction.endtime|date_format:'U'} class="inactive"{/if}>
    <td>{$auction.created|relative_date}</td>
    <td>{if $current_time_stamp > $auction.endtime|date_format:'U'}Ended{else}Active{/if}</td>
    <td>{$auction.title|escape}</td>
    <td class="actions">
      <a href="http://beta.glitch.com/auctions/{$player_ts_id}/{$auction_id}/" class="view" title="View">View</a>
      <a href="http://beta.glitch.com/auctions/{$player_ts_id}/{$auction_id}/cancel/" class="cancel" title="Cancel">Cancel</a>
    </td>
  </tr>
  {/foreach}
  </tbody>
</table>
<p><sup>1</sup> It's currently not possible to determine an auction's current status (active, sold or unsold).</p>