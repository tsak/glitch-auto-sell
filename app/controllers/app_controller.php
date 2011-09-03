<?php

class AppController extends Controller {

  var $helpers = array('Form', 'Html', 'Javascript', 'Time','Text','Ajax','Session');

  var $components = array('Session', 'Email','RequestHandler');
  
  function beforeFilter(){
    $this->view = 'Smarty'; // Use Smarty template engine

    // Disable debug output in certain cases    
    if($this->RequestHandler->isAjax() || $this->RequestHandler->isXml()) {
      Configure::write('debug',0);
    }

    parent::beforeFilter();
  }

}


?>