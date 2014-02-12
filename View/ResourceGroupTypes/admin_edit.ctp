<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<?php echo $this->Form->create('ResourceGroupType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Resource Group Type'); ?></legend>
		<div class="col-md-3">
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('entity_id', array('empty' => __('Select'), 'options' => $entities, 'label' => __('Resource Entity')));
			echo $this->Form->input('name', array('required', 'label' => __('Name')));
			echo $this->Form->input('alias', array('required', 'label' => __('Alias')));
			echo $this->Form->input('is_single', array('label' => __('Is Single')));
			?>
		</div>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('Save'), 'class' => 'btn btn-primary')); ?>
</div>