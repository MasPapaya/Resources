<?php

App::uses('AppModel', 'Model');

/**
 * ViewResource Model
 *
 * @property ResourceType $ResourceType
 * @property Entity $Entity
 * @property GroupType $GroupType
 */
class ViewResource extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
//		'ResourceType' => array(
//			'className' => 'Resources.ResourceType',
//			'foreignKey' => 'resource_type_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'Entity' => array(
//			'className' => 'Entity',
//			'foreignKey' => 'entity_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'GroupType' => array(
//			'className' => 'ResourceGroupType',
//			'foreignKey' => 'group_type_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

}
