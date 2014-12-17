<?php
class EvalController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

        $direction_id = $this->request->query('direction_id');
        $this->set('direction_id',$direction_id);

        
        $DirectionSpotRels = ClassRegistry::init('DirectionSpotRels');
        $dsr_spots = $DirectionSpotRels->find('all',
                                              array('conditions' => array(
                                                  'direction_id' => $direction_id)));   
        
        $this->set('dsr_spots',$dsr_spots);
        
        $num_of_spots = count($dsr_spots);

        if($num_of_spots > 0){
        
            $Spot = ClassRegistry::init('Spot');
            $spots_gpss = array();
            
            $count = 0;
            while($num_of_spots > $count){
                $spots_gps = $Spot->find('all',
                                array('conditions' => array(
                                                  'id' => $dsr_spots[$count]['DirectionSpotRels']['spot_id'])));
                array_push($spots_gpss, $spots_gps);
                $count++;
            }
            $this->set('spots_gpss',$spots_gpss);
        }

    }
}
