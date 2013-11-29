<div class="span3 well">	
	<ul class="nav nav-list">
		<li class="nav-header"><?php echo __('Actions'); ?></li>
		<li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>&nbsp;'.__('New Allowed Resource Type'), array('action' => 'add', 'admin' => true), array('escape' => FALSE)); ?></li>
	</ul>
</div>
<div class="span9">	
	<h3><?php echo __('Allowed Resource Types'); ?></h3>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>			
				<th><?php echo $this->Paginator->sort('resource_group_type_id',__('Resource Group Type')); ?></th>
				<th><?php echo $this->Paginator->sort('resource_type_id',__('Resource Type')); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($allowedResourceTypes as $allowedResourceType): ?>
				<tr>
					<td><?php echo h($allowedResourceType['AllowedResourceType']['id']); ?>&nbsp;</td>
					<td>
						<?php
						foreach ($entities as $entity):
							if ($allowedResourceType['ResourceGroupType']['entity_id'] == $entity['Entity']['id']):
								echo '<strong>' . ucwords($entity['Entity']['folder']) . '</strong> - ' . $allowedResourceType['ResourceGroupType']['name'];
								break;
							endif;
						endforeach;
						?>
					</td>
					<td><?php echo h($allowedResourceType['ResourceType']['name']); ?></td>
					<td class="actions">
						<div class="btn-group">
							<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $allowedResourceType['AllowedResourceType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
							<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $allowedResourceType['AllowedResourceType']['id']), array('escape' => FALSE, 'class' => 'btn')) ?>
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