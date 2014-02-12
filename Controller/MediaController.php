<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('ResourcesAppController', 'Resources.Controller');

class MediaController extends ResourcesAppController {

	var $name = 'Media';
	var $uses = array('Resource');
	public $configurations = array();

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "media";
	}

	public function index($entity_alias = NULL, $parent_entityid = NULL) {
		$this->loadModel('Entity');
		$this->loadModel('ResourceGroupType');
		$entity_id = $this->Entity->find('first', array('fields' => array('Entity.id'), 'conditions' => array('Entity.alias' => $entity_alias)));
		if (!empty($entity_id['Entity']['id'])) {
			$this->set(compact('entity_alias'));
			if (!$this->Entity->exists($entity_id['Entity']['id'])) {
				throw new NotFoundException(__d('resources', 'Invalid Entity'));
			}
			$group_types = $this->ResourceGroupType->find('all', array('conditions' => array('entity_id' => $entity_id['Entity']['id'])));
			$this->set(compact('group_types', 'parent_entityid'));
		} else {
			throw new NotFoundException(__d('resources', 'Invalid Entity'));
		}
	}

	public function files($resource_group_type_id = NULL, $parent_entityid = NULL, $entity_alias = NULL) {
		$this->loadModel('ViewResource');
		$this->loadModel('Resource');
		$this->loadModel('ResourceGroupType');
		$this->paginate = array(
			'ViewResource' => array(
				'order' => 'ordering ASC',
				'limit' => -1,
				'group' => array('ViewResource.id'),
			)
		);

		if (!empty($resource_group_type_id)) {
			$group_type = $this->ResourceGroupType->find('first', array('conditions' => array('ResourceGroupType.id' => $resource_group_type_id)));

			if (!empty($group_type)) {
				if ((bool) $group_type['ResourceGroupType']['is_single']) {
					$resource_id = $this->ViewResource->find('first', array(
						'fields' => array('ViewResource.id'),
						'conditions' => array('deleted' => Configure::read('zero_datetime'), 'group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid)
						));					
					if (!empty($resource_id)) {
						$this->redirect(array('action' => 'view_single', $resource_group_type_id, $parent_entityid, $entity_alias, $resource_id['ViewResource']['id']));
					} else {
						$this->redirect(array('action' => 'view_single', $resource_group_type_id, $parent_entityid, $entity_alias));
					}
				}
			}
		}

		$resources = $this->paginate('ViewResource', array('deleted' => Configure::read('zero_datetime'), 'group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid));
		$this->set(compact('resources', 'resource_group_type_id', 'parent_entityid', 'entity_alias'));
		$this->set('total_resources', $this->ViewResource->find('count', array('conditions' => array('deleted' => Configure::read('zero_datetime'), 'group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid))));
	}

	public function view_single($resource_group_type_id = NULL, $parent_entityid = null, $entity_alias = null, $id = null) {
		$this->loadModel('ViewResource');
		$image = $this->ViewResource->find('first', array('conditions' => array('ViewResource.id' => $id)));

		$this->set(compact('resource_group_type_id', 'parent_entityid', 'image', 'entity_alias'));
	}

	public function files_link($parent_entityid = NULL, $group_type_alias = NULL, $entity_alias = NULL) {
		$this->autoRender = FALSE;
		$this->loadModel('Resources.ResourceGroupType');
		$resourcesGroupType = $this->ResourceGroupType->find('first', array(
			'recursive' => 0,
			'fields' => array('ResourceGroupType.id'),
			'conditions' => array('ResourceGroupType.alias' => $group_type_alias)
			));
		if (!empty($resourcesGroupType)) {
			if (!empty($entity_alias)) {
				$this->redirect(array('action' => 'files', $resourcesGroupType['ResourceGroupType']['id'], $parent_entityid, $entity_alias));
			} else {
				$this->redirect(array('action' => 'files', $resourcesGroupType['ResourceGroupType']['id'], $parent_entityid));
			}
		} else {
			echo 'Group Type Alias No Exist.';
		}
	}

	public function upload($resource_group_type_id = NULL, $parent_entityid = NULL, $entity_alias = NULL) {
		$this->loadModel('ResourceGroupType');
		$this->loadModel('Resources.Resource');
		$group = $this->ResourceGroupType->find('first', array('conditions' => array('ResourceGroupType.id' => $resource_group_type_id)));

		if (!empty($group)) {
			$this->loadModel('ViewResourceSetting');
			$types = $this->ViewResourceSetting->find(
				'all', array(
				'conditions' => array('resource_group_type_id' => $group['ResourceGroupType']['id']),
				'fields' => array('resource_type_name', 'extensions')
				)
			);

			if ($this->request->is('post')) {
				$this->request->data['Resource']['resource_group_type_id'] = $resource_group_type_id;
				$this->request->data['Resource']['parent_entityid'] = $parent_entityid;
				$this->Resource->set($this->request->data);
				if ($this->Resource->validates()) {


					if (isset($this->request->data['Resource']['file'])) {
						$file = $this->request->data['Resource']['file'];


						if (isset($file['tmp_name']) && $file['size'] < 2000000) {

							$this->loadModel('Entity');
							$entity = $this->Entity->find('first', array('conditions' => array('Entity.id' => $group['ResourceGroupType']['entity_id'])));

							$path = WWW_ROOT . 'files' . DS . $entity['Entity']['folder'];
							$filename = uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

							if (!file_exists($path)) {
								$folder = new Folder($path, true, 0755);
							}
							$target = $path . DS . $filename;



							$this->loadModel('ViewAllowedMimetype');

							$resource_type = $this->ViewAllowedMimetype->find('first', array('conditions' => array('id' => $group['ResourceGroupType']['id'], 'mimetype' => $file['type'])));

							if (!empty($resource_type)) {

								if (move_uploaded_file($file['tmp_name'], $target)) {
									chmod($target, 0777);
									$resource_id = $this->Save($filename, $parent_entityid, $this->request->data['Resource']['name'], $resource_type['ViewAllowedMimetype']['resource_type_id'], $resource_group_type_id);
									if ($resource_id) {
										$this->Session->setFlash(__d('resources', 'Save File'), 'flash/success');
									} else {
										$this->Session->setFlash(__d('resources', 'error saving the resource'), 'flash/error');
									}
								} else {
									$this->Session->setFlash(__d('resources', 'Error: move_uploaded_file'), 'flash/error');
								}

								/* NEW CODE */
							} else {
								$this->Session->setFlash(__d('resources', 'File type in not allowed.') . ' ' . $file['type'], 'flash/error');
							}
						} else {
							$this->Session->setFlash(__d('resources', 'Resource not set.'), 'flash/error');
						}
					} else {
						$this->Session->setFlash(__d('resources', 'Resource data not set.'), 'flash/error');
					}
				} else {
					$this->Session->setFlash(__d('resources', 'The resource could not be saved. Please, try again.'), 'flash/warning');
				}
			}

			$this->set(compact('types', 'resource_group_type_id', 'parent_entityid', 'entity_alias'));
		}
	}

	public function Save($filename, $parent_entityid, $resource_name, $resource_type, $resource_group_type_id) {
		$this->loadModel('Resources.Resource');
		/* ========= Ordering ====== */

		$this->Resource->unbindModel(
			array('belongsTo' => array('ResourceGroupType', 'ResourceType'))
		);
		$this->Resource->recursive = -2;
		$data_resources = $this->Resource->find('all', array(
			'order' => 'Resource.ordering ASC',
			'conditions' => array('Resource.deleted ' => Configure::read('zero_datetime')),
			));
		if (count($data_resources) > 0) {
			foreach ($data_resources as $key => $resource) {
				$ordering = $key + 1;
				$this->Resource->query("UPDATE resources SET ordering=" . $ordering . " WHERE id=" . $resource['Resource']['id']);
			}
		}
		/* ========= Ordering ====== */

		$data_resource = array(
			'Resource' => array(
				'resource_type_id' => $resource_type,
				'parent_entityid' => $parent_entityid,
				'resource_group_type_id' => $resource_group_type_id,
				'name' => $resource_name,
				'ordering' => 1,
				'filename' => $filename,
				'created' => date('Y-m-d H:i:s'),
				'deleted' => Configure::read('zero_datetime'),
				'banned' => Configure::read('zero_datetime'),
				'ordering' => 0,
			)
		);

		$this->Resource->create();
		if ($this->Resource->save($data_resource)) {
			return true;
		} else {
			return false;
		}

		return false;
	}

	public function edit($id = null, $resource_group_type_id = NULL, $parent_entityid = NULL, $entity_alias = NULL) {
		$this->loadModel('Resource');
		if (!$this->Resource->exists($id)) {
			throw new NotFoundException(__d('resources', 'Invalid resource'));
		}
		$this->set(compact('resource_group_type_id', 'parent_entityid', 'entity_alias'));
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Resource->save($this->request->data)) {
				$this->Session->setFlash(__d('resources', 'The resource has been saved'), 'flash/success');
				$this->redirect(array('action' => 'files', $resource_group_type_id, $parent_entityid));
			} else {
				$this->Session->setFlash(__d('resources', 'The resource could not be saved. Please, try again.'), 'flash/warning');
			}
		} else {
			$options = array('conditions' => array('Resource.' . $this->Resource->primaryKey => $id));
			$this->request->data = $this->Resource->find('first', $options);
		}
	}

	public function view($id = null, $resource_group_type_id = null, $parent_entityid = null, $entity_alias = null, $count_images = 0) {
		$this->loadModel('ViewResource');
		$image = $this->ViewResource->find('first', array('conditions' => array('ViewResource.id' => $id)));
		$prev = $this->ViewResource->find('first', array(
			'order' => array('ViewResource.id' => 'desc'),
			'fields' => array('id'),
			'conditions' => array('ViewResource.id < ' => $id, 'group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid, 'deleted' => Configure::read('zero_datetime'))
			));


		if ($count_images > 1) {
			if (empty($prev)) {
				$prev = $this->ViewResource->find('first', array(
					'order' => array('ViewResource.id' => 'desc'),
					'fields' => array('id'),
					'conditions' => array('group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid, 'deleted' => Configure::read('zero_datetime'))
					));
			}

			$next = $this->ViewResource->find('first', array(
				'order' => array('ViewResource.id' => 'asc'),
				'fields' => array('id'),
				'conditions' => array('ViewResource.id > ' => $id, 'group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid, 'deleted' => Configure::read('zero_datetime'))
				));

			if (empty($next)) {
				$next = $this->ViewResource->find('first', array(
					'order' => array('ViewResource.id' => 'asc'),
					'fields' => array('id'),
					'conditions' => array('group_type_id' => $resource_group_type_id, 'parent_entityid' => $parent_entityid, 'deleted' => Configure::read('zero_datetime'))
					));
			}
		}

		$this->set(compact('resource_group_type_id', 'parent_entityid', 'image', 'prev', 'next', 'count_images', 'entity_alias'));
	}

	public function delete($id = null, $resource_group_type_id = null, $parent_entityid = null, $entity_alias = NULL) {
		$this->loadModel('Resource');

		$this->Resource->id = $id;

		if (!$this->Resource->exists()) {
			throw new NotFoundException(__d('resources', 'Invalid Resource'));
		}
		if ($this->Resource->updateAll(
				array('Resource.deleted' => "'" . date('Y-m-d H:i:s') . "'"), array('Resource.id' => $id)
		)) {
			$this->Session->setFlash(__d('resources', 'Resource deleted.'), 'flash/success');
		} else {
			$this->Session->setFlash(__d('resources', 'Invalid Resource'), 'flash/warning');
		}

		$this->redirect(array('action' => 'files', $resource_group_type_id, $parent_entityid, $entity_alias));
	}

	public function order($id = null, $order = null, $location = null, $page = null, $resource_group_type_id, $parent_entityid) {
		$this->loadModel('Resource');
		$this->Resource->id = $id;
		if (!$this->Resource->exists()) {
			throw new NotFoundException(__d('resources', 'Invalid Resource'));
		}
		switch ($location) {
			case 'up':
				$this->Resource->updateAll(array('Resource.ordering' => $order), array('Resource.ordering' => ($order - 1)));
				$this->Resource->updateAll(array('Resource.ordering' => ($order - 1)), array('Resource.id' => $id));
				break;

			case 'down':
				$this->Resource->updateAll(array('Resource.ordering' => $order), array('Resource.ordering' => ($order + 1)));
				$this->Resource->updateAll(array('Resource.ordering' => ($order + 1)), array('Resource.id' => $id));
				break;
			default:
				$this->redirect(array('action' => 'files'));
				break;
		}
		$this->redirect(array('action' => 'files', $resource_group_type_id, $parent_entityid));
	}

	public function admin_tiny_upload() {
		$this->layout = 'iframe';




		if ($this->request->is('post') && is_uploaded_file($this->request->data['Resource']['filename']['tmp_name'])) {

			$this->loadModel('Resources.AllowedType');

			$files_allowed = $this->AllowedType->find('count', array(
				'recursive' => 2,
				'conditions' => array(
					'ResourceType.alias' => 'image',
					'AllowedType.mimetype' => $this->request->data['Resource']['filename']['type']
				)));




//
			if ($files_allowed > 0) {
				$ext_file = explode('.', $this->request->data['Resource']['filename']['name']);
				$tiny = WWW_ROOT . 'files' . DS . 'tiny' . DS;
				$filename = uniqid(rand(), true) . '.' . end($ext_file);
				if (!is_dir($tiny)) {
					$directory = new Folder();
					if (!$directory->create($tiny, 0777)) {
						@mkdir($tiny, 0777);
					}
				}
				if (move_uploaded_file($this->request->data['Resource']['filename']['tmp_name'], $tiny . $filename)) {
					$this->set('result', array(
						'file' => $filename,
					));
					exec('chmod 0777 ' . $tiny . $filename);
					$this->Session->setFlash(__('File successfully uploaded'), 'flash/success');
				} else {
					$this->Session->setFlash(__('error uploading the file'), 'flash/error');
				}
			} else {
				$this->Session->setFlash(__('disallowed file, only images.'), 'flash/error');
			}
		}
	}

}
