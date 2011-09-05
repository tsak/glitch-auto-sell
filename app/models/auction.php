<?php

/**
 * Auction
 *
 */

class Auction extends AppModel {
  var $name = 'Auction';

  var $belongsTo = array(
    'Rule' => array('counterCache' => true),
  );
}