<?php

App::uses('ResourcesAppController', 'Resources.Controller');

/**
 * AllowedTypes Controller
 *
 * @property AllowedType $AllowedType
 */
class AllowedTypesController extends ResourcesAppController {

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
			'limit' => '20',
			//'order' => 'winner Desc, created Desc',
			//'conditions' => array('Group.delete' => '0000-00-00 00:00:00'),
		);
		$this->AllowedType->recursive = 1;
		$this->set('allowedTypes', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->AllowedType->id = $id;
		if (!$this->AllowedType->exists()) {
			throw new NotFoundException(__('Invalid allowed type'));
		}
		$this->set('allowedType', $this->AllowedType->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->AllowedType->create();
			if ($this->AllowedType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources', 'The allowed type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources', 'The allowed type could not be saved. Please, try again.'), 'flash/error');
			}
		}
		$resourceTypes = $this->AllowedType->ResourceType->find('list');
		$this->set(compact('resourceTypes'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->AllowedType->id = $id;
		if (!$this->AllowedType->exists()) {
			throw new NotFoundException(__d('resources', 'Invalid allowed type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->AllowedType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources', 'The allowed type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources', 'The allowed type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->AllowedType->read(null, $id);
		}
		$resourceTypes = $this->AllowedType->ResourceType->find('list');
		$this->set(compact('resourceTypes'));
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
		$this->AllowedType->id = $id;
		if (!$this->AllowedType->exists()) {
			throw new NotFoundException(__d('resources', 'Invalid allowed type'));
		}
		if ($this->AllowedType->delete()) {
			$this->Session->setFlash(__d('resources', 'Allowed type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('resources', 'Allowed type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
