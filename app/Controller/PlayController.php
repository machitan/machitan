<?php

class PlayController extends Controller
{

    public $components = array('Session', 'DebugKit.Toolbar');
    public $uses = array('Spots', 'Directions', 'DirectionSpotRels', 'Tours', 'TourSpotRels');

    public function index()
    {

        /*
         * パラメータの取得
         */
        $direction_id           = $this->request->query('direction_id'); // 経路ID
        $step_id                = $this->request->query('step_id'); // Step
        $destination_spot_id    = $this->request->query('spot_id');
        $lat                    = $this->request->query('lat'); // 現在地の緯度
        $lng                    = $this->request->query('lng'); // 現在地の経度

        // スポットページからの遷移かどうかを取得
        $spot_page_flg = $this->Session->read('spot_page_flg');
        $this->Session->write('spot_page_flg', false); // フラグを下げる

        if ($direction_id == null) {
            // 初回遷移時
            // ルートを決定し保存する
            $direction_id = $this->__findDirection($lat, $lng, $destination_spot_id);
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
        // 経路JSONのデコード
        $directions_json = json_decode($directions['Directions']['directions_json']);

        $stepAll = array();
        foreach ($directions_json->routes[0]->legs as $l) {
            foreach ($l->steps as $i) {
                array_push($stepAll, $i);
            }
        }

        // ルート検索の結果情報を撮りたい場合は、こんな感じ
        //$total_distance = $legs->distance->text;
        //$total_duration = $legs->duration->text;

        // 次のstepを存在チェックして取得
        $next_step_id = ($step_id == null) ? 0 : $step_id + 1;
        $step = (count($stepAll) > $next_step_id)
            ? $stepAll[$next_step_id] : null;

        if ($step != null) {
            $this->set('step', $step);
            $this->set('destination_spot_id', $destination_spot_id);
            $this->set('direction_id', $direction_id);
            $this->set('step_id', $next_step_id);
            $this->set('previous_step_id', $next_step_id - 1);

            // 現在Spotがstepかどうかチェック！！
            $stepSpot = $this->__getStepSpot($directions, $step);
            if ($stepSpot != null && !$spot_page_flg) {

                // Spot画面に遷移 (直前がスポットページの場合は、遷移しない)
                $this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($next_step_id) . "&spot_id=" . $stepSpot['id']);
            }

        } else {
            // ゴール画面に遷移
            $this->redirect('/spot?spot_id=' . $destination_spot_id . '&direction_id=' . $direction_id);
        }
    }

    // 現在Spotがstepかどうかチェック！！
    private function __getStepSpot($directions, $step)
    {

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

    /**
     * @param $lat 現在地の緯度
     * @param $lng 現在地の経度
     * @param $destination_spot_id 目的地のSpotId
     * @return mixed
     */
    private function __findDirection($lat, $lng, $destination_spot_id)
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
        $destination_lat = $waypoints[count($waypoints) - 1]['lat'];
        $destination_lng = $waypoints[count($waypoints) - 1]['lng'];
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

        $waypoints_test = array();
        array_push($waypoints_test, "35.5757,139.66");

        // Google API から経路取得
        //経由あり
		$params = array(
				'origin' => "$lat,$lng",
				'destination' => $destination,
				'mode' => 'walking',
				'waypoints' => join("|", $waypointsString)
				);
	        $this->set('params', $params);
        //経由なし
//        $params = array(
//            'origin' => "$lat,$lng",
//            'destination' => $destination,
//            'mode' => 'walking'
//        );
//        $this->set('params', $params);

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
