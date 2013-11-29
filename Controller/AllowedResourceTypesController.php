<?php

App::uses('ResourcesAppController', 'Resources.Controller');

/**
 * AllowedResourceTypes Controller
 *
 * @property AllowedResourceType $AllowedResourceType
 */
class AllowedResourceTypesController extends ResourcesAppController{

	public function beforeFilter() {
		parent::beforeFilter();
		// if(Configure::read('debug') > 1) {
		// 	$this->Auth->allow();
		// }	   
	}
	

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index(){
		$this->loadModel('Resources.Entity');
		$this->paginate = array(
			'limit' => 10,
				//'order' => 'winner Desc, created Desc',
				//'conditions' => array('Group.delete' => '0000-00-00 00:00:00'),
		);
		$this->AllowedResourceType->recursive = 1;
		$this->set('allowedResourceTypes', $this->paginate());
		
		$this->set('entities', $this->Entity->find('all',array(
			'order'=>array('Entity.name' => 'DESC'),
		)));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->AllowedResourceType->id = $id;
		if (!$this->AllowedResourceType->exists()) {
			throw new NotFoundException(__('Invalid allowed resource type'));
		}
		$this->set('allowedResourceType', $this->AllowedResourceType->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->AllowedResourceType->create();
			if ($this->AllowedResourceType->save($this->request->data)) {
				$this->Session->setFlash(__('The allowed resource type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The allowed resource type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$resourceTypes = $this->AllowedResourceType->ResourceType->find('list');
		$resourceGroupTypes = $this->AllowedResourceType->ListResourceGroupTypes();
		$this->set(compact('resourceTypes', 'resourceGroupTypes'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->AllowedResourceType->id = $id;
		if (!$this->AllowedResourceType->exists()) {
			throw new NotFoundException(__('Invalid allowed resource type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AllowedResourceType->save($this->request->data)) {
				$this->Session->setFlash(__('The allowed resource type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The allowed resource type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->AllowedResourceType->read(null, $id);
		}
		$resourceTypes = $this->AllowedResourceType->ResourceType->find('list');
		$resourceGroupTypes = $this->AllowedResourceType->ListResourceGroupTypes();
		$this->set(compact('resourceTypes', 'resourceGroupTypes'));
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->AllowedResourceType->id = $id;
		if (!$this->AllowedResourceType->exists()) {
			throw new NotFoundException(__('Invalid allowed resource type'));
		}
		if ($this->AllowedResourceType->delete()) {
			$this->Session->setFlash(__('Allowed resource type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Allowed resource type was not deleted', 'flash/error'));
		$this->redirect(array('action' => 'index'));
	}

}
