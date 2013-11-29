<?php

App::uses('Component', 'Controller');

/**
 * CakePHP CoreResourcesComponent
 * @author developer3
 */
class ResourceGroupComponent extends Component {

	public $components = array(
		'Paginator',
		'Session'
	);

	/**
	 * almacenamiento de informocion requerida para poder operar el componente
	 *
	 * @var type 
	 */
	public $settings;

	/**
	 * controlador que hace la solicitud
	 *
	 * @var type 
	 */
	public $Controller;

	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->settings = $settings;
		$this->Controller = $collection->getController();
	}

	public function initialize(Controller $controller) {
		
	}

	public function startup(Controller $controller) {

	}

	public function beforeRender(Controller $controller) {
		
	}

	public function shutDown(Controller $controller) {
		
	}


	public function group($data = null){
		if($data != null){
			$newdata = array();
			foreach ($data as $item) {
				if(isset($item['ViewResource']) && is_array($item['ViewResource'])){
					$groups = array();
					foreach($item['ViewResource'] as $resource){
						if(isset($resource['ordering']) && isset($resource['group_type_alias'])){
							$groups[$resource['group_type_alias']][] = $resource;
						}
					}
					$item['ViewResourceGroups'] = $groups;
				}
				$newdata[] = $item;
			}
			$data = $newdata;
		}
		return $data;
	}

}