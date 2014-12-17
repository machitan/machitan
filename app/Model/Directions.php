<?php

App::uses('Model', 'Model');

class Directions extends Model {
    public $name = 'directions';
    public $hasMany = array(
       	 'DirectionSpotRels' => array(
            'className'  => 'DirectionSpotRels'
        )
    );
}
