<?php
class LikeController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

      	$direction_id = $this->request->query('direction_id');
	      $step_id = $this->request->query('step_id');

        //Listからの遷移時にスポット登録後Listへリダイレクト
        if($this->request->query('first')){
          $this->set('direction_id',-1);
        }
        //Playからの遷移時にスポット登録後Playへリダイレクト
        else{
          $this->set('direction_id',$direction_id);
        }
        $this->set('step_id',$step_id);
        
    }

    public function add() {
        $Spots = ClassRegistry::init('Spots');
      	$direction_id = $this->request->data['direction_id'];
	      $step_id = $this->request->data['step_id'];
      
        $lat = $this->request->query('lat'); 
        $lng = $this->request->query('lng'); 
       
        $this->set('direction_id',$direction_id);
        $this->set('step_id',$step_id);


        if($lat == 'null' or $lng == 'null'){
            $this->redirect('/like?direction_id=' . $direction_id . "&step_id=" . ($step_id));
        }
        else{
          if ($Spots->save(
            array(
              'Spots' => array(
                'lat' => $lat,
                'lng' => $lng,
                'name' => $this->request->data['name'],
                'description' => $this->request->data['description'],
                'category_id' => $this->request->data['category_id']
              )
            ) 
          )
          )
          {
             $file_name = $Spots->getLastInsertID().".jpg";
             if (is_uploaded_file($_FILES["picture"]["tmp_name"])) {
              if (move_uploaded_file($_FILES["picture"]["tmp_name"], "img/machitan_pic/" . $file_name)) {
               chmod("img/machitan_pic/" . $file_name, 0664);
               echo $_FILES["picture"]["name"] . "をアップロードしました。";
              } else {
               echo "ファイルをアップロードできません。";
              }
             } else {
              echo "ファイルが選択されていません。";
             }
            $this->redirect('/play?direction_id=' . $direction_id . "&step_id=" . ($step_id));
          }
        }
    }
}
