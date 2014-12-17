<?php

class MatomesController extends Controller {

    public $components = array('DebugKit.Toolbar');

    public function index() {
        //トップページのタイトル
        $this->set('title_for_layout', 'トップ');

        //記事の取得
        $Archives = ClassRegistry::init('Archives');
        $archive_datas = $Archives->find('all', array('order' => 'date DESC', 'limit' => 24));
        $this->set('archives', $archive_datas);

        $this->set('date',date("Y-m-d H:i:s"));
        
        //記事数取得
        $this->set('num_of_archives', count($archive_datas));

        //アクセスランキングの表示数
        //$this->set('num_of_rankings_access', 0);

        //カテゴリのアクセスランキング
        //$this->set('num_of_rankings_cat', 0);

        //トレンドワード選択
        $Trends = ClassRegistry::init('Trends');
        $trends_datas = $Trends->find('all', array('limit' => 1, 'order' => 'id DESC'));
        $this->set('trends', $trends_datas);
        
        $date = new DateTime($trends_datas[0]['Trends']['datetime']);
        $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        $this->set('trendsDate', $date->format(DateTime::ISO8601));

        $num_of_search = 4;
        //トレンドワードをもとにした記事の抽出
        $rank1 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank1'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank1', $rank1);

        $rank2 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' => 
                                     '%' . $trends_datas[0]['Trends']['rank2'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank2', $rank2);

        $rank3 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank3'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank3', $rank3);

        $rank4 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank4'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank4', $rank4);

        $rank5 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' => 
                                     '%' . $trends_datas[0]['Trends']['rank5'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank5', $rank5);

        $rank6 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank6'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank6', $rank6);

        $rank7 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank7'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank7', $rank7);

        $rank8 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' => 
                                     '%' . $trends_datas[0]['Trends']['rank8'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank8', $rank8);

        $rank9 = $Archives->find('all',
                                 array('conditions' => array(
                                     'Archives.title LIKE' =>
                                     '%' . $trends_datas[0]['Trends']['rank9'] . '%'),
                                       'order' => 'date DESC',
                                       'limit' => $num_of_search));
        $this->set('rank9', $rank9);

        $rank10 = $Archives->find('all',
                                  array('conditions' => array(
                                      'Archives.title LIKE' =>
                                      '%' . $trends_datas[0]['Trends']['rank10'] . '%'),
                                        'order' => 'date DESC',
                                        'limit' => $num_of_search));
        $this->set('rank10', $rank10);

    }
    
}