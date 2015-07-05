<?php

class ListController extends AppController
{

	public $components = array('DebugKit.Toolbar');

	public function index()
	{

		//Getパラメータから現在地情報を取得
		$lat = $this->request->query('lat');
		$lng = $this->request->query('lng');

		//現在地が取得てきていなければ、トップにリダイレクト
		if ($lat == 'null' || $lng == 'null') {
			$this->redirect('/?geo_info=0');
		}

		//現在地情報をViewに渡す
		$this->set('lat', $lat);
		$this->set('lng', $lng);

		//近郊とする緯度経度の範囲
		$lat_diff = 0.030;
		$lng_diff = 0.030;

		//現在地をもとに近郊のスポットのみDBから検索
		$Spot = ClassRegistry::init('Spot');
		$spots = $Spot->find('all',
			array(
				'fields' => Array('id', 'name', 'category_id', 'description', 'like_num'),
				'conditions' => array(
					'and' => array(
						array('lat BETWEEN ? AND ?' =>
							array($lat - $lat_diff, $lat + $lat_diff)),
						array('lng BETWEEN ? AND ?' =>
							array($lng - $lng_diff, $lng + $lng_diff))
					)
				)
			));
		//検索結果を渡す
		$this->set('spots', $spots);

		//検索したスポットの数を取得
		$num_of_spots = count($spots);
		$this->set('num_of_spots', $num_of_spots);

		//現在地をもとに近郊のツアーのみDBから検索
		$Tour = ClassRegistry::init('Tour');
		$joins = array(
			array(
				'type' => 'inner',
				'table' => 'tour_spot_rels',
				'aliau' => 'Goal',
				'conditions' => array(
					'Tour.id = tour_spot_rels.tour_id'
				),
			),
		);
		$tours = $Tour->find('all',
			array(
				'joins' => $joins,
				'alias' => 'Tour',
				'fields' => Array('Tour.id', 'Tour.name', 'Tour.description', 'tour_spot_rels.spot_id'),
				'conditions' => array(
					'and' => array(
						array('lat BETWEEN ? AND ?' =>
							array($lat - $lat_diff, $lat + $lat_diff)),
						array('lng BETWEEN ? AND ?' =>
							array($lng - $lng_diff, $lng + $lng_diff)),
						array('tour_spot_rels.goal_flag' => 1)
					)
				)
			));
		//検索結果を渡す
		$this->set('tours', $tours);

		//検索したツアーの数を取得
		$num_of_tours = count($tours);
		$this->set('num_of_tours', $num_of_tours);

		//とりあえずぶらり用にランダムにspot_idを指定する
		if ($num_of_spots > 0) {
			$this->set('rand_spot_id', $spots[rand(0, $num_of_spots - 1)]['Spot']['id']);
		} else {

		}
	}
}
