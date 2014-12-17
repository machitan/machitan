<?php
class SpotController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {
	   $direction_id = $this->request->query('direction_id');
	   $step_id = $this->request->query('step_id');
       $spot_id = $this->request->query('spot_id'); 

	   $this->set('direction_id', $direction_id);
	   $this->set('step_id', $step_id);
       $this->set('spot_id', $spot_id);
        
       $Spot = ClassRegistry::init('Spot');
       $spot_info = $Spot->find('all', 
                                array('conditions' => array(
                                                  'id' => $spot_id)));
        $this->set('spot_info',$spot_info);
        
    }

}
