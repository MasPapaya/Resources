<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<h2><?php echo __('Allowed Resource Type'); ?></h2>
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