<?php

/*
 * jQuery File Upload Plugin PHP Class 5.9.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ResourcesHandlerComponent extends Component {
    /*
     * $options = array()
     * Avaliable Options:
     *
     * 
     * $options => array(
     *   'upload_dir' => 'files/{your-new-upload-dir}' // Default 'files/'
     * )
     */

    public $options;

    /**
     * * Controller instance reference
     *
     * @var type 
     */
    public $controller;

    /**
     * gestiona la utilidad de carpetas de cakephp
     * 
     * @param ComponentCollection $collection
     * @param type $options
     */
    public $directory;

    /**
     * contiene informacion de la entidad actual
     *
     * @var type 
     */
    public $ResourceEntity;
    public $settings;

    public function __construct(ComponentCollection $collection, $options = array()) {

	if (isset($options['Entity'])) {
	    $this->ResourceEntity = $options['Entity'];
	    unset($options['Entity']);
	    /**
	     * cargamos la entidad
	     */
	    $ResourceEntity = ClassRegistry::init('Configurations.Entity');
			$this->ViewResourceGroup = ClassRegistry::init('Resources.ViewResourceGroup');
	    $this->settings = $ResourceEntity->find('first', array(
		'recursive' => -1,
		'conditions' => array(
		    'Entity.alias' => $this->ResourceEntity['alias']
		)
	    ));
	    unset($ResourceEntity);
	}
    }

    public function startup(Controller $controller) {
//	$this->ViewResourceGroup = ClassRegistry::init('Resources.ViewResourceGroup');
    }

    public function Read($parent_entityid, $type = 'first', $query = array()) {
	$options_query = array_merge_recursive(array(
	    //'recursive'	=> -1,
	    //'limit'		=> 20,
	    'order' => array(
		'ViewResourceGroup.group_type_id' => 'ASC',
//				'ViewResourceGroup.ordering' => 'ASC',
	    ),
	    'conditions' => array(
		'ViewResourceGroup.entity_id' => $this->settings['Entity']['id'],
		'ViewResourceGroup.parent_entityid' => $parent_entityid,
	    )
	));
	return $this->ViewResourceGroup->find($type, $options_query);
    }
    

  
}