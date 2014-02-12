<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('ResourceType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Resource Type'); ?></legend>
		<div class="col-md-3">
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name', array('required'));
			echo $this->Form->input('alias', array('required'));
			echo $this->Form->input('extensions', array('required'));
			?>
		</div>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>