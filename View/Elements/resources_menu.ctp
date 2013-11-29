<?php if (isset($authuser['group_id']) && $authuser['group_id'] == '1'): ?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-film"></i>&nbsp;<?php echo __('Resources') ?><b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><?php echo $this->Html->link(__('Allowed Resource Types'), array('controller' => 'AllowedResourceTypes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'resources')); ?></li>
			<li><?php echo $this->Html->link(__('Allowed Types'), array('controller' => 'AllowedTypes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'resources')); ?></li>
			<li><?php echo $this->Html->link(__('Resource Group Types'), array('controller' => 'ResourceGroupTypes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'resources')); ?></li>
			<li><?php echo $this->Html->link(__('Resource Types'), array('controller' => 'ResourceTypes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'resources')); ?></li>
		</ul>
	</li>
<?php endif; ?>