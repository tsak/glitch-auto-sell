<?php
/**
 * AuctionsShell
 *
 * Cakeshell based action to periodically poll auction info from the Glitch marketplace.
 * Caches listing and item info.
 */
class AuctionsShell extends Shell {
  var $uses = array('GlitchApi', 'Listing', 'Item');

	function main() {
    $new_listings = 0; // Counts new listings found
    $new_items = 0; // Counts new items found
    $page = 0;
    $pages = 1;
    $per_page = 1000;
    do {
      $page++;
      $auctions = $this->GlitchApi->auctions_list($page, $per_page);
      if($auctions['ok']) {
        $pages = intval($auctions['pages']);

        foreach($auctions['items'] as $auction_id => $item) {
          $check = $this->Listing->read(null, $auction_id); // Check if a listing is already stored in the database
          if(empty($check)) {
            $new_listings++;
            $this->Listing->create();
            $this->Listing->save(array(
              'id' => $auction_id,
              'created' => date('Y-m-d H:i:s', $item['created']),
              'expires' => date('Y-m-d H:i:s', $item['expires']),
              'item_id' => $item['class_tsid'],
              'count' => $item['count'],
              'cost' => $item['cost'],
              'url' => $item['url'],
              'player_tsid' => $item['player']['tsid'],
              'player_name' => $item['player']['name'],
            ));
          }
          unset($check);

          $check = $this->Item->read(null, $item['item_def']['class_tsid']); // Check if an item is already stored in the database
          if(empty($check)) {
            $new_items++;
            $this->Item->create();
            $this->Item->save(array(
              'id' => $item['item_def']['class_tsid'],
              'class_tsid' => $item['item_def']['class_tsid'],
              'name_single' => $item['item_def']['name_single'],
              'name_plural' => $item['item_def']['name_plural'],
              'category' => $item['item_def']['category'],
              'max_stack' => $item['item_def']['max_stack'],
              'desc' => $item['item_def']['desc'],
              'base_cost' => $item['item_def']['base_cost'],
              'swf_url' => $item['item_def']['swf_url'],
              'iconic_url' => $item['item_def']['iconic_url'],
            ));
          }
          unset($check);
        }
      }
    } while($page < $pages);
    CakeLog::write('auctions', $auctions['total'].' active listings found ('.$new_listings.' new listings, '.$new_items.' new items, '.$pages.' API calls made)');
  }
}