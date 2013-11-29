<?php

/* /app/View/Helper/ButtonHelper.php */
App::uses('AppHelper', 'View/Helper');

class FrameHelper extends AppHelper {

	public $helpers = array('Html', 'Js');

	public function link($icon = 'icon-film', $id = 'default', $entity = '', $parent_entityid = NULL) {
		$this->scriptload();
		$url = array('plugin' => 'resources', 'controller' => 'Media', 'action' => 'index', $entity, $parent_entityid, 'admin' => FALSE);

		return $this->Html->link('<i class="' . $icon . '"></i>', '#' . $id, array(
				'role' => 'button',
				'class' => 'btn btn-resources',
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

		$str = <<<EOD
<div id="$id" class="modal modal-resources hide fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="modalLabel">$header</h3>
</div>
<div class="modal-body">
<iframe class="resources" src=""></iframe>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>
EOD;

		return $str;
	}

}