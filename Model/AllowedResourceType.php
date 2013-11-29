<?php

App::uses('ResourceAppModel', 'Resources.Model');
App::uses('ConnectionManager', 'Model');

/**
 * AllowedResourceType Model
 *
 * @property ResourceType $ResourceType
 * @property ResourceGroupType $ResourceGroupType
 */
class AllowedResourceType extends ResourceAppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'id';

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
		'resource_group_type_id' => array(
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
		),
		'ResourceGroupType' => array(
			'className' => 'ResourceGroupType',
			'foreignKey' => 'resource_group_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function ListResourceGroupTypes() {

		$db = ConnectionManager::getDataSource('default');
		$datasource = $db->config['datasource'];

		switch ($datasource) {
			case 'Database/Postgres':
					$this->ResourceGroupType->virtualFields = array(
						'name' => 'Entity.name || \' - \' || ResourceGroupType.name'
					);
					$resourceGroupTypes = $this->ResourceGroupType->find('list', array(
						'fields' => array('name'),
						'joins' => array(
							array(
								'alias' => 'Entity',
								'table' => 'entities',
								//'type' => 'LEFT',
								'type' => 'RIGHT',
								'conditions' => 'ResourceGroupType.entity_id = Entity.id'
							)
						)
					));
				break;
			case 'Database/Mysql':
					$this->ResourceGroupType->virtualFields = array(
						'name' => 'CONCAT(Entity.name," - ",ResourceGroupType.name)'
					);
					$resourceGroupTypes = $this->ResourceGroupType->find('list', array(
						'fields' => array('name'),
						'joins' => array(
							array(
								'alias' => 'Entity',
								'table' => 'entities',
								//'type' => 'LEFT',
								'type' => 'RIGHT',
								'conditions' => '`ResourceGroupType`.`entity_id` = `Entity`.`id`'
							)
						)
					));
				break;

			default:
				$resourceGroupTypes = $this->ResourceGroupType->find('list', array(
					'fields' => array('name'),
				));
				break;
		}
		return $resourceGroupTypes;
	}

}
