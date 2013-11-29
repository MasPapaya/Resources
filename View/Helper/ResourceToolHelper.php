<?php

//App::uses('ConnectionManager', 'Model');
App::uses('AppHelper', 'View/Helper');

class ResourceToolHelper extends AppHelper {

	public $helpers = array('Html', 'Session', 'Paginator', 'Js' => array('Jquery'), 'Form', 'Time');
	
	
	/**
	 * 
	 * @param array $settings
	 * @param type $title
	 * @param array $options_btn
	 * @return boolean
	 */
	public function OpenWindow($parent_entityid,$title = '<i class="icon-film"></i>' ,array $options_btn = array('class'=>'btn'),$type = 'button'){
		
		/**
		 * consultamos las variables alergadas en la vista
		 */
		$View = $this->_View;
		
		if(is_null($parent_entityid) || is_array($parent_entityid) || !isset($View->viewVars['ResourceEntity']['alias'])){
			return false;
		}
		
		if(isset($options_btn['id'])){
			$id = $options_btn['id'];
		}else{
			$id = rand(0,9999999);
		}	
		
		$id = rand(0,9999999);		
		switch ($type) {
			case 'button':
					$script = '
						$("#link-' . $id . '").bind("click",function(){				
							$("#modal_plugin_resource").removeAttr("style");
							$("#modal_plugin_resource .content_modal_resource").html("<iframe id=\"iframe_resources\" scrolling=\"no\" src=\"'.$this->Html->url(array('plugin'=>'resources','controller'=>'resources','action'=>'index','admin'=>false,$View->viewVars['ResourceEntity']['alias'],$parent_entityid)).'\"></iframe>");
						});
					';
					$this->Js->buffer($script,true);
					return $this->Form->button($title, array_merge_recursive(array('id' => 'link-' . $id), $options_btn));
				break;

			case 'link':
					$script = '
						$("#link-' . $id . '").bind("click",function(event){
							event.preventDefault();
							$("#modal_plugin_resource").removeAttr("style");
							$("#modal_plugin_resource .content_modal_resource").html("<iframe id=\"iframe_resources\" scrolling=\"no\" src=\"'.$this->Html->url(array('plugin'=>'resources','controller'=>'resources','action'=>'index','admin'=>false,$View->viewVars['ResourceEntity']['alias'],$parent_entityid)).'\"></iframe>");
						}).bind("contextmenu", function(e) {
							return false;
						});
					';
					$this->Js->buffer($script,true);
					return $this->Html->link($title,'#',array_merge_recursive(array('id' => 'link-' . $id), $options_btn));
				break;
			default:
					return false;
				break;
		}
	}
	
	public function OpenWindowAdmin($title = '<i class="icon-film"></i>' ,array $options = array('update'=> '#primary-ajax'),$type = 'link'){
		
		if(isset($options['id'])){
			$id = $options['id'];
		}else{
			$id = rand(0,9999999);
		}
		
		switch ($type){
				case 'button':
						$script = '
							$("#link-' . $id . '").bind("click",function(){								
								$("'.$options['update'].'").html("<iframe id=\"iframe_admin_resources\" scrolling=\"no\" src=\"'.$this->Html->url(array('plugin'=>'resources','controller'=>'allowed_types','action'=>'index','admin'=>true)).'\" frameborder=\"0\" ></iframe>");
							});
						';
						$this->Js->buffer($script,true);
						return $this->Form->button($title, array_merge_recursive(array('id' => 'link-' . $id), $options));
					break;

				case 'link':
						$script = '
							$("#link-' . $id . '").bind("click",function(event){
								event.preventDefault();
								$("'.$options['update'].'").html("<iframe id=\"iframe_admin_resources\" /**scrolling=\"no\"**/ src=\"'.$this->Html->url(array('plugin'=>'resources','controller'=>'allowed_types','action'=>'index','admin'=>true)).'\" frameborder=\"0\" ></iframe>");
							}).bind("contextmenu", function(e) {
								return false;
							});
						';
						$this->Js->buffer($script,true);
						return $this->Html->link($title,'#',array_merge_recursive(array('id' => 'link-' . $id), $options));
					break;
				default:
						return false;
					break;
			}
		
	}
	
	/**
	 * con esta funcion cargamos los css y js por defecto sin necesidad de
	 * que el promgrador los tenga que agregar al layout
	 * 
	 * 
	 * @param type $layoutFile
	 */
	public function afterLayout($layoutFile) {
		if (!$this->request->is('requested')) {
			
			$view = $this->_View;
			
			$head = '';
			if (isset($view->viewVars['assets']['js'])) {
				$head .= $this->Html->script($view->viewVars['assets']['js']);
			}
			if (isset($view->viewVars['assets']['css'])) {
				$head .= $this->Html->css($view->viewVars['assets']['css']);
			}
			
			if (preg_match('#</head>#', $view->output)) {
				$view->output = preg_replace('#</head>#', $head . "\n</head>", $view->output, 1);
			}
		}
	}

}