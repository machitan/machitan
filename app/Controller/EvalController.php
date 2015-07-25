<?php

class EvalController extends AppController
{

	public $components = array('DebugKit.Toolbar');
	public $uses = array('Directions','DirectionsJson');

	public function index()
	{

		$direction_id = $this->request->query('direction_id');
		$this->set('direction_id', $direction_id);
		// 経路JSONの取得

		$directions = $this->Directions->find('first', array(
			'conditions' => array('id' => $direction_id)
		));
		// 経路JSONのオブジェクトを作成する
		App::uses('DirectionsJson','Lib');
		$directions_json = new DirectionsJson($directions['Directions']['directions_json']);
        
        // ユーザ情報取得
        $user = $this->Auth->user();

		$Directions = ClassRegistry::init('Directions');
		$direction_json = $Directions->find('all', array('conditions' => array('id' => $direction_id)));
		$d_json = json_decode($direction_json[0]['Directions']['directions_json'], true);

		$this->set('direction_json', json_decode($direction_json[0]['Directions']['directions_json'], true));
		$this->set('direction_json_raw', $direction_json[0]['Directions']['directions_json']);
		$this->set('total_distance',$directions_json->total_distance);

		//プレイ時間に応じたスコア減点計算
		$time = time() - $direction_json[0]['Directions']['start_time'];
		$total_time = date('s',$time);
		$total_time += date('i',$time)*60;
		$sub_time = $d_json['routes'][0]['legs'][0]['duration']['value'] - $total_time;
		if($sub_time < 0){
			$direction_json[0]['Directions']['score'] += floor($sub_time/10);
		}
		if($direction_json[0]['Directions']['score'] < 0){
			$this->set('direction_score', 0);
		}
		else{
			$this->set('direction_score', $direction_json[0]['Directions']['score']);
		}

		$this->set('start_lat', $d_json['routes'][0]['legs'][0]['start_location']['lat']);
		$this->set('start_lng', $d_json['routes'][0]['legs'][0]['start_location']['lng']);


		$num_of_spots = count($d_json['routes'][0]['legs']);

		$waypoints = array();
		for ($i = 1; $i < $num_of_spots; $i++) {
			array_push($waypoints, $d_json['routes'][0]['legs'][$i]['start_location']['lat'] . "," . $d_json['routes'][0]['legs'][$i]['start_location']['lng']);
		}
		$this->set('waypoints', $waypoints);
		$this->set('num_of_waypoints', count($waypoints));

		$this->set('end_lat', $d_json['routes'][0]['legs'][$num_of_spots - 1]['end_location']['lat']);
		$this->set('end_lng', $d_json['routes'][0]['legs'][$num_of_spots - 1]['end_location']['lng']);

		$tour_id = $this->request->query('tour_id');
		if ($tour_id != null) {
			//ツアーのプレイ回数をインクリメントする
			$Tour = ClassRegistry::init('Tour');
			$tour_info = $Tour->find('all', array(
				'conditions' => array('id' => $tour_id),
				'fields' => array('played_finished','played')
			));

			$tour_played_finished_count = $tour_info[0]['Tour']['played_finished'] + 1;
			$tour_played_count = $tour_info[0]['Tour']['played'];
			if($tour_played_count != 0){
				$tour_finised_rate = $tour_played_finished_count/$tour_played_count * 100;
			}else{
				$tour_finised_rate = 0;
			}

			$Tour->id = $tour_id;
			$Tour->save(
					array(
							'Tour' => array(
									'played_finished' => $tour_played_finished_count,
									'finished_rate' => $tour_finised_rate
							)
					)
			);
            

		}
        
        //ユーザのゲームプレイ履歴更新
        if($user != null){
            //実行したプレイ履歴登録
            $user_game_history = ClassRegistry::init('UserGameHistory');
            $score = $direction_json[0]['Directions']['score'];
            if($score < 0){
                $score = 0;
            }
            $user_game_history->save(
                    array(
                        'UserGameHistory' => array(
                            'user_id' => $user['id'],
                            'direction_id' => $direction_id,
                            'tour_id' => $tour_id,
                            'score' => $score,
                            'distance' => $directions_json->total_distance
                            )
                        )
                    );
        }

	/*
        $DirectionSpotRels = ClassRegistry::init('DirectionSpotRels');
        $dsr_spots = $DirectionSpotRels->find('all',
                                              array('conditions' => array(
                                                  'direction_id' => $direction_id)));

        $this->set('dsr_spots',$dsr_spots);

        $num_of_spots = count($dsr_spots);

        if($num_of_spots > 0){

            $Spot = ClassRegistry::init('Spot');
            $spots_gpss = array();

            $count = 0;
            while($num_of_spots > $count){
                $spots_gps = $Spot->find('all',
                                array('conditions' => array(
                                                  'id' => $dsr_spots[$count]['DirectionSpotRels']['spot_id'])));
                array_push($spots_gpss, $spots_gps);
                $count++;
            }
            $this->set('spots_gpss',$spots_gpss);
        }*/

	}
}
