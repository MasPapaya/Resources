<?php
App::uses('ResourceAppModel', 'Resources.Model');
/**
 * AllowedType Model
 *
 * @property ResourceType $ResourceType
 */
class AllowedType extends ResourceAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'mimetype';


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'resource_type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mimetype' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ResourceType' => array(
			'className' => 'ResourceType',
			'foreignKey' => 'resource_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
