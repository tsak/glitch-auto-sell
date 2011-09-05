<?php

/**
 * Player
 *
 */

class Player extends AppModel {
  var $name = 'Player';

  var $hasMany = array(
    'Rule' => array(
      'foreignKey' => 'player_id'
    )
  );
}