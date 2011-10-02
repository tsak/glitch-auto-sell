<?php
/**
 * AuctionsShell
 *
 * Cakeshell based action to periodically poll auction info from the Glitch marketplace.
 * Caches listing and item info.
 */
App::import('Core', 'HttpSocket');

class StatusShell extends Shell {
  var $uses = array('Auction');

	function main() {
    $http = new HttpSocket();
    $auctions = $this->Auction->find('all', array(
        'conditions' => array(
          'endtime < NOW()',
          'status' => 'PENDING',
        ),
        'fields' => array('id', 'ts_auction_id', 'price')
      )
    );

    $stats = array(
      'FOUND' => count($auctions),
      'SOLD' => 0,
      'UNSOLD' => 0,
      'CANCELLED' => 0,
      'UNDETERMINED' => 0,
      'FAILED' => 0,
    );

    $log_entry = '';
    foreach($stats AS $k => $v) $log_entry .= $k . ' ' . $v . ', ';

    $c = 0;
    foreach($auctions as $auction) {
      $c++;
      list($player_ts_id,$auction_id) = split('-', $auction['Auction']['ts_auction_id']);
      $url = 'http://www.glitch.com/auctions/' . $player_ts_id . '/' . sprintf('%x', $auction_id) . '/';

      $html = $http->get($url);
      if($html != false) {
        $this->Auction->read(null, $auction['Auction']['id']);
        if(strpos($html, 'You snooze, you lose') != false) { // SOLD
          $status = 'SOLD';
        } else if(strpos($html, 'The fat lady sang her ditty') != false) { // UNSOLD
          $status = 'UNSOLD';
        } else if(strpos($html, 'This auction was cancelled') != false) { // CANCELLED
          $status = 'CANCELLED';
        } else { // UNDETERMINED, but possibly CANCELLED
          $status = 'UNDETERMINED';
        }
        $this->Auction->set('status', $status);
        $listing_fee = ($auction['Auction']['price'] * 0.015 < 3 ? 3 : $auction['Auction']['price'] * 0.015);
        if($status == 'SOLD') {
          $profit = $auction['Auction']['price'] * 0.92-$listing_fee;
        } else {
          $profit = $listing_fee*-1;
        }
        $this->Auction->set('profit', $profit);
        $this->Auction->save();
      } else {
        $status = 'FAILED';
      }

      $stats[$status]++;
      $log_entry = '';
      foreach($stats AS $k => $v) $log_entry .= $k . ' ' . $v . ', ';
      echo $log_entry . "CURRENT $c\r";
    }
    CakeLog::write('status', preg_replace('/, $/', '', $log_entry));
  }
}