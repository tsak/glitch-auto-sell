<?php

/**
 * GlitchApi
 *
 */
 
class GlitchApi extends AppModel {
  var $name = 'GlitchApi';
       
  public $useTable = false;

  public $useDbConfig = 'glitch_api';

  public $_schema = array();

  public $request = array();

  private $token = '';

  /**
   * Checks if a given token is authenticated.
   *
   * @param string $token
   * @return Authentication status of $token
   * @see http://api.glitch.com/explore/#!auth.check
   */
  function auth_check($token = '') {
    $this->request['uri'] = array(
      'path' => '/simple/auth.check',
      'query' => array(
        'oauth_token' => $token
      )
    );
    return parent::find('all', array());
  }

  /**
   * Returns an array with player information.
   *
   * @param string $token
   * @return array $player_info
   * @see http://api.glitch.com/explore/#!players.info
   */
  function players_info($token = '') {
    $this->request['uri'] = array(
      'path' => '/simple/players.info',
      'query' => array(
        'oauth_token' => $token
      )
    );
    return parent::find('all', array());
  }

}