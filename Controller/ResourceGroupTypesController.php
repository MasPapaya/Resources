<?php

App::uses('ResourcesAppController', 'Resources.Controller');

/**
 * ResourceGroupTypes Controller
 *
 * @property ResourceGroupType $ResourceGroupType
 */
class ResourceGroupTypesController extends ResourcesAppController {

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
	public function admin_index() {
		$this->paginate = array(
			'limit' => 20,
				//'order' => 'winner Desc, created Desc',
				//'conditions' => array('Group.delete' => '0000-00-00 00:00:00'),
		);
		$this->ResourceGroupType->recursive = 1;
		$this->set('resourceGroupTypes', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->ResourceGroupType->id = $id;
		if (!$this->ResourceGroupType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource group type'));
		}
		$this->set('resourceGroupType', $this->ResourceGroupType->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ResourceGroupType->create();
			if ($this->ResourceGroupType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources','The resource group type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources','The resource group type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$entities = $this->ResourceGroupType->Entity->find('list');
		$this->set(compact('entities'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->ResourceGroupType->id = $id;
		if (!$this->ResourceGroupType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource group type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ResourceGroupType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources','The resource group type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources','The resource group type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->ResourceGroupType->read(null, $id);
		}
		$entities = $this->ResourceGroupType->Entity->find('list');
		$this->set(compact('entities'));
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
		$this->ResourceGroupType->id = $id;
		if (!$this->ResourceGroupType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource group type'));
		}
		if ($this->ResourceGroupType->delete()) {
			$this->Session->setFlash(__d('resources','Resource group type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('resources','Resource group type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
