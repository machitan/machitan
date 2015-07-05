<?php

App::uses('Model', 'Model');

class TourSpotRels extends Model {
	public $name = 'tour_spot_rels';
	public $belongsTo = 'Spot';
}
