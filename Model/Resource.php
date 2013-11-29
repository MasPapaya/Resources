<?php

App::uses('ResourceAppModel', 'Resources.Model');

class Resource extends ResourceAppModel {

    public $name = 'Resource';
    public $displayField = 'name';
    public $validate = array(
	'resource_type_id' => array(
	    'numeric' => array(
		'rule' => array('numeric'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'resource_group_type_id' => array(
	    'numeric' => array(
		'rule' => array('numeric'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'parent_entityid' => array(
	    'numeric' => array(
		'rule' => array('numeric'),
	    //'message' => 'Your custom message here',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
	'name' => array(
	    'notempty' => array(
		'rule' => array('notempty'),
		'message' => 'not empty',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	    'is_single' => array(
		'rule' => array('is_single'),
		'message' => 'Resource exist',
	    //'allowEmpty' => false,
	    //'required' => false,
	    //'last' => false, // Stop validation after this rule
	    //'on' => 'create', // Limit validation to 'create' or 'update' operations
	    ),
	),
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    public $belongsTo = array(
	'ResourceType' => array(
	    'className' => 'ResourceType',
	    'foreignKey' => 'resource_type_id',
	    'conditions' => '',
	    'fields' => '',
	    'order' => ''
	),
	'ResourceGroupType' => array(
	    'className' => 'ResourceGroupType',
	    'foreignKey' => 'resource_id',
	    'dependent' => false,
	    'conditions' => '',
	    'fields' => '',
	    'order' => '',
	)
    );
    public $hasMany = array();

    public function is_single() {

	$is_multiple = $this->ResourceGroupType->find('first', array(
	    'conditions' => array('ResourceGroupType.id' => $this->data['Resource']['resource_group_type_id']),
	));
	if ($is_multiple['ResourceGroupType']['is_single'] == true) {
	    $this->unbindModel(
		    array('belongsTo' => array('ResourceGroupType'))
	    );
	    $this->recursive = -2;
	    $exist_resource = $this->find('count', array(
		'conditions' => array(
		    'Resource.parent_entityid' => $this->data['Resource']['parent_entityid'],
		    'Resource.resource_group_type_id' => $this->data['Resource']['resource_group_type_id'],
		    'Resource.deleted' => Configure::read('zero_datetime'),
		),
	    ));
	    if ($exist_resource > 0) {
		return false;
	    } else {
		return true;
	    }
	} else {
	    return true;
	}

	return false;
    }

}