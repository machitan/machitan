<?php

class LikeController extends AppController
{

	public $components = array('Session', 'DebugKit.Toolbar');

	public function index()
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

	public function add()
	{
		$Spots = ClassRegistry::init('Spots');
		$direction_id = $this->request->data['direction_id'];
		$step_id = $this->request->data['step_id'];
		$destination_spot_id = $this->request->data['destination_spot_id'];

		$lat = $this->request->query('lat');
		$lng = $this->request->query('lng');

		$this->set('direction_id', $direction_id);
		$this->set('step_id', $step_id);
		$this->set('destination_spot_id', $destination_spot_id);

		if ($lat == 'null' or $lng == 'null') {
			//位置情報取得に失敗
			$this->Session->setFlash('現在地が取得できません。', 'default', array('class' => 'alert alert-success'));
			$this->redirect('/like?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
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
								'manage_flag' => 0
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
						$this->redirect('/play?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);

					}
					
				} else {
					//ファイルのアップロードの失敗
					$this->Session->setFlash('ファイルをアップロードできません。', 'default', array('class' => 'alert alert-success'));
					$this->redirect('/like?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
				}
			} else {
				//アップロードファイルが未選択
				$this->Session->setFlash('ファイルが選択されていません。', 'default', array('class' => 'alert alert-success'));
				$this->redirect('/like?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&destination_spot_id=" . $destination_spot_id);
			}
		}
	}
}
