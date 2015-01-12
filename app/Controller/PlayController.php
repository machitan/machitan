<?php

class PlayController extends Controller
{

    /**
     * 経由地とスポットを同一とみなす距離
     */
    const THRESHOLD_M = 50;

    public $components = array('Session', 'DebugKit.Toolbar');
    public $uses = array('Spots', 'Directions', 'DirectionSpotRels', 'Tours', 'TourSpotRels', 'DirectionsJson');

    public function index()
    {

        /*
         * パラメータの取得
         */
        $direction_id           = $this->request->query('direction_id'); // 経路ID
        $step_id                = $this->request->query('step_id'); // Step
        $destination_spot_id    = $this->request->query('destination_spot_id');
        $lat                    = $this->request->query('lat'); // 現在地の緯度
        $lng                    = $this->request->query('lng'); // 現在地の経度
        $waypoint_onoff         = $this->request->query('waypoints_onoff'); // 経由地の有無

        if ($direction_id == null) {
            // 初回遷移時
            // ルートを決定し保存する
            $direction_id = $this->__findDirection($lat, $lng, $destination_spot_id, $waypoint_onoff);
        } else if ($direction_id == -1) {
            // ListからLikeに遷移していた場合はTop画面へ遷移
            $this->redirect('/');
        } else if ($direction_id != null && $step_id == '') {
            //ゴールSpotからの遷移時はEvalへリダイレクト
            $this->redirect('/eval?direction_id=' . $direction_id);
        }

        // 経路JSONの取得
        $directions = $this->Directions->find('first', array(
            'conditions' => array('id' => $direction_id)
        ));
        // 経路JSONオブジェクトを生成する
        App::uses('DirectionsJson', 'Lib');
        $directions_json = new DirectionsJson($directions['Directions']['directions_json']);

        // 次のstepを取得
        if ($step_id == null) {
            // 初回遷移時
            $step_id = 0;
            $next_step = $directions_json->steps[$step_id];
        } else {
            $next_step = $directions_json->getNextStep($step_id);
        }

        if ($next_step != null) {
            $this->set('step', $next_step);
            $this->set('destination_spot_id', $destination_spot_id);
            $this->set('direction_id', $direction_id);
            $this->set('step_id', $step_id + 1);
            $this->set('previous_step_id', $step_id);

            if ($next_step->is_way_point && !$next_step->is_last) {
                // 経由地に到着した場合

                // Stepに対応するSpotを取得
                $spot = $this->__getStepSpot($directions, $next_step);

                // Spot画面に遷移
                $this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($step_id + 1) . "&spot_id=" . $spot['id'] ."&destination_spot_id=" . $destination_spot_id);
            }

        } else {
            // ゴール画面に遷移
            $this->redirect('/spot?spot_id=' . $destination_spot_id . '&direction_id=' . $direction_id);
        }
    }

    /**
     * Stepに対応するSpotを返す
     *
     * @param $directions
     * @param $step
     * @return null
     */
    private function __getStepSpot($directions, $step)
    {

        foreach ($directions['DirectionSpotRels'] as $row) {
            $spots = $this->Spots->find('first', array(
                'conditions' => array('id' => $row['spot_id'])
            ));

            // 2点間の距離を取得
            $distance = $this->__location_distance(
                $spots['Spots']['lat'], $spots['Spots']['lng'],
                $step->end_location->lat, $step->end_location->lng);

            // 距離が閾値以下であればSpotとみなす
            if ($distance['distance'] <= self::THRESHOLD_M)
            return $spots['Spots'];

        }

        // 基本的に有りえない
        throw new Exception('近傍のスポットが見つかりません.');
    }

    /**
     * 経路検索を行う
     *
     * @param $lat 現在地の緯度
     * @param $lng 現在地の経度
     * @param $destination_spot_id 目的地のSpotId
     * @param $waypoint_onoff 経由するかどうか
     * @return mixed
     */
    private function __findDirection($lat, $lng, $destination_spot_id, $waypoint_onoff)
    {
        /*
         * 経由地の取得
         */
        $spot_ids = $this->__findTourSpotIds($lat, $lng);
        $spots = $this->Spots->find('all', array('conditions' => array(
            'id' => $spot_ids
        )));
        $waypoints = array();
        foreach ($spots as $key => $spot) {
            array_push($waypoints, array(
                'lat' => $spot['Spots']['lat'],
                'lng' => $spot['Spots']['lng']
            ));
        }

        if ($destination_spot_id == null) {
            // Goalが指定されない場合は、最後の経由地を目的地とみなす
            $last = array_pop($waypoints);

            $destination_lat = $last['lat'];
            $destination_lng = $last['lng'];
            $destination = "$destination_lat,$destination_lng";
        } else {
            // Goalが指定された場合は、Spot情報を取得し、ゴールとする
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
        if($waypoint_onoff == 'on'){
		      $params = array(
				  'origin' => "$lat,$lng",
				  'destination' => $destination,
				  'mode' => 'walking',
				  'waypoints' => join("|", $waypointsString)
				  );
	        $this->set('params', $params);
        }
        //経由なし
        else{
          $params = array(
              'origin' => "$lat,$lng",
              'destination' => $destination,
              'mode' => 'walking'
          );
          $this->set('params', $params);
        }

        $url = "http://maps.googleapis.com/maps/api/directions/json?" . http_build_query($params);
        $res = file_get_contents($url);

        //API結果判定 20km以上はなれている場合はlistへリダイレクト
        $res_json = json_decode($res);
        if (str_replace(" km", "", $res_json->routes[0]->legs[0]->distance->text) >= 20) {
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

    /**
     * 2地点の距離を返す
     *
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return array
     */
    private function __location_distance($lat1, $lon1, $lat2, $lon2)
    {
        $lat_average = deg2rad($lat1 + (($lat2 - $lat1) / 2));//２点の緯度の平均
        $lat_difference = deg2rad($lat1 - $lat2);//２点の緯度差
        $lon_difference = deg2rad($lon1 - $lon2);//２点の経度差
        $curvature_radius_tmp = 1 - 0.00669438 * pow(sin($lat_average), 2);
        $meridian_curvature_radius = 6335439.327 / sqrt(pow($curvature_radius_tmp, 3));//子午線曲率半径
        $prime_vertical_circle_curvature_radius = 6378137 / sqrt($curvature_radius_tmp);//卯酉線曲率半径

        //２点間の距離
        $distance = pow($meridian_curvature_radius * $lat_difference, 2) + pow($prime_vertical_circle_curvature_radius * cos($lat_average) * $lon_difference, 2);
        $distance = sqrt($distance);

        $distance_unit = round($distance);
        if ($distance_unit < 1000) {//1000m以下ならメートル表記
            $distance_unit = $distance_unit . "m";
        } else {//1000m以上ならkm表記
            $distance_unit = round($distance_unit / 100);
            $distance_unit = ($distance_unit / 10) . "km";
        }

        //$hoge['distance']で小数点付きの直線距離を返す（メートル）
        //$hoge['distance_unit']で整形された直線距離を返す（1000m以下ならメートルで記述 例：836m ｜ 1000m以下は小数点第一位以上の数をkmで記述 例：2.8km）
        return array("distance" => $distance, "distance_unit" => $distance_unit);
    }

    /**
     * 経由するスポットのリストを返す
     *
     * @param $lat
     * @param $lng
     * @return $spots 経由スポットのリスト
     */
    private function __findTourSpotIds($lat, $lng)
    {
        $spot_ids = null;

        // 現在地付近のツアーの取得
        $tour = $this->__findTour($lat, $lng);

        if ($tour) {
            // ツアーがある場合は、ツアーに含まれるスポットを返す
            $spot_ids = array_map(function($tour_spot_rel){
               return $tour_spot_rel['spot_id'];
            }, $tour['TourSpotRels']);
        } else {
            // ツアーがない場合は、現在地付近のスポットをランダムで返す
            $spots = $this->__getRandomSpots($lat, $lng);

            $spot_ids = array_map(function($spot) {
                return $spot['Spots']['id'];
            }, $spots);
        }

        return $spot_ids;

    }

    /**
     * 現在地付近のツアーを1件ランダムで取得する
     *
     * @param $lat 現在地の緯度
     * @param $lng 現在地の経度
     * @return $spots スポットリスト || null
     */
    private function __findTour($lat, $lng)
    {
        // 検索範囲
        $LAT_WINDOW = 0.025;
        $LNG_WINDOW = 0.025;

        $lat_min = $lat - $LAT_WINDOW;
        $lat_max = $lat + $LAT_WINDOW;
        $lng_min = $lng - $LNG_WINDOW;
        $lng_max = $lng + $LNG_WINDOW;

        $tours = $this->Tours->find('all', array('conditions' => array(
            'lat >=' => $lat_min,
            'lat <' => $lat_max,
            'lng >=' => $lng_min,
            'lng <' => $lng_max
            )));

        if (count($tours) == 0)
            return null;

        // ランダムにキーを抽出
        $random_key = array_rand($tours, 1);

        return $tours[$random_key];
    }

    /**
     * 現在地付近のスポットをランダムで取得する
     *
     * @param $lat
     * @param $lng
     * @return $spots
     */
    private function __getRandomSpots($lat, $lng)
    {
        // スポットの個数
        $SPOTS_NUM = 3;

        // 検索範囲
        $LAT_WINDOW = 0.025;
        $LNG_WINDOW = 0.025;

        $lat_min = $lat - $LAT_WINDOW;
        $lat_max = $lat + $LAT_WINDOW;
        $lng_min = $lng - $LNG_WINDOW;
        $lng_max = $lng + $LNG_WINDOW;

        $spots = $this->Spots->find('all', array('conditions' => array(
            'lat >=' => $lat_min,
            'lat <' => $lat_max,
            'lng >=' => $lng_min,
            'lng <' => $lng_max
        )));

        if (count($spots) == 0)
            throw new Exception('現在地付近のスポットが登録されていません');

        // ランダムにキーを抽出
        $random_keys = array_rand($spots, $SPOTS_NUM);

        // ランダムキーに対応するスポットを返す
        return array_map(function($key) use ($spots) {
            return $spots[$key];
        }, $random_keys);
    }

}
