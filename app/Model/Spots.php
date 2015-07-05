<?php

App::uses('Model', 'Model');

class Spots extends Model {
	public $name = 'spots';
	var $validation = array(
	  'name' => array (
		'rule' => 'notEmpty' 
	   )
	);
}
