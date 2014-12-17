<?php
class LikeController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

	$direction_id = $this->request->query('direction_id');
	$step_id = $this->request->query('step_id');
        
        $this->set('direction_id',$direction_id);
        $this->set('step_id',$step_id);
        
    }

}
