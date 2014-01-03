<div class="span3 well">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Allowed Types'), array('action' => 'index', 'admin' => true), array('escape' => FALSE)); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;'.__('New Allowed Type'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>	
</div>
<div class="span8">
	<h2><?php  echo __('Allowed Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($allowedType['AllowedType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Resource Type'); ?></dt>
		<dd>
			<?php echo $allowedType['ResourceType']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mimetype'); ?></dt>
		<dd>
			<?php echo h($allowedType['AllowedType']['mimetype']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
