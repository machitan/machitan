<?php

class WordsController extends AppController
{

    public $components = array('DebugKit.Toolbar');

    public function index()
    {

        //検索対象のワード
        $target_word = $this->request->query['target_word'];
        $this->set('target_word', $target_word);

        //トレンドワードをもとにした記事の抽出
        $Archives = ClassRegistry::init('Archives');
        $searched_archives = $Archives->find('all',
            array('conditions' => array(
                'Archives.title LIKE' =>
                    '%' . $target_word . '%'),
                'order' => 'id DESC',
                'limit' => 50
            ));
        $this->set('searched_archives', $searched_archives);

    }

}