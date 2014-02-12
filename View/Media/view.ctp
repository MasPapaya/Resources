<div class="btn-group">
	<?php echo $this->Html->link(__('Cancel'), array('action' => 'files', $resource_group_type_id, $parent_entityid,$entity_alias), array('class' => 'btn btn-default')); ?>	
</div>
<div class="view_image">

	<?php
	echo $this->Html->image('/files/' . $image['ViewResource']['entity_folder'] . '/' . $image['ViewResource']['filename'], array());
	?>	
	<?php
	if (!empty($prev)) {
		echo $this->Html->link('Prev', array('action' => 'view', $prev['ViewResource']['id'], $resource_group_type_id, $parent_entityid,$count_images), array('class' => 'prev-image'));
	}
	?>
	<?php
	if (!empty($next)) {
		echo $this->Html->link('Next', array('action' => 'view', $next['ViewResource']['id'], $resource_group_type_id, $parent_entityid,$count_images), array('class' => 'next-image'));
	}
	?>
</div>


