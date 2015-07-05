<?php

App::uses('Model', 'Model');

class Tours extends Model {
	public $name = 'tours';

	public $hasMany = array(
		'TourSpotRels' => array(
			'className'  => 'TourSpotRels'
		)
	);
}
