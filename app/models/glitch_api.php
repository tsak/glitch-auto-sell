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

  /**
   * Returns an array of items.
   *
   * @param string $token
   * @return array $player_inventory
   */
  function players_inventory($token = '', $defs = 0) {
    $this->request['uri'] = array(
      'path' => '/simple/players.inventory',
      'query' => array(
        'oauth_token' => $token,
        'defs' => intval($defs)
      )
    );
    return parent::find('all', array());
  }

  /**
   * For later use.
   *
   * @param string $tsid
   * @return array of player avatar animation information
   */
  function players_getAnimations($tsid = '') {
    $this->request['uri'] = array(
      'path' => '/simple/players.getAnimations',
      'query' => array(
        'player_tsid' => $tsid
      )
    );
    return parent::find('all', array());
  }

  function auctions_create($token, $stack_tsid, $count, $cost) {
    $this->request['uri'] = array(
      'path' => '/simple/auctions.create',
      'query' => array(
        'oauth_token' => $token,
        'stack_tsid' => $stack_tsid,
        'count' => $count,
        'cost' => $cost
      )
    );
    return parent::find('all', array());
  }

  function auctions_list($page = 1, $per_page = 1000, $defs = 1) {
    $this->request['uri'] = array(
      'path' => '/simple/auctions.list',
      'query' => array(
        'page' => intval($page),
        'per_page' => intval($per_page),
        'defs' => intval($defs),
      )
    );
    return parent::find('all', array());
  }
}