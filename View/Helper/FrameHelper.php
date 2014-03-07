<?php

/* /app/View/Helper/ButtonHelper.php */
App::uses('AppHelper', 'View/Helper');

class FrameHelper extends AppHelper {

	public $helpers = array('Html', 'Js');

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->loadheader();
	}

	public function loadheader() {
		echo $this->Html->css(array('Resources.media'), array('inline' => FALSE));
		//echo $this->Html->script(array('Schick.scroll/jquery.mousewheel.min', 'Schick.scroll/jquery.mCustomScrollbar', 'Schick.schick_default',), array('inline' => FALSE));
	}

	public function link_files($icon = 'icon-film', $id = 'default', $parent_entityid = NULL, $resource_group_type_alias = NULL, $entity_alias = NULl, $iconB = TRUE) {
		$this->scriptload();
		$url = array('plugin' => 'resources', 'controller' => 'Media', 'action' => 'files_link', $parent_entityid, $resource_group_type_alias, $entity_alias, 'admin' => FALSE);
		if ((bool) $iconB) {
			return $this->Html->link('<i class="' . $icon . '"></i>', '#' . $id, array(
					'role' => 'button',
					'class' => 'btn btn-resources',
					'data-toggle' => 'modal',
					'escape' => FALSE,
					'data-url' => Router::url($url, true)
				));
		} else {
			return $this->Html->link($icon, '#' . $id, array(
					'role' => 'button',
					'class' => 'btn-resources',
					'data-toggle' => 'modal',
					'escape' => FALSE,
					'data-url' => Router::url($url, true)
				));
		}
	}

	public function link($icon = 'icon-film', $id = 'default', $entity = '', $parent_entityid = NULL) {
		$this->scriptload();
		$url = array('plugin' => 'resources', 'controller' => 'Media', 'action' => 'index', $entity, $parent_entityid, 'admin' => FALSE);

		return $this->Html->link('<i class="' . $icon . '"></i>', '#' . $id, array(
				'role' => 'button',
				'class' => 'btn btn-default btn-resources',
				'data-toggle' => 'modal',
				'escape' => FALSE,
				'data-url' => Router::url($url, true)
			));
	}

	public function scriptload($inline = TRUE) {
		$script = <<<EOD
$('.btn-resources').bind('click', function(){	          
	$('iframe.resources').attr('src', $(this).attr('data-url'));
});
EOD;

		return $this->Js->buffer($script, true);
	}

	public function modal($id = 'default', $options = array()) {
		isset($options['title']) ? $header = $options['title'] : $header = __('Title');
		$close = __('Close');
		$str = <<<EOD
				<div id="$id" class="modal modal-resources fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h3 id="modalLabel">$header</h3>
							</div>
							<div class="modal-body">
								<iframe class="resources" src=""></iframe>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">$close</button>
							</div>
						</div>
					</div>
				</div>
EOD;

		return $str;
	}

}