<?php

/**
 * Auction
 *
 */

class Auction extends AppModel {
  var $name = 'Auction';

  var $belongsTo = array(
    'Rule' => array(
      'counterCache' => true,
    ),
  );

  var $order = "Auction.created DESC";

  var $virtualFields = array(
    'active' => '(NOW() < Auction.endtime)',
//    'profit' => "CAST(IF(status = 'SOLD', Auction.price*0.92-IF(Auction.price*0.015<3,3,Auction.price*0.015), IF(Auction.price*0.015<3,3,Auction.price*0.015)*-1) AS SIGNED)"
  );
}