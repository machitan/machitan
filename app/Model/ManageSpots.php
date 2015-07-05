<?php

App::uses('Model', 'Model');

class ManageSpots extends Model {
	public $name = 'manage_spots';
	var $validation = array(
	  'name' => array (
		'rule' => 'notEmpty' 
	   )
	);
}
