<?php

/**
 * Rule
 *
 */
 
class Rule extends AppModel {
  var $name = 'Rule';

  var $hasMany = array(
    'Auction' => array(
      'dependent' => true,
      'order' => 'Auction.created DESC',
    )
  );
}