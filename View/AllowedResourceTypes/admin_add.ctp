<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('AllowedResourceType'); ?>
	<fieldset>
		<legend><?php echo __('Add Allowed Resource Type'); ?></legend>
		<div class="col-md-3">
			<?php
			echo $this->Form->input('resource_group_type_id', array('empty' => __('Select'), 'label' => __('Resource Group Type')));
			echo $this->Form->input('resource_type_id', array('empty' => __('Select'), 'label' => __('Resource Type')));
			?>
		</div>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>
