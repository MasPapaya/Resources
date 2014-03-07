<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * CakePHP ResourceHelper
 * @author developer3
 */
class ResourceHelper extends AppHelper {

	public $helpers = array('Html', 'Session', 'Paginator', 'Js' => array('Jquery'), 'Form', 'Time');

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function beforeRender($viewFile) {
		
	}

	public function afterRender($viewFile) {
		
	}

	public function beforeLayout($viewLayout) {
		
	}

	public function afterLayout($viewLayout) {
		
	}

	public function UrlWebRoot($filename) {
		if (Validation::url($filename, true)) {
			return $filename;
		} else {
			$path_filename = $this->SearchScanDir(WWW_ROOT . 'files/', $filename);
			if (!empty($path_filename)) {
				$path = explode('/webroot', $path_filename[0]);
				return $path[1];
			} else {
				return false;
			}
		}
	}

	/**
	 * Funcion para traer la url de un recurso principalmente en imagen
	 * 
	 * @param type $filename
	 * @param type $thumbnail
	 * @return type
	 */
	public function Url_resource($filename, $thumbnail = false) {
		$View = $this->_View;
		$options_plugin = $View->viewVars['options_cache'];

		$path_filename = $this->SearchScanDir(WWW_ROOT . 'files/', $filename);
		@$image = getimagesize($path_filename);

		if ($image !== false || $path_filename !== null) {
			if ($thumbnail) {
				if (isset($options_plugin['upload_url'])) {
					return $options_plugin['upload_url'] . '/thumbnail/' . $filename;
				} elseif (file_exists(WWW_ROOT . 'files' . DS . $options_plugin['ResourceEntity']['folder'] . DS . 'thumbnail' . DS . $filename)) {
					return '/files/' . $options_plugin['ResourceEntity']['folder'] . '/thumbnail/' . $filename;
				} elseif (isset($options_plugin['default_image'])) {
					return $options_plugin['default_image'];
				} else {
					return '/resources/img/default.png';
				}
			} else {
				if (isset($options_plugin['upload_url'])) {
					return $options_plugin['upload_url'] . $filename;
				} elseif (file_exists(WWW_ROOT . 'files' . DS . $options_plugin['ResourceEntity']['folder'] . DS . $filename)) {
					return '/files/' . $options_plugin['ResourceEntity']['folder'] . '/' . $filename;
				} elseif (isset($options_plugin['default_image'])) {
					return $options_plugin['default_image'];
				} else {
					return '/resources/img/default.png';
				}
			}
		} else {
			return isset($options_plugin['default_image']) ? $options_plugin['default_image'] : '/resources/img/default.png';
		}
	}

	/**
	 * busca un recurso en un directorio
	 * 
	 * @param type $pathdir
	 * @param type $filename
	 * @return boolean
	 */
	private function SearchScanDir($pathdir, $filename) {
		$folder = new Folder($pathdir);
		return $folder->findRecursive($filename, true);
	}

	/**
	 * enlace con ajax
	 * 
	 * @param type $texto
	 * @param type $url
	 * @param type $class
	 * @param type $update
	 * @return type
	 */
	public function link($texto, $url, $class, $update) {
		return $this->Js->link($texto, $url, array('escape' => FALSE, 'class' => $class, 'update' => $update));
	}

	public function link_button($title, array $url, $update, array $options_btn = null, $scrollto = false) {
		if (empty($url)) {
			return false;
		}
		$id = rand(0, 9999999999);
		if ($scrollto) {
			$script = '
							$("#link_button_' . $id . '").bind("click",function(){				
									$.ajax({
											url:"' . $this->Html->url($url) . '",
											dataType:"html",
											//type:"POST",
											success:function (data, textStatus) {
													$("' . $update . '").html(data);													
													$("body").scrollTo($("' . $update . '").offset().top,500,{axis:"y"});
											}
									});
							});
					';
		} else {
			$script = '
							$("#link_button_' . $id . '").bind("click",function(){				
									$.ajax({
											url:"' . $this->Html->url($url) . '",
											dataType:"html",
											//type:"POST",
											success:function (data, textStatus) {
													$("' . $update . '").html(data);
											}
									});
							});
					';
		}
		$this->Js->buffer($script, true);
		return $this->Form->button($title, array_merge(array('id' => 'link_button_' . $id), $options_btn));
	}

	public function delete($title, array $url, array $options_bnt, array $options_js = null) {
		if (empty($url)) {
			return false;
		}
		$options_js_default = array(
			'update' => '#primary-ajax',
			'confirm' => __('Are you sure you want to delete the record')
		);
		$options_js = array_merge($options_js_default, $options_js);
		$id = rand(0, 9999999999);
		$script = '
			$("#link-' . $id . '").bind("click",function(){				
				if(confirm("' . $options_js['confirm'] . '")){
						$.ajax({
							url:"' . $this->Html->url($url) . '",
							dataType:"html",
							type:"POST",
							success:function (data, textStatus) {
								$("' . $options_js['update'] . '").html(data);
							}
						});
					}
			});
		';

		$this->Js->buffer($script, true);
		return $this->Form->button($title, array_merge(array('id' => 'link-' . $id), $options_bnt));
	}

	public function button($icon, $url, $class, $update) {
		return $this->Js->link('<i class="' . $icon . '"></i>', $url, array('escape' => FALSE, 'class' => 'btn ' . $class, 'update' => $update));
	}

	public function numbers() {
		$nums = $this->Paginator->prev('«', array('tag' => 'li'), null, array('class' => 'prev disabled ', 'tag' => 'li', 'disabledTag' => 'a'));
		$nums .= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'separator' => '', 'currentClass' => 'active'));
		$nums .= $this->Paginator->next('»', array('tag' => 'li'), null, array('class' => 'next disabled', 'tag' => 'li', 'disabledTag' => 'a'));
		return '<div class="pagination"><ul>' . $nums . '</ul></div>';
	}

}
