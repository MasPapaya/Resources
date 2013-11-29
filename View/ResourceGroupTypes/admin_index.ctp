<div class="span3 well">
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;' . __('New Resource Group Type'), array('action' => 'add', 'admin' => true),  array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span9">
	<h2><?php echo __('Resource Group Types'); ?></h2>
	<table  class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('entity_id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('alias'); ?></th>
				<th><?php echo $this->Paginator->sort('is_single', __('Is Single')); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($resourceGroupTypes as $resourceGroupType): ?>
				<tr>
					<td><?php echo h($resourceGroupType['ResourceGroupType']['id']); ?>&nbsp;</td>
					<td><?php echo h($resourceGroupType['Entity']['name']); ?></td>
					<td><?php echo h($resourceGroupType['ResourceGroupType']['name']); ?>&nbsp;</td>
					<td><?php echo h($resourceGroupType['ResourceGroupType']['alias']); ?>&nbsp;</td>
					<td><?php echo h($resourceGroupType['ResourceGroupType']['is_single']); ?>&nbsp;</td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $resourceGroupType['ResourceGroupType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
							<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $resourceGroupType['ResourceGroupType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>	
	 <div class="pagination pagination-centered">
    	<p>
			<?php
			echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
			?>
	    </p>
		<ul>
			<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
		</ul>
	</div>
</div>