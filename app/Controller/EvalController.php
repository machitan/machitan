<?php
class EvalController extends AppController {

    public $components = array('DebugKit.Toolbar');

    public function index() {

        $direction_id = $this->request->query('direction_id');
        $this->set('direction_id',$direction_id);

        $Directions = ClassRegistry::init('Directions');
        $direction_json = $Directions->find('all',array('conditions' => array('id' => $direction_id)));
        $d_json = json_decode($direction_json[0]['Directions']['directions_json'],true);
        
        $this->set('direction_json',json_decode($direction_json[0]['Directions']['directions_json'],true));
        $this->set('direction_json_raw',$direction_json[0]['Directions']['directions_json']);
        
        
        $this->set('start_lat',$d_json['routes'][0]['legs'][0]['start_location']['lat']);
        $this->set('start_lng',$d_json['routes'][0]['legs'][0]['start_location']['lng']);
        
        $this->set('end_lat',$d_json['routes'][0]['legs'][0]['end_location']['lat']);
        $this->set('end_lng',$d_json['routes'][0]['legs'][0]['end_location']['lng']);
        
        
        /*
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
        }*/

    }
}
