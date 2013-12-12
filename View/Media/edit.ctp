<?php echo $this->Form->create('Resource'); ?>
	<fieldset>
		<legend><?php echo __('Edit Resource'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');	
	?>
	</fieldset>
<div class="btn-group">
	<?php
	echo $this->Html->link(__('Cancel'), array('action' => 'files', $resource_group_type_id, $parent_entityid,$entity_alias), array('class' => 'btn'));
	echo $this->Form->submit(__('Send'), array('div' => FALSE, 'class' => 'btn btn-primary')); 
	?>
	
</div>
<?php echo $this->Form->end(); ?>