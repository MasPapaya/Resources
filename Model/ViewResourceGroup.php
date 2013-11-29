<?php
App::uses('ResourceAppModel', 'Resources.Model');

/**
 * ViewResourceGroup Model
 *
 * @property Entity $Entity
 */
class ViewResourceGroup extends ResourceAppModel {
	
	var $name = 'ViewResourceGroup';

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
	var $belongsTo = array(		
		'Entity' => array(
			'className' => 'Entity',
			'foreignKey' => 'entity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),		
	);
}
