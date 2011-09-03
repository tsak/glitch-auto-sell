<?php

/**
 * Auth
 *
 */

class AuthController extends AppController {

	var $name = 'Auth';

    var $uses = array('GlitchAuth', 'GlitchPlayer');

	function index() {
        debug($this->GlitchAuth);
        $test = $this->GlitchAuth->check();
        echo $test;
	}

  function response() {
    if(!empty($this->params['url']['code'])) {
      App::import('Core', 'HttpSocket');
      $httpSocket = new HttpSocket();
      $response = $httpSocket->post('http://api.glitch.com/oauth2/token', array(
          'grant_type'	=> 'authorization_code',
          'code' => $this->params['url']['code'],
          'client_id'	=> Configure::read('Glitch.api.key'),
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
    $player = $this->GlitchPlayer->info($this->Session->read('Glitch.api.access_token'));
    $this->Session->write('Glitch.player', $player);
    $this->set('player', $player);
  }
}
