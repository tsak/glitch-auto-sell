<?php

class PagesController extends AppController {

	var $name = 'Pages';

	var $uses = array();

  function beforeRender() {
    // This might be bad style
    if(isset($this->viewVars['page']) && $this->viewVars['page'] == 'home') {

      if(Configure::read('debug') == 2) Cache::delete('site_stats');
      if (($site_stats = Cache::read('site_stats')) === false) {
        App::import('Model', 'Player');
        $this->Player = new Player();

        App::import('Model', 'Auction');
        $this->Auction = new Auction();
        $this->Auction->recursive = -1;
        $currants = $this->Auction->query("SELECT SUM(Auction.price) AS total FROM auctions AS Auction WHERE Auction.status = 'SOLD'");

        App::import('Model', 'Rule');
        $this->Rule = new Rule();

        $auction_status_count = $this->Auction->query("SELECT Auction.status, COUNT(Auction.id) AS num FROM auctions AS Auction GROUP BY Auction.status ORDER BY Auction.status");

        $site_stats = array(
          'users' => $this->Player->find('count'),
          'auctions' => $this->Auction->find('count'),
          'rules' => $this->Rule->find('count'),
          'currants' => $currants[0][0]['total'],
          'auction_status_count' => Set::combine($auction_status_count, '{n}.Auction.status', '{n}.0.num'),
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
