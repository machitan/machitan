<?php
class ListController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

    //Getパラメータから現在地情報を取得
    $lat = $this->request->query('lat');
    $lng = $this->request->query('lng');

    //現在地が取得てきていなければ、トップにリダイレクト
    if ($lat == 'null' || $lng == 'null') {
        $this->redirect('/?geo_info=0');
    }
        
    //現在地情報をViewに渡す
    $this->set('lat',$lat);
    $this->set('lng',$lng);
         
    //近郊とする緯度経度の範囲
    $lat_diff = 0.025;
    $lng_diff = 0.025;
        
    //現在地をもとに近郊のスポットのみDBから検索
	$Spot = ClassRegistry::init('Spot');
	$spots = $Spot->find('all',
                        array(
                        'fields'=>Array('id','name','category_id'),
                        'conditions' => array(
                            'and' => array(
                                array('lat BETWEEN ? AND ?' => 
                                      array($lat-$lat_diff, $lat+$lat_diff)),
                                array('lng BETWEEN ? AND ?' =>
                                      array($lng-$lng_diff, $lng+$lng_diff))
                                )
                            )
                        ));
    //検索結果を渡す
	$this->set('spots',$spots);
        
    //検索したスポットの数を取得
    $num_of_spots = count($spots);
    $this->set('num_of_spots',$num_of_spots);
    
    //とりあえずぶらり用にランダムにspot_idを指定する
    $this->set('rand_spot_id',$spots[rand(0,$num_of_spots-1)]['Spot']['id']);
    }
}
