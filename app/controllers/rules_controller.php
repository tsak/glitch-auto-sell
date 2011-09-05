<?php

/**
 * Rules
 *
 */

class RulesController extends AppController {

	var $name = 'Rules';

  var $uses = array('GlitchApi', 'Player', 'Rule', 'Auction');
	
	function index() {
    $this->Rule->recursive = -1;
    $this->set('rules', $this->Rule->find('all', array(
      'conditions' => array(
        'Rule.player_id' => $this->Session->read('player_id')
      ),
    )));
	}

  function create() {
    $this->set('inventory', $this->get_player_inventory(0, 1));
  }

  function add($tsid = '') {
    $item = $this->find_item($tsid, 1);
    if(!empty($this->data)) {
      $this->data['Rule']['class_tsid'] = $item['class_tsid'];
      $this->data['Rule']['name_single'] = $item['item_def']['name_single'];
      $this->data['Rule']['name_plural'] = $item['item_def']['name_plural'];
      $this->data['Rule']['max_stack'] = $item['item_def']['max_stack'];
      $this->data['Rule']['base_cost'] = $item['item_def']['base_cost'];
      $this->data['Rule']['iconic_url'] = $item['item_def']['iconic_url'];
      $this->data['Rule']['player_id'] = $this->Session->read('player_id');
      if($this->Rule->save($this->data)) {
        $this->redirect(array('action' => 'confirm', $this->Rule->id));
      }
    }
    $this->set('item', $item);
  }

  function delete($id) {
    $this->Rule->deleteAll(
      array(
        'Rule.id' => $id,
        'Rule.player_id' => $this->Session->read('player_id')
      ),
      true
    );
    $this->redirect(array('action' => 'index'));
  }

  function confirm($id) {
    $this->set('rule', $this->Rule->read(null, $id));
  }

  function activate($id, $status = 1) {
    $this->Rule->read(null, $id);
    $this->Rule->set('is_active', $status);
    $this->Rule->save();
    $this->redirect(array('action' => 'index'));
  }

  function deactivate($id) {
    $this->activate($id, 0);
  }

  function edit($id = null) {
    if(!empty($this->data)) {
      $this->Rule->id = $id;
      if($this->Rule->save($this->data)) {
        $this->redirect(array('action' => 'index'));
      }
    }
    $this->data = $this->Rule->read(null, $id);
  }

  function get_player_inventory($id = 0, $defs = 0, $ignore_cache = false) {
    if($id) $player = $this->Player->read('tsid,oauth2_token', $id);
    $player_tsid = ($this->Session->read('Glitch.player.player_tsid') ? $this->Session->read('Glitch.player.player_tsid') : $player['Player']['tsid']);
    $oauth2_token = ($this->Session->read('Glitch.api.access_token') ? $this->Session->read('Glitch.api.access_token') : $player['Player']['oauth2_token']);
    if($ignore_cache) {
      $inventory = $this->GlitchApi->players_inventory($oauth2_token, $defs);
    } else {
      if (($inventory = Cache::read('inventory_' . $player_tsid, 'short')) === false) {
        $inventory = $this->GlitchApi->players_inventory($oauth2_token, $defs);
        Cache::write('inventory_' . $player_tsid, $inventory, 'short');
      }
    }
    return $inventory;
  }

  function auctions($id) {
    $this->set('rule', $this->Rule->findById($id));
  }

  private function find_item($tsid = '', $defs = 0) {
    $inventory = $this->get_player_inventory(0, $defs);
    foreach($inventory['contents'] as $slot_id => $slot) {
      if(isset($slot['contents'])) {
        foreach($slot['contents'] as $sub_slot_id => $sub_slot) {
          if(isset($sub_slot)) {
            if($sub_slot['tsid'] == $tsid) return $sub_slot;
          }
        }
      } else {
        if(isset($slot)) {
          if($slot['tsid'] == $tsid) return $slot;
        }
      }
    }
  }
}