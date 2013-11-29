<div class="span3 well">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Resource Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;'.__('New Resource Type'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>	
</div>
<div class="span9">
	<h2><?php  echo __('Resource Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($resourceType['ResourceType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($resourceType['ResourceType']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
