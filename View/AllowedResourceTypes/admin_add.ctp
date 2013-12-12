<div class="span3 well">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Allowed Resource Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span9">
	<?php echo $this->Form->create('AllowedResourceType'); ?>
	<fieldset>
		<legend><?php echo __('Add Allowed Resource Type'); ?></legend>
		<?php
			echo $this->Form->input('resource_group_type_id', array('empty' => __('Select'),'label'=>__('Resource Group Type')));
			echo $this->Form->input('resource_type_id', array('empty' => __('Select'),'label'=>  __('Resource Type')));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('add'), 'class' => 'btn btn-primary')); ?>
</div>
