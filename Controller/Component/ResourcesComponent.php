<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP ResourcesComponent
 * @author developer01
 */
class ResourcesComponent extends Component {

	public $components = array();
	public $controller;

	public function __construct(ComponentCollection $collection, $settings = array()) {

		$this->controller = $collection->getController();
		$this->controller->loadModel('Resources.Resource');
		$this->controller->loadModel('Resources.ResourceType');
		$this->controller->loadModel('Resources.ResourceGroupType');
	}

	public function saveFromUrl($parent_entityid = NULL, $entity = NULL, $url_filename = NULL, $resourceType = NULl, $resourceGroup, $attribute_type_id = NULL) {
		$this->controller->loadModel('Attributes.Attribute');
		$headers = get_headers($url_filename, 1);
		if (isset($headers['Location'])) {
			$url_filename = $headers['Location'];
		}
		$entity_folder = WWW_ROOT . 'files' . DS . $entity . DS;
		chmod($entity_folder, 0777);
		if (!file_exists($entity_folder)) {
			mkdir($entity_folder, 0777);
		}


		$filename = uniqid(rand(), true) . '.' . implode('.', array_slice(explode('.', $url_filename), -1));

		$file_picture = file_get_contents($url_filename);
		file_put_contents($entity_folder . $filename, $file_picture);

		chmod($entity_folder . $filename, 0777);
		if (file_exists($entity_folder . $filename)) {

			if (is_null($attribute_type_id)) {
				$resourceType_id = $this->controller->ResourceType->find('first', array(
					'recursive' => 0,
					'fields' => array('id'),
					'conditions' => array('ResourceType.alias' => $resourceType,)
					));
				if (!empty($resourceType_id['ResourceType']['id'])) {
					$resourceGroup_id = $this->controller->ResourceGroupType->find('first', array(
						'recursive' => 0,
						'fields' => array('id'),
						'conditions' => array('ResourceGroupType.alias' => $resourceGroup,)
						));
					if (!empty($resourceGroup_id['ResourceGroupType']['id'])) {
						$this->controller->Resource->create(
							array(
								'filename' => $filename,
								'parent_entityid' => $parent_entityid,
								'resource_type_id' => $resourceType_id['ResourceType']['id'],
								'resource_group_type_id' => $resourceGroup_id['ResourceGroupType']['id']
							)
						);
						$this->controller->Resource->save();
					} else {
						throw new NotFoundException(__('No exist alias Resource Group Type') . ' ' . $resourceGroup);
					}
				} else {
					throw new NotFoundException(__('No exist alias Resource Type') . ' ' . $resourceType);
				}
			} else {
				$this->controller->Attribute->create(
					array(
						'value' => $filename,
						'parent_entityid' => $parent_entityid,
						'attribute_type_id' => $attribute_type_id,
					)
				);
				$this->controller->Attribute->save();
			}
		}
	}
}
