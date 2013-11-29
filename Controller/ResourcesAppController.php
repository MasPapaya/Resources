<?php

/**
 * Description of ResourcesAppController
 *
 * @author developer3
 */
App::uses('Controller', 'Controller');
App::uses('AppController', 'Controller');

class ResourcesAppController extends AppController {

	//put your code here

	public $components = array(
		'Paginator',
		'RequestHandler',
		'Session',
//		'DebugKit.Toolbar',
//		'Resources.ResourcesHandler',
//		'Security',
//		'Cookie',
	);
	

	public function beforeFilter() {
		parent::beforeFilter();
		// ini_set('memory_limit', '-1');
		if (Configure::read('debug') > 1) {
			$this->Auth->allow();
		}
	}

}
