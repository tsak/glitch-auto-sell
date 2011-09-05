<?php

/**
 * Auth
 *
 */

class AuthController extends AppController {

  var $name = 'Auth';

  var $uses = array('GlitchApi', 'Player');

  function index() {
    $this->set('status', $this->GlitchApi->auth_check($this->Session->read('Glitch.api.access_token')));
  }

  function response() {
    if(!empty($this->params['url']['code'])) {
      App::import('Core', 'HttpSocket');
      $httpSocket = new HttpSocket();
      $response = $httpSocket->post('http://api.glitch.com/oauth2/token', array(
        'grant_type' => 'authorization_code',
        'code' => $this->params['url']['code'],
        'client_id' => Configure::read('Glitch.api.key'),
        'client_secret' => Configure::read('Glitch.api.secret'),
        'redirect_uri' => Router::url('/auth/response', true),
      ));
      $response = json_decode($response, true);
      if(isset($response['error'])) {
        $this->Session->setFlash($response['error_description']);
        $this->redirect(array('action' => 'error'));
      } else {
        $this->Session->write('Glitch.api.access_token', $response['access_token']);
        $this->redirect(array('action' => 'success'));
      }
    }
  }

  function error() {

  }

  function success() {
    $glitch_player = $this->GlitchApi->players_info($this->Session->read('Glitch.api.access_token'));
    $this->Session->write('Glitch.player', $glitch_player);
    if(($player = $this->Player->findByTsid($glitch_player['player_tsid'])) !== false) {
      $this->Player->id = $player['Player']['id'];
    }
    $this->Player->save(array(
        'name' => $glitch_player['player_name'],
        'tsid' => $glitch_player['player_tsid'],
        'oauth2_token' => $this->Session->read('Glitch.api.access_token'),
      ));
    $this->Session->write('player_id', $this->Player->id);
    $this->set('player', $glitch_player);
  }
}
