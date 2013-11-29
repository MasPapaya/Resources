<?php
App::uses('ResourceAppModel', 'Resources.Model');
/**
 * ResourceGroup Model
 *
 * @property ResourceGroupType $ResourceGroupType
 * @property Resource $Resource
 */
class ResourceGroup extends ResourceAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ResourceGroupType' => array(
			'className' => 'ResourceGroupType',
			'foreignKey' => 'resource_group_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Resource' => array(
			'className' => 'Resource',
			'foreignKey' => 'resource_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
}
