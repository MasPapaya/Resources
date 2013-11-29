<?php

//App::uses('AppModel', 'Model');
App::uses('ResourceAppModel', 'Resources.Model');

/**
 * ResourceGroupType Model
 *
 * @property Entity $Entity
 * @property AllowedResourceType $AllowedResourceType
 * @property ResourceGroup $ResourceGroup
 */
class ResourceGroupType extends ResourceAppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
	'entity_id' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
		//'message' => 'Your custom message here',
		//'allowEmpty' => false,
		'required' => true,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'name' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
		//'message' => 'Your custom message here',
		//'allowEmpty' => false,
		'required' => true,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
	'Entity' => array(
	    'className' => 'Entity',
	    'foreignKey' => 'entity_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	)
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
	'AllowedResourceType' => array(
	    'className' => 'AllowedResourceType',
	    'foreignKey' => 'resource_group_type_id',
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
	    'foreignKey' => 'resource_group_type_id',
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
    var $hasAndBelongsToMany = array();

}
