<?php

class PlayController extends Controller {

    public $components = array('DebugKit.Toolbar');
    public $uses = array('Spots', 'Directions', 'DirectionSpotRels');

    public function index() {

	/*
	 * パラメータの取得
	 */
	// 経路ID
	$direction_id = $this->request->query('direction_id');
	// Step
	$step_id = $this->request->query('step_id');
	$destination_spot_id = $this->request->query('spot_id');
	// 現在地の緯度・経度
	$lat = $this->request->query('lat');
	$lng = $this->request->query('lng');
	// 天王洲アイル
	//$lat  = 35.620525;
	//$lng = 139.750826;
	// 金沢駅
	//$lat  = 36.578273;
	//$lng = 136.647763;
	// KORINBO
	//$lat  = 36.5625;
	//$lng = 136.653;
  if ($lat == 'null' || $lng == 'null') {
	// 現在地が送信されてこなかったら、兼六園をセット
	  $lat  = 36.5624;
	  $lng = 136.663;
  }
	// 渋谷
	//$lat = 35.658517;
	//$lng = 139.701334;
	if ($direction_id == null) {
		// 初回遷移時
		// ルートを決定し保存する
		$direction_id = $this->__findDirection($lat, $lng, $destination_spot_id);
	}
  else if($direction_id != null && $step_id == '') {
    //ゴールSpot画面からの遷移時はEvalへリダイレクト
		$this->redirect('/eval?direction_id=' . $direction_id);
  }
	
	// 経路JSONの取得
	$directions = $this->Directions->find('first', array(
       			 	'conditions' => array('id' => $direction_id)
    			));
	// 経路JSONのデコード
	$directions_json = json_decode($directions['Directions']['directions_json']);
//	$legs = $directions_json->routes[0]->legs[0];

	$stepAll = array();
	foreach ($directions_json->routes[0]->legs as $l) {
		foreach ($l->steps as $i) {
			array_push($stepAll, $i);
		}
	}

	//$total_distance = $legs->distance->text;
	//$total_duration = $legs->duration->text;

	// 次のstepを存在チェックして取得
	$next_step_id = ($step_id == null) ? 0 : $step_id + 1;
	$step = (count($stepAll) > $next_step_id)
			? $stepAll[$next_step_id] : null ;

	if ($step != null) {
		$this->set('step', $step);
		$this->set('destination_spot_id', $destination_spot_id);
		$this->set('direction_id', $direction_id);
		$this->set('step_id', $next_step_id);
		$this->set('previous_step_id', $next_step_id -1);

		// 現在Spotがstepかどうかチェック！！
		$stepSpot = $this->__getStepSpot($directions, $step);
		if ($stepSpot != null) {
			
			// Spot画面に遷移
			$this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($next_step_id) . "&spot_id=" . $stepSpot['id']);
		}

	} else {
		// ゴール画面に遷移
  		$this->redirect('/spot?spot_id=' . $destination_spot_id . '&direction_id=' . $direction_id);
	}
    }
	
	// 現在Spotがstepかどうかチェック！！
	private function __getStepSpot($directions, $step) {

		foreach ($directions['DirectionSpotRels'] as $row) {
			$spots = $this->Spots->find('first', array(
       			 	'conditions' => array('id' => $row['spot_id'])
    			));
			// 2点間の距離を取得
			$distance = $this->__location_distance(
						$spots['Spots']['lat'], $spots['Spots']['lng'],
						$step->start_location->lat, $step->start_location->lng);
				
			// XXm以下であれば、Spotとみなす
			if ($distance['distance'] <= 75) {
				return $spots['Spots'];
			}
		}
		return null;
	}

	private function __findDirection($lat, $lng, $destination_spot_id) {
		// 初回遷移時
		// 経由地の取得
		// TODO 
	    	$spots = $this->Spots->find('all', array('limit' => 5, 'conditions' => array('id' => array(60))));
		$waypoints = array();
		foreach ($spots as $key => $spot) {
			array_push($waypoints, array(
					'lat' => $spot['Spots']['lat'],
					'lng' => $spot['Spots']['lng']
				));
		} 
		$destination_lat = $waypoints[count($waypoints) -1]['lat'];
		$destination_lng = $waypoints[count($waypoints) -1]['lng'];
		$destination = "$destination_lat,$destination_lng";

		// Goalが指定された場合
		if ($destination_spot_id != null) {
			$destination_spots = $this->Spots->find('first', array(
       			 	'conditions' => array('id' => $destination_spot_id)
    			));
			$destination_lat = $destination_spots['Spots']['lat'];
			$destination_lng = $destination_spots['Spots']['lng'];
			$destination = "$destination_lat,$destination_lng";
		}
	
		$waypointsString = array();
		foreach ($waypoints as $waypoint) {
			$wLat = $waypoint['lat'];
			$wLng = $waypoint['lng'];
			$wLocation = "$wLat,$wLng";
			array_push($waypointsString, $wLocation);
		}

		// Google API から経路取得
    //経由あり
//		$params = array(
//				'origin' => "$lat,$lng",
//				'destination' => $destination,
//				'mode' => 'walking',
//				'waypoints' => join("|", $waypointsString)
//				);
//	        $this->set('params', $params);
    //経由なし
		$params = array(
				'origin' => "$lat,$lng",
				'destination' => $destination,
				'mode' => 'walking'
				);
	        $this->set('params', $params);
	
		$url = "http://maps.googleapis.com/maps/api/directions/json?" . http_build_query($params);
		$res = file_get_contents($url);
    
    //API結果判定 20km以上はなれている場合はlistへリダイレクト
    $res_json = json_decode($res);
    if(str_replace(" km","",$res_json->routes[0]->legs[0]->distance->text) >=20){
      $this->redirect('/list');
    }


		// 経路の保存
		$this->Directions->create();
		$this->Directions->set('directions_json', $res);
		$this->Directions->save();
		$new_direction_id = $this->Directions->id;
		
		// 経路に紐づくSpotの保存
		foreach ($spots as $spot) {
			$this->DirectionSpotRels->create();
			$this->DirectionSpotRels->set('direction_id', $new_direction_id);
			$this->DirectionSpotRels->set('spot_id', $spot['Spots']['id']);
			$this->DirectionSpotRels->save();
		}

		return $new_direction_id;
	}

private function __location_distance($lat1, $lon1, $lat2, $lon2){
	$lat_average = deg2rad( $lat1 + (($lat2 - $lat1) / 2) );//２点の緯度の平均
	$lat_difference = deg2rad( $lat1 - $lat2 );//２点の緯度差
	$lon_difference = deg2rad( $lon1 - $lon2 );//２点の経度差
	$curvature_radius_tmp = 1 - 0.00669438 * pow(sin($lat_average), 2);
	$meridian_curvature_radius = 6335439.327 / sqrt(pow($curvature_radius_tmp, 3));//子午線曲率半径
	$prime_vertical_circle_curvature_radius = 6378137 / sqrt($curvature_radius_tmp);//卯酉線曲率半径
	
	//２点間の距離
	$distance = pow($meridian_curvature_radius * $lat_difference, 2) + pow($prime_vertical_circle_curvature_radius * cos($lat_average) * $lon_difference, 2);
	$distance = sqrt($distance);
	
	$distance_unit = round($distance);
	if($distance_unit < 1000){//1000m以下ならメートル表記
		$distance_unit = $distance_unit."m";
	}else{//1000m以上ならkm表記
		$distance_unit = round($distance_unit / 100);
		$distance_unit = ($distance_unit / 10)."km";
	}
	
	//$hoge['distance']で小数点付きの直線距離を返す（メートル）
	//$hoge['distance_unit']で整形された直線距離を返す（1000m以下ならメートルで記述 例：836m ｜ 1000m以下は小数点第一位以上の数をkmで記述 例：2.8km）
	return array("distance" => $distance, "distance_unit" => $distance_unit);
}
    
}
