
<div class="btn-group">
	
	<?php echo $this->Html->link(__('Add Resource'), array('action' => 'upload', $resource_group_type_id, $parent_entityid, $entity_alias), array('class' => 'btn btn-primary')); ?>
	<?php
	if (!empty($image)) {
		echo $this->Form->postLink('<i class="glyphicon glyphicon-trash icon-white"></i>', array('action' => 'delete', $image['ViewResource']['id'], $resource_group_type_id, $parent_entityid, $entity_alias), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $image['ViewResource']['id']));
	}
	?>
	<?php
	echo $this->Html->link(__('Cancel'), array('action' => 'index', $entity_alias, $parent_entityid), array('class' => 'btn btn-default'));
	?>	

</div>
<div class="view_image">

	<?php
	if (!empty($image)) {

		if ($image['ViewResource']['type_alias'] == 'document') {
			echo $this->Html->link('<i class="icon-download-alt"></i>', '/files/' . $image['ViewResource']['entity_folder'] . '/' . $image['ViewResource']['filename'], array('escape' => FALSE, 'class' => 'btn btn-default', 'target' => '_blank'));
		} else {
			echo $this->Html->image('/files/' . $image['ViewResource']['entity_folder'] . '/' . $image['ViewResource']['filename'], array());
		}
	}
	?>
</div>