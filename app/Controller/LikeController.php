<?php
class LikeController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

	$direction_id = $this->request->query('direction_id');
	$step_id = $this->request->query('step_id');
        
        $this->set('direction_id',$direction_id);
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
                'description' => $this->request->data['description']
              )
            ) 
          )
          )
          {
            $this->redirect('/play?direction_id=' . $direction_id . "&step_id=" . ($step_id));
          }
        }
    }
}
