<div class="span3 well">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Allowed Resource Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;'.__('New Allowed Resource Type'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>	
</div>
<div class="span9">
	<h2><?php  echo __('Allowed Resource Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($allowedResourceType['AllowedResourceType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Resource Type'); ?></dt>
		<dd>
			<?php echo $allowedResourceType['ResourceType']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Resource Group Type'); ?></dt>
		<dd>
			<?php echo $allowedResourceType['ResourceGroupType']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>