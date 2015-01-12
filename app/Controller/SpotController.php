<?php

class SpotController extends AppController
{

    public $components = array('Session', 'DebugKit.Toolbar');

    public function index()
    {
        $direction_id   = $this->request->query('direction_id');
        $step_id        = $this->request->query('step_id');
        $spot_id        = $this->request->query('spot_id');
        $destination_spot_id        = $this->request->query('destination_spot_id');
        $comment_body = $this->request->query('comment_body');
        
        $this->set('direction_id', $direction_id);
        $this->set('step_id', $step_id);
        $this->set('spot_id', $spot_id);
        $this->set('destination_spot_id', $destination_spot_id);

        $Spot = ClassRegistry::init('Spot');
        $spot_info = $Spot->find('all',
            array('conditions' => array(
                'id' => $spot_id)));
        $this->set('spot_info', $spot_info);

        $Comments = ClassRegistry::init('Comments');
        if($comment_body != null){
            $data = array(
                'spot_id' => $spot_id,
                'user_id' => 0,
                'comment' => $comment_body
            );
            $fields = array('spot_id','user_id','comment');
            if ($Comments->save($data,false,$fields)){
                $this->set('commented',1);
            }else{
                $this->set('commented',0);
            }
        }
        
         $comments = $Comments->find('all',array('conditions' => array('spot_id' => $spot_id)));
         $this->set('comments', $comments);
        
    }

    public function like()
    {
      $direction_id   = $this->request->query('direction_id');
      $step_id        = $this->request->query('step_id');
      $spot_id        = $this->request->query('spot_id');
      $destination_spot_id        = $this->request->query('destination_spot_id');

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
        $this->redirect('/spot?direction_id=' . $direction_id . "&step_id=" . ($step_id) . "&spot_id=" . $spot_id . "&destination_spot_id=" . $destination_spot_id);
      }
      else{
      debug("err");
      }

    }

}
