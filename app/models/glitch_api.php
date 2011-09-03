<?php

/**
 * GlitchApi
 *
 */
 
class GlitchApiModel extends AppModel {
  var $name = 'GlitchApi';
       
  public $useTable = false;

  public $useDbConfig = 'glitch_api';

  public $_schema = array();

  public $request = array();

  function __construct($id = false, $table = null, $ds = null) {
    $this->request['query'] = array(
    );
    parent::__construct();
  }
}