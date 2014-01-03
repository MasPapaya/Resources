<div class="cru">
	<div class="btn-options">
		<?php echo $this->Html->link('<i class="icon-list icon-white"></i>&nbsp;' . __('Back to List'), array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>	
	</div>
	<h2><?php echo __('Resource Group Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($resourceGroupType['ResourceGroupType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entity'); ?></dt>
		<dd>
			<?php echo $resourceGroupType['Entity']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($resourceGroupType['ResourceGroupType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Single'); ?></dt>
		<dd>
			<?php echo h($resourceGroupType['ResourceGroupType']['is_single']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
