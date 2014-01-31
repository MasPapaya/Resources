<?php

App::uses('ResourcesAppController', 'Resources.Controller');

/**
 * ResourceTypes Controller
 *
 * @property ResourceType $ResourceType
 */
class ResourceTypesController extends ResourcesAppController {

	public function beforeFilter() {
		parent::beforeFilter();   
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

		$this->ResourceType->recursive = 1;
		$this->set('resourceTypes', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->ResourceType->id = $id;
		if (!$this->ResourceType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource type'));
		}
		$this->set('resourceType', $this->ResourceType->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ResourceType->create();
			if ($this->ResourceType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources','The resource type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources','The resource type could not be saved. Please, try again.'), 'flash/error');
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->ResourceType->id = $id;
		if (!$this->ResourceType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ResourceType->save($this->request->data)) {
				$this->Session->setFlash(__d('resources','The resource type has been saved'), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('resources','The resource type could not be saved. Please, try again.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->ResourceType->read(null, $id);
		}
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
		$this->ResourceType->id = $id;
		if (!$this->ResourceType->exists()) {
			throw new NotFoundException(__d('resources','Invalid resource type'));
		}
		if ($this->ResourceType->delete()) {
			$this->Session->setFlash(__d('resources','Resource type deleted'), 'flash/success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('resources','Resource type was not deleted'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}

}
