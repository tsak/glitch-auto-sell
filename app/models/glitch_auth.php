<?php

/**
 * GlitchAuth
 *
 */

App::import('Model', 'GlitchApi');

class GlitchAuth extends GlitchApiModel {
  var $name = 'GlitchAuth';

  function check($token = '') {
    $this->request['uri'] = array(
      'path' => '/simple/auth.check',
      'query' => array(
        'oauth_token' => $token
      )
    );
    return parent::find('all', array());
  }
}