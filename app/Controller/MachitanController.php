<?php


App::uses('Controller', 'Controller');


class MachitanController extends Controller
{

	public $components = array('DebugKit.Toolbar');

	public function index()
	{
		$this->set('geo_info', $this->request->query('geo_info'));
	}

}
