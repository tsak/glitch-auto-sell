<?php 
class CronShell extends Shell {
  var $uses = array('Player', 'Rule', 'GlitchApi', 'Auction');

	function main() {
    $lockfile = TMP . 'gas.lock';
    $pid = @file_get_contents($lockfile);
    if(file_exists($lockfile)) {
      if (posix_getsid($pid) === false) {
        file_put_contents($lockfile, getmypid()); // create lockfile
      } else {
        exit;
      }
    } else {
      file_put_contents($lockfile, getmypid());
    }

    // Find all players with more than 1 rule
    $players = $this->Player->find('all', array(
      'fields' => array(
        'Player.name',
        'Player.tsid',
        'Player.oauth2_token',
        'COUNT(Rule.id) AS rules_count'
      ),
      'joins' => array(
        array(
          'table' => 'rules',
          'alias' => 'Rule',
          'type' => 'LEFT',
          'conditions' => array(
            'Rule.player_id = Player.id',
          )
        )
      ),
      'conditions' => array(
        'Rule.is_active' => '1'
      ),
      'group' => 'Player.id HAVING rules_count >= 1',
    ));
    
    App::import('Core', 'Controller');
    App::import('Controller', 'Rules');
    $RulesController = new RulesController();
    $RulesController->constructClasses();

    // Iterate over all found player records
    foreach($players as $player) {
      // Trying to avoid call rate limitation
      sleep(1);

      $inventory = $RulesController->get_player_inventory($player['Player']['id'], 0, true);

      // If a player's inventory is empty, continue with next player
      if(!is_array($inventory['contents'])) continue;

      $flat_inventory = array();
      foreach($inventory['contents'] as $slot_id => $slot) {
        if(isset($slot['contents'])) {
          foreach($slot['contents'] as $sub_slot_id => $sub_slot) {
            if(isset($sub_slot)) {
              $flat_inventory[] = $sub_slot;
            }
          }
        } else {
          if(isset($slot)) {
            $flat_inventory[] = $slot;
          }
        }
      }
      unset($inventory);

      $rules = $this->Rule->find('all', array(
        'conditions' => array(
          'Rule.player_id' => $player['Player']['id'],
          'Rule.is_active' => 1,
        ),
        'fields' => array(
          'quantity', 'price', 'class_tsid'
        ),
      ));

      // transform players rules into a more accessible form
      $rules_hash = array();
      foreach($rules as $temp) {
        $rules_hash[$temp['Rule']['class_tsid']] = array(
          'q' => $temp['Rule']['quantity'],
          'p' => $temp['Rule']['price'],
          'id' => $temp['Rule']['id'],
        );
      }
      unset($rules);

      foreach($flat_inventory as $item) {
        if(array_key_exists($item['class_tsid'], $rules_hash)) {
          if($item['count'] >= $rules_hash[$item['class_tsid']]['q']) {
            // Trying to avoid call rate limitation
            sleep(1);

            // List the item
            $auction = $this->GlitchApi->auctions_create(
              $player['Player']['oauth2_token'],
              $item['tsid'],
              $rules_hash[$item['class_tsid']]['q'],
              $rules_hash[$item['class_tsid']]['p']
            );

            $log_entry = '[' . $player['Player']['tsid'] . '] ' . $player['Player']['name'] . ' - ' . $rules_hash[$item['class_tsid']]['q'] . ' x ' . $item['label'] . ' for ' . $rules_hash[$item['class_tsid']]['p'] . ' currants (' . $item['count'] . ' items found, rule #' . $rules_hash[$item['class_tsid']]['id'] . ')';

            // Write history entry
            if($auction['ok']) {
              $this->Auction->create();
              $this->Auction->save(array(
                'Auction' => array(
                  'rule_id' => $rules_hash[$item['class_tsid']]['id'],
                  'ts_auction_id' => $auction['id'],
                  'title' => $rules_hash[$item['class_tsid']]['q'] . ' x ' .$item['label'] . ' for ' . $rules_hash[$item['class_tsid']]['p'],
                  'endtime' => date('Y-m-d H:i:s', strtotime('+24 hours')),
                  'quantity' => $rules_hash[$item['class_tsid']]['q'],
                  'price' => $rules_hash[$item['class_tsid']]['p'],
                  'profit' => ($rules_hash[$item['class_tsid']]['p'] * 0.015 < 3 ? 3 : $rules_hash[$item['class_tsid']]['p'] * 0.015)*-1,
                )
              ));
              CakeLog::write('cron', $log_entry);
            } else {
              CakeLog::write('cron_error', $log_entry . ' - Error: ' . $auction['error']);

              // Stopping items/rule processing if a player has reached max_auctions
              if($auction['error'] == 'max_auctions') break;
            }
          }
        }
      }

      unset($flat_inventory, $rules_hash, $log_entry);
    }

    @unlink($lockfile);
  }
}
?>
