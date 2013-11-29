<div class="span3 well">	
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Resource Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span9">
	<?php echo $this->Form->create('ResourceType'); ?>
		<fieldset>
			<legend><?php echo __('Admin Edit Resource Type'); ?></legend>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('name',array('required'));
				echo $this->Form->input('alias',array('required'));
				echo $this->Form->input('extensions',array('required'));
			?>
		</fieldset>
	<?php echo $this->Form->end(array('label'=>__('Save changes'),'class'=>'btn btn-primary')); ?>
</div>