<?php

App::uses('ResourceAppModel', 'Resources.Model');

/**
 * ResourceType Model
 *
 * @property AllowedType $AllowedType
 * @property Resource $Resource
 */
class ResourceType extends ResourceAppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $validate = array(
	'alias' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	    'unique' => array(
		'rule' => 'IsUnique',
		'message' => 'alias already exists',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'name' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'extensions' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
	'AllowedType' => array(
	    'className' => 'AllowedType',
	    'foreignKey' => 'resource_type_id',
	    'dependent' => false,
	    'conditions' => '',
	    'fields' => '',
	    'order' => '',
	    'limit' => '',
	    'offset' => '',
	    'exclusive' => '',
	    'finderQuery' => '',
	    'counterQuery' => ''
	),
	'Resource' => array(
	    'className' => 'Resource',
	    'foreignKey' => 'resource_type_id',
	    'dependent' => false,
	    'conditions' => '',
	    'fields' => '',
	    'order' => '',
	    'limit' => '',
	    'offset' => '',
	    'exclusive' => '',
	    'finderQuery' => '',
	    'counterQuery' => ''
	)
    );

}
