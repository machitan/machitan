<?php


App::uses('Controller', 'Controller');


class MachitanController extends Controller
{

	public $components = array('DebugKit.Toolbar');

	public function index()
	{

		$Spot = ClassRegistry::init('Spot');
		$spot_ranking_all = $Spot->find('all', array(
			'fields' => array('id', 'name','like_num','played'),
			'order' => array('played' => 'desc', 'like_num' => 'desc'),
      'limit' => 5
		));
		$this->set('spot_ranking_all',$spot_ranking_all);

		$geo_info = $this->request->query('geo_info');
		$this->set('geo_info', $this->request->query('geo_info'));
		if($geo_info != null){
			sweetAlert("現在地が取得できませんでした","しばらくしてから、もう一度ボタンをタッチしてください");
		}
	}

}
