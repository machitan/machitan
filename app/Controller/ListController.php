<?php
class ListController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

	$Spot = ClassRegistry::init('Spot');
	$spots = $Spot->find('all');
	$this->set('spots',$spots);
	$count = 0;
	$num_of_spots = count($spots);
    $this->set('num_of_spots',$num_of_spots);

        while($num_of_spots > $count){
                $spot_names = $Spot->find('all',
			Array('fields'=>Array('id','name')));
                $count++;
            }
            $this->set('spot_names',$spot_names);

    }
}
