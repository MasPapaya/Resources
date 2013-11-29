<div class="span3 well">	
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Resource Group Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span9">
	<?php echo $this->Form->create('ResourceGroupType'); ?>
			<fieldset>
					<legend><?php echo __('Add Resource Group Type'); ?></legend>
			<?php
					echo $this->Form->input('entity_id',array('empty'=>__('Select'),'options'=>$entities,'label'=>  __('Resource Entity')));
					echo $this->Form->input('name',array('required','label'=>  __('Name')));
					echo $this->Form->input('alias',array('required','label'=>  __('Alias')));
					echo $this->Form->input('is_single',array('label'=>  __('Is Single')));
			?>
			</fieldset>
		<?php echo $this->Form->end(array('label'=>__('add'),'class'=>'btn btn-primary')); ?>
</div>