<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('ResourcesAppController', 'Resources.Controller');

class ResourcesController extends FrontAppController {

	var $name = 'Resources';
	
	public function beforeFilter() {
		parent::beforeFilter();
		// if(Configure::read('debug') > 1) {
		// 	$this->Auth->allow();
		// }	   
	}
	
	public function index(){
		$this->set('resources', $this->ResourcesManager->Load());
	}
	
	public function view_group(){
		$this->view = 'index';
		$this->set('resources',$this->ResourcesManager->Load($this->resource_group_type));
	}
		
	public function edit(){
		$this->loadModel('ViewResourceGroup');
		$this->loadModel('ResourceGroupType');
				
		if(isset($this->request->data['id_resource'])){
			$resource = $this->Resource->find('first',array(
				'recursive'	=>-1,
				'conditions'=>array(
					'Resource.id'=>$this->request->data['id_resource'],
				)
			));
			
			if(empty($resource)){
				throw new MethodNotAllowedException();
			}
			
			$ViewResourceGroup = $this->ViewResourceGroup->find('list',array(
				'recursive'	=>	-1,
				'fields'	=>	array('ViewResourceGroup.group_type_id','ViewResourceGroup.group_type_id'),
				'conditions'=>	array(
					'ViewResourceGroup.id'=>$this->request->data['id_resource'],
				)
			));
			
			$this->request->data = array_merge_recursive($resource,  $this->request->data);
						
		}else{
			if(isset($this->request->data['Resource']['id'])){
				if($this->Resource->save($this->request->data,true,array('Resource'=>array('name')))){
					
					/**
					 * aqui eliminamos el recurso de todos los grupos para poder actualizar datos sin inconvenientes
					 */
					$this->ResourcesManager->RemoveFromGroup($this->request->data['Resource']['id']);
					$this->Session->setFlash(__('changes are saved'),'flash/success');
					
					
					/**
					 * aqui verificamos si la entidad presenta varios grupos de recursos (ResourceGroupType) y si 
					 * en el formulario se enviaron varias opciones
					 */
					if(!empty($this->request->data['ResourceGroupType']['id'])){
						$this->ResourcesManager->CheckAndAddToGroup(
							$this->request->data['Resource']['id'],
							$this->request->data['ResourceGroupType']['id'],
							$this->request->data['Resource']['resource_type_id'],
							false 
						);
					}
					
					$this->set('reload_home',true);
				}else{
					$this->Session->setFlash(__('error saving changes'),'flash/error');
				}
				
				$resource = $this->Resource->find('first',array(
					'recursive'=>-1,
					'conditions'=>array(
						'Resource.id'=>$this->request->data['Resource']['id']
					)
				));
				
				$ViewResourceGroup = $this->ViewResourceGroup->find('list',array(
				'recursive'	=>	-1,
				'fields'	=>	array('ViewResourceGroup.group_type_id','ViewResourceGroup.group_type_id'),
				'conditions'=>	array(
					'ViewResourceGroup.id'=>$this->request->data['Resource']['id']
				)
			));
			}
		}
		
		if(isset($this->request->data['resource_group_id'])){
			$this->request->data['Resource']['group_id'] = $this->request->data['resource_group_id'];
			unset($this->request->data['resource_group_id']);
		}
		
		if(empty($this->request->data['Resource']['group_id'])){
			unset($this->request->data['Resource']['group_id']);
		}
		
		if(isset($this->request->data['resource_group_type_id'])){
			$this->request->data['Resource']['group_type_id'] = $this->request->data['resource_group_type_id'];
			unset($this->request->data['resource_group_type_id']);
		}
		
		if(empty($this->request->data['Resource']['group_type_id'])){
			unset($this->request->data['Resource']['group_type_id']);
		}
		
		$this->set(compact('ViewResourceGroup'));
		$this->set(compact('resource'));
	}	
	
	public function manager(){
		
//		if($this->RequestHandler->isAjax()){
//			$this->layout = 'json';
//		}else{
			$this->autoRender = false;
//		}
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');


//		switch ($_SERVER['REQUEST_METHOD']) {
		switch ($this->request->method()) {
			case 'OPTIONS':
				break;
			case 'HEAD':
			case 'GET':
				$this->Upload->get();
				break;
			case 'POST':
				if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
					$this->delete();
				} else {
					$this->post();
				}
				break;
			case 'DELETE':
					$this->delete();
				break;
			default:
				header('HTTP/1.1 405 Method Not Allowed');
				break;
		}
	}
	
	private function post(){		
		$this->loadModel('ResourceGroupType');
		$this->loadModel('ViewResourceGroup');		
		$this->loadModel('ViewResourceSetting');
		
		if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
			return $this->delete();
		}
		$info = array('files');		
		$Resources = $this->ResourcesManager->add();
		
		foreach ($Resources as $Resource){
			if(!isset($Resource->error)){
				
				$Resource->name			 = $this->request->data['Resource']['name'];
				$Resource->delete_url [] = $this->parent_entityid;
				$Resource->delete_url	 = Router::url($Resource->delete_url,true);
				
				$id_resource = $this->ResourcesManager->Save($Resource);

				if($id_resource !== false){					
					$Resource->delete_url .= '&id_resource='.$id_resource;
					/**
					 * aqui miramos si enviaron varios grupos para agregar el archivo
					 */
					if(!empty($this->request->data['ResourceGroup']['resource_group_type_id'])){
						$this->ResourcesManager->CheckAndAddToGroup($id_resource,$this->request->data['ResourceGroup']['resource_group_type_id'],$Resource->bd_type);						
					}
				}else{
					$this->Session->setFlash(__('error saving the file.'),'flash/error');
				}
			}
			
			
			$message_flash = $this->Session->read('Message.flash.message');
			$this->Session->delete('Message.flash');
			if(!is_null($message_flash)){							
				$Resource->status = $message_flash;
			}
			
			$info['files'][] = $Resource;
		}
		
		header('Vary: Accept');
		$json = json_encode($info);
		$redirect = isset($_REQUEST['redirect']) ? stripslashes($_REQUEST['redirect']) : null;
		if ($redirect) {
			header('Location: ' . sprintf($redirect, rawurlencode($json)));
			return;
		}
		
		if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
		
		echo $json;
		
	}	
	
	public function order(){
		if($this->RequestHandler->isPost()){
			$this->loadModel('ResourceGroup');
			$error = false;
			foreach ($this->request->data as $group_type){
				if(!isset($group_type['ResourcesList'])){
					continue;
				}
				
				foreach ($group_type['ResourcesList'] as $position => $ResourceGroup) {
					if(!isset($ResourceGroup['group_id'])){
						continue;
					}
					
					$data = array(
						'ResourceGroup'=>array(
							'id'		=>	$ResourceGroup['group_id'],
							'ordering'	=>	$position,
						)
					);
					if(!$this->ResourceGroup->save($data)){
						$error = true;
					}
				}
			}
			
			if($error){
				$this->Session->setFlash(__('error ordering multimedia resources'),'flash/error');
			}else{
				$this->Session->setFlash(__('Resources have been ordered successfully'),'flash/success');
			}
			
			$this->autoRender = false;
		}else{
			$this->redirect('/',403);
		}		
	}

	public function delete(){
		if($this->RequestHandler->isPost()){
			if(isset($this->request->query['id_resource'])){
				$this->ResourcesManager->Delete((int) $this->request->query['id_resource']);
			}else{
				if(isset($this->request->data['Resources']) && is_array($this->request->data['Resources'])){
					foreach ($this->request->data['Resources'] as  $Resource){
						$this->ResourcesManager->Delete((int) $Resource['id']);
					}
				}else{
					$this->redirect('/',403);
				}
			}			
		}else{
			if($this->RequestHandler->isDelete()){
				$this->ResourcesManager->Delete((int) $this->request->query['id_resource'],false);
			}else{
				throw new MethodNotAllowedException(__('Form not allowed to remove resources!'));
			}
		}		
		$this->Session->setFlash(__('Elimination successful.'),'flash/success');
	}
	
	
}