<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('ResourceType'); ?>
	<fieldset>
		<legend><?php echo _('Add Resource Type'); ?></legend>
		<?php
		echo $this->Form->input('name', array('required'));
		echo $this->Form->input('alias', array('required'));
		echo $this->Form->input('extensions', array('required'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>