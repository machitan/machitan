<?php

class SpotController extends AppController
{

	public $components = array('Session', 'DebugKit.Toolbar');

	public function index()
	{
		$direction_id = $this->request->query('direction_id');
		$step_id = $this->request->query('step_id');
		$spot_id = $this->request->query('spot_id');
		$destination_spot_id = $this->request->query('destination_spot_id');
		$comment_body = $this->request->query('comment_body');
		$tour_id = $this->request->query('tour_id');
        $user = $this->Auth->user();

		$this->set('direction_id', $direction_id);
		$this->set('step_id', $step_id);
		$this->set('spot_id', $spot_id);
		$this->set('destination_spot_id', $destination_spot_id);
		$this->set('tour_id', $tour_id);

		$Spot = ClassRegistry::init('Spot');
		$spot_info = $Spot->find('all',
			array('conditions' => array(
				'id' => $spot_id)));
		$this->set('spot_info', $spot_info);

		$Comments = ClassRegistry::init('Comments');
		if ($comment_body != null) {
			$data = array(
				'spot_id' => $spot_id,
				'user_id' => 0,
				'comment' => $comment_body
			);
			$fields = array('spot_id', 'user_id', 'comment');
			if ($Comments->save($data, false, $fields)) {
				$this->set('commented', 1);
			} else {
				$this->set('commented', 0);
			}
		}

		$comments = $Comments->find('all', array('conditions' => array('spot_id' => $spot_id)));
		$this->set('comments', $comments);
        
        //経由したスポット履歴登録
        if($user != null){
            $user_spot_history = ClassRegistry::init('UserSpotHistory');
            $user_spot_history->save(
                array(
                    'UserSpotHistory' => array(
                        'user_id' => $user['id'],
                        'spot_id' => $spot_id
                    )
                )
            );
        }
	}

	public function like()
	{
		      if($this->request->is('ajax')) {
            $Spot = ClassRegistry::init('Spot');
            $spot_id = $this->request->data('spot_id');
            $like_count = $this->request->data('like_count');

            $Spot->id = $spot_id;
            $Spot->save(
                array(
                    'Spot' => array(
                        'like_num' => $like_count
                    )
                )
            );
        }
        /*
		$direction_id = $this->request->query('direction_id');
		$step_id = $this->request->query('step_id');
		$spot_id = $this->request->query('spot_id');
		$destination_spot_id = $this->request->query('destination_spot_id');

		$Spot = ClassRegistry::init('Spot');
		$spot_id = $this->request->query('spot_id');
		$spot_info = $Spot->find('all',
			array('conditions' => array(
				'id' => $spot_id)));

		$spot_info[0]['Spot']['like_num']++;
		$data = array(
			'id' => $spot_id,
			'like_num' => $spot_info[0]['Spot']['like_num']
		);
		$fields = array('like_num');
//        $Spot->save($data, false, $fields);
		if ($Spot->save($data, false, $fields)) {
			$this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&spot_id=" . $spot_id . "&destination_spot_id=" . $destination_spot_id);
		} else {
		}*/

	}

	public function add_image(){
		$direction_id = $this->request->data('direction_id');
		$spot_id = $this->request->data('spot_id');
		$step_id = $this->request->data('step_id');
		$destination_spot_id = $this->request->data('destination_spot_id');
		$tour_id = $this->request->data('tour_id');
		if (is_uploaded_file($_FILES["picture"]["tmp_name"])) {
			if (move_uploaded_file($_FILES["picture"]["tmp_name"], "img/machitan_pic/" . $_FILES["picture"]["name"])) {
				$dir_name = $spot_id;
				$file_name = $dir_name . "_" . uniqid()  . ".jpg";
				mkdir("img/machitan_pic/".$dir_name);
				rename("img/machitan_pic/" . $_FILES["picture"]["name"], "img/machitan_pic/". $dir_name . "/" . $file_name);
				chmod("img/machitan_pic/" .$dir_name . "/" . $file_name, 0664);
				echo $_FILES["picture"]["name"] . "をアップロードしました。";
				$this->Session->setFlash('画像が登録されました！', 'default', array('class' => 'alert alert-success'));
				$this->redirect('/spot?spot_id=' . $spot_id . "&direction_id=" . $direction_id . "&step_id=" . $step_id . "&destination_spot_id=" . $destination_spot_id . "&tour_id=" . $tour_id);
			} else {
				//ファイルのアップロードの失敗
				$this->Session->setFlash('ファイルをアップロードできません。', 'default', array('class' => 'alert alert-success'));
				$this->redirect('/spot?spot_id=' . $spot_id . "&direction_id=" . $direction_id . "&step_id=" . $step_id . "&destination_spot_id=" . $destination_spot_id . "&tour_id=" . $tour_id);
			}
		} else {
			//アップロードファイルが未選択
			$this->Session->setFlash('ファイルが選択されていません。', 'default', array('class' => 'alert alert-success'));
			$this->redirect('/spot?spot_id=' . $spot_id . "&direction_id=" . $direction_id . "&step_id=" . $step_id . "&destination_spot_id=" . $destination_spot_id . "&tour_id=" . $tour_id);
		}
	}
}
