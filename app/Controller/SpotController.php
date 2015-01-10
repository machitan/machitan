<?php

class SpotController extends AppController
{

    public $components = array('Session', 'DebugKit.Toolbar');

    public function index()
    {
        $direction_id   = $this->request->query('direction_id');
        $step_id        = $this->request->query('step_id');
        $spot_id        = $this->request->query('spot_id');

        // 連続してSpotページを表示しないため、表示済みフラグを立てる
        $this->Session->write('spot_page_flg', true);

        $this->set('direction_id', $direction_id);
        $this->set('step_id', $step_id);
        $this->set('spot_id', $spot_id);

        $Spot = ClassRegistry::init('Spot');
        $spot_info = $Spot->find('all',
            array('conditions' => array(
                'id' => $spot_id)));
        $this->set('spot_info', $spot_info);

    }

    public function like()
    {
      $direction_id   = $this->request->query('direction_id');
      $step_id        = $this->request->query('step_id');
      $spot_id        = $this->request->query('spot_id');

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
      debug($spot_info);
      debug($data);
      if ($Spot->save($data,false,$fields))
      {
        $this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&spot_id=" . $spot_id);
      }
      else{
      debug("err");
      }

    }

}
