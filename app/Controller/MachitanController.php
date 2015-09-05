<?php


App::uses('Controller', 'Controller');


class MachitanController extends Controller
{

	public $components = array('DebugKit.Toolbar');

	public function index()
	{
		$num_of_rankingspot = 3;

		$Spot = ClassRegistry::init('Spot');
		$spot_ranking_all = $Spot->find('all', array(
			'fields' => array('id', 'name','like_num','played'),
			'order' => array('played' => 'desc', 'like_num' => 'desc'),
      'limit' => $num_of_rankingspot
		));
		$this->set('spot_ranking_all',$spot_ranking_all);

		$Tour = ClassRegistry::init('Tour');
		$tour_ranking_all = $Tour->find('all', array(
			'fields' => array('id', 'name','played','played_finished','finished_rate'),
			'order' => array('finished_rate' => 'desc'),
      'limit' => $num_of_rankingspot
		));
		$this->set('tour_ranking_all',$tour_ranking_all);

		$TourSpotRels = ClassRegistry::init('TourSpotRel');
		$tour_ranking_all_image = $TourSpotRels->find('all', array(
			'fields' => array('id', 'tour_id', 'spot_id'),
			'conditions' => array(
				'and' => array(
					array('tour_id' =>
						array(
							$tour_ranking_all[0]['Tour']['id'],
							$tour_ranking_all[1]['Tour']['id'])
						),
					array('goal_flag' => 1)
				)
			)
		));
		$this->set('tour_ranking_all_image',$tour_ranking_all_image);

		$geo_info = $this->request->query('geo_info');
		$this->set('geo_info', $this->request->query('geo_info'));
	}

	public function manualplayer() {

	}
}
