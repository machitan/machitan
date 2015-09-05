<?php

class ManageController extends AppController
{

	public $components = array('Session', 'DebugKit.Toolbar');

	public function index(){
	}

	public function addspot()
	{
		$direction_id = $this->request->query('direction_id');
		$step_id = $this->request->query('step_id');
		$destination_spot_id = $this->request->query('destination_spot_id');

		//Listからの遷移時にスポット登録後Listへリダイレクト
		if ($this->request->query('first')) {
			$this->set('direction_id', -1);
		} //Playからの遷移時にスポット登録後Playへリダイレクト
		else {
			$this->set('direction_id', $direction_id);
		}
		$this->set('step_id', $step_id);
		$this->set('destination_spot_id', $destination_spot_id);

	}

	public function showtour()
	{
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
				'fields' => Array('Tour.id', 'Tour.name', 'Tour.description', 'tour_spot_rels.spot_id', 'Tour.finished_rate'),
				'conditions' => array(
					'and' => array(
						array('tour_spot_rels.goal_flag' => 1)
					)
				)
			));
		//検索結果を渡す
		$this->set('tours', $tours);
	}

	public function showtourdetail()
	{
		$tour_id = $this->request->query['tour_id'];
		$this->set('tour_id',$tour_id);

		$Tour = ClassRegistry::init('Tour');
		$joins = array(
			array(
				'type' => 'inner',
				'table' => 'tour_spot_rels',
				'aliau' => 'Goal',
				'conditions' => array(
					'and' => array(
						array('Tour.id = tour_spot_rels.tour_id'),
						array('Tour.id' => $tour_id)
					)
				),
			),
			array(
				'type' => 'inner',
				'table' => 'spots',
				'aliau' => 'Goal',
				'conditions' => array(
					'and' => array(
						array('spots.id = tour_spot_rels.spot_id')
					)
				),
			)
		);
		$tours = $Tour->find('all',
			array(
				'joins' => $joins,
				'alias' => 'Tour',
				'fields' => Array('Tour.id', 'Tour.name', 'Tour.description', 'Tour.route_optimized', 'tour_spot_rels.spot_id', 'Tour.finished_rate', 'tour_spot_rels.goal_flag','spots.lat','spots.lng'),
				'order' => array('tour_spot_rels.spot_order' => 'asc')
			)
		);
		//$this->set('tours', $tours);
		$this->set('tour_name', $tours[0]['Tour']['name']);
		$this->set('tour_description', $tours[0]['Tour']['description']);
		$this->set('tour_route_optimized', $tours[0]['Tour']['route_optimized']);

		//地図情報の格納と連携
		$waypoints = array();
		$center_lat = 0;
		$center_lng = 0;
		for($i = 0; $i < count($tours); $i++){
			$center_lat += $tours[$i]['spots']['lat'];
			$center_lng += $tours[$i]['spots']['lng'];

			if($tours[$i]['tour_spot_rels']['goal_flag']){
				$this->set('end_lat',$tours[$i]['spots']['lat']);
				$this->set('end_lng',$tours[$i]['spots']['lng']);
	}
			else{
				$waypoints[] = $tours[$i]['spots']['lat'] . ',' . $tours[$i]['spots']['lng'];
			}
		}
		$this->set('waypoints',$waypoints);
		$this->set('num_of_waypoints',count($waypoints));

		$this->set('start_lat',$center_lat/count($tours));
		$this->set('start_lng',$center_lng/count($tours));

	}

	public function addtour()
	{
	}

	public function addtourresult()
	{
		$tour_data = $this->request->data;

		$candidates = array();
		$tour_description = 'ツアーの説明は入力されていません';

		while ($data = current($tour_data)) {
			$data_key = key($tour_data);
			if($data_key == 'tour_name'){
				$tour_name = $tour_data[$data_key];
			}
			else if($data_key == 'tour_description'){
				$tour_description = $tour_data[$data_key];
			}
			else if($data_key == 'is_goal'){
				$goal_spot = $tour_data[$data_key];
			}
			else if($data_key == 'lat'){
				$lat = $tour_data[$data_key];
			}
			else if($data_key == 'lng'){
				$lng = $tour_data[$data_key];
			}
			else{
				$candidates[] = $tour_data[$data_key];
			}
			next($tour_data);
		}

		$this->set('candidates',$candidates);
		$this->set('tour_name',$tour_name);
		$this->set('tour_description',$tour_description);

		$waypoints = array();

		$Spots = ClassRegistry::init('Spots');
		$center_lat = 0;
		$center_lng = 0;
		for($k = 0; $k < count($candidates); $k++){
			$spots_info = $Spots->find('all',
									   array(
										   'conditions' => array('id' => $candidates[$k])
									   )
									 );
			$center_lat += $spots_info[0]['Spots']['lat'];
			$center_lng += $spots_info[0]['Spots']['lng'];

			if($candidates[$k] == $goal_spot){
				$this->set('end_lat', $spots_info[0]['Spots']['lat']);
				$this->set('end_lng', $spots_info[0]['Spots']['lng']);
			}
			else{
				$waypoints[] = $spots_info[0]['Spots']['lat'] . ',' . $spots_info[0]['Spots']['lng'];
			}
		}

		$this->set('waypoints',$waypoints);
		$this->set('num_of_waypoints',count($waypoints));

		$center_lat = $center_lat / count($candidates);
		$center_lng = $center_lng / count($candidates);

		$this->set('start_lat',$center_lat);
		$this->set('start_lng',$center_lng);

		$Tours = ClassRegistry::init('Tours');
		$Tours->save(
			array(
				'Tours' => array(
					'name' => $tour_name,
					'description' => $tour_description,
					'lat' => $center_lat,
					'lng' => $center_lng
				)
			)
		);
		$tour_id = $Tours->find('all',
			array(
				'fields' => Array('id'),
				'conditions' => array('name' => $tour_name)
				)
			)[0]['Tours']['id'];
		$this->set('tour_id',$tour_id);

		$TourSpotRels = ClassRegistry::init('TourSpotRels');
		foreach($candidates as $cand){

			if($cand == $goal_spot)
				$goal_flag = 1;
			else
				$goal_flag = 0;

			$TourSpotRels->create();
			$TourSpotRels->save(
				array(
					'TourSpotRels' => array(
						'tour_id' => $tour_id,
						'spot_id' => $cand,
						'goal_flag' => $goal_flag
					)
				)
			);
		}
	}

	public function delspot(){
    }

	public function delspotresult(){
        $Spot = ClassRegistry::init('Spot');
        $TourSpotRel = ClassRegistry::init('TourSpotRel');
        $DirectionSpotRel = ClassRegistry::init('DirectionSpotRel');

		$del_data = $this->request->data;
        for($i = 1; $i <= $del_data['del_num']; $i++){
            if(isset($del_data['del_check'.$i])){
                $TourSpotRel->deleteAll(
                    array('TourSpotRel.spot_id' => $del_data['del_check'.$i])
                );
                $DirectionSpotRel->deleteAll(
                    array('DirectionSpotRel.spot_id' => $del_data['del_check'.$i])
                );
                $Spot->delete(($del_data['del_check'.$i]));
            }
        }
		$this->Session->setFlash('スポットが削除されました', 'default', array('class' => 'alert alert-success'));
		$this->redirect('/manage/delspot');
    }


	public function add()
	{
		/**
            TODO：
            ここでユーザが登録した類似スポットのチェックの情報が
            取得てきていない！
		 */
		$checks = array();
		for($i = 1; $i <= 5; $i++){
			if(isset($this->request->data['chk_' + $i]))
				array_push($checks,$this->request->data['chk_' + $i]);
		}

		$Spots = ClassRegistry::init('Spots');
		$direction_id = $this->request->data['direction_id'];
		$step_id = $this->request->data['step_id'];
		$destination_spot_id = $this->request->data['destination_spot_id'];

		$lat = $this->request->data('lat');
		$lng = $this->request->data('lng');

		$this->set('direction_id', $direction_id);
		$this->set('step_id', $step_id);
		$this->set('destination_spot_id', $destination_spot_id);

		$this->set('tmp',$Spots);
		if ($lat == 'null' or $lng == 'null') {
			//位置情報取得に失敗
			$this->Session->setFlash('現在地が取得できません。', 'default', array('class' => 'alert alert-success'));
			$this->redirect('/manage?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
		} else {
			if (is_uploaded_file($_FILES["picture"]["tmp_name"])) {
				if (move_uploaded_file($_FILES["picture"]["tmp_name"], "img/machitan_pic/" . $_FILES["picture"]["name"])) {
					if ($Spots->save(
						array(
							'Spots' => array(
								'lat' => $lat,
								'lng' => $lng,
								'name' => $this->request->data['name'],
								'description' => $this->request->data['description'],
								'category_id' => $this->request->data['category_id'],
								'manage_flag' => 1
							)
						)
					)
					) {
						$dir_name = $Spots->getLastInsertID();
						$file_name = $dir_name . "_" . uniqid()  . ".jpg";
						mkdir("img/machitan_pic/".$dir_name);
						rename("img/machitan_pic/" . $_FILES["picture"]["name"], "img/machitan_pic/". $dir_name . "/" . $file_name);
						chmod("img/machitan_pic/" .$dir_name . "/" . $file_name, 0664);
						echo $_FILES["picture"]["name"] . "をアップロードしました。";
						$this->Session->setFlash('スポットが登録されました！', 'default', array('class' => 'alert alert-success'));
						$this->redirect('/manage');

					}
				} else {
					//ファイルのアップロードの失敗
					$this->Session->setFlash('ファイルをアップロードできません。', 'default', array('class' => 'alert alert-success'));
					$this->redirect('/manage?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
				}
			}
			else {
				//アップロードファイルが未選択
				$this->Session->setFlash('ファイルが選択されていません。', 'default', array('class' => 'alert alert-success'));

				$this->redirect('/manage?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
			}
		}
	}

	public function readsimilar()
	{
		$lat = $this->request->query('lat');
		$lng = $this->request->query('lng');

		//近郊とする緯度経度の範囲
		$lat_diff = 0.005;
		$lng_diff = 0.005;

		//現在地をもとに近郊のスポットのみDBから検索
		$Spot = ClassRegistry::init('Spot');
		$spots = $Spot->find('all',
			array(
				'fields' => Array('id', 'name', 'description'),
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

		$this->set('lat', $lat);
		$this->set('lng', $lng);

	}
}
