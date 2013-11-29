<?php

App::uses('ResourcesAppController', 'Resources.Controller');

class FileUploadsController extends ResourcesAppController {

	function beforeFilter() {
		parent::beforeFilter();
		// if(Configure::read('debug') > 1) {
		// 	$this->Auth->allow();
		// }
	}

	public function index() {
		
	}
	
	public function external(){
		if($this->RequestHandler->isPost()){
			if(!empty($this->request->data['Resource']['name']) && !empty($this->request->data['Resource']['url'])){
				$resource = $this->ResourcesManager->SaveExternalFile($this->request->data['Resource']['url'],$this->request->data['Resource']['name']);
				if($resource !== FALSE){
					$this->Session->setFlash(__('resource is saved'),'flash/success');
					if(!empty($this->request->data['ResourceGroup']['resource_group_type_id'])){
						$this->ResourcesManager->CheckAndAddToGroup($resource->id,$this->request->data['ResourceGroup']['resource_group_type_id'],$resource->bd_type);
					}
					$this->request->data = array();
				}
			}else{
				$this->Session->setFlash(__('incomplete Form'),'flash/warning');
			}
		}
	}
}