<?php

class PagesController extends AppController {

	var $name = 'Pages';

	var $uses = array();

  function beforeRender() {
    if(isset($this->viewVars['page']) && $this->viewVars['page'] == 'home') {

      if (($site_stats = Cache::read('site_stats')) === false) {
        App::import('Model', 'Player');
        $this->Player = new Player();

        App::import('Model', 'Auction');
        $this->Auction = new Auction();
        $this->Auction->recursive = -1;

        App::import('Model', 'Rule');
        $this->Rule = new Rule();

        $site_stats = array(
          'users' => $this->Player->find('count'),
          'auctions' => $this->Auction->find('count'),
          'rules' => $this->Rule->find('count'),
        );

        Cache::write('site_stats', $site_stats);
      }

      $this->set('site_stats', $site_stats);
    }
  }

	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
