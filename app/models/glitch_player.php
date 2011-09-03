<?php

/**
 * GlitchPlayer
 *
 */

App::import('Model', 'GlitchApi');

class GlitchPlayer extends GlitchApiModel {
  var $name = 'GlitchPlayer';

  function info($token = '') {
    $this->request['uri'] = array(
      'path' => '/simple/players.info',
      'query' => array(
        'oauth_token' => $token
      )
    );
    return parent::find('all', array());
  }
}