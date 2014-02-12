<div class="resource_types cru">
	<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign icon-white"></i>&nbsp;' . __('New Resource Types'), array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>
	<div>
		<h2><?php echo __('Resource Types'); ?></h2>
		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>			
					<th><?php echo $this->Paginator->sort('alias'); ?></th>
					<th><?php echo $this->Paginator->sort('extensions'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($resourceTypes as $resourceType): ?>
					<tr>
						<td><?php echo h($resourceType['ResourceType']['id']); ?>&nbsp;</td>
						<td><?php echo h($resourceType['ResourceType']['name']); ?>&nbsp;</td>
						<td><?php echo h($resourceType['ResourceType']['alias']); ?>&nbsp;</td>
						<td><?php echo h($resourceType['ResourceType']['extensions']); ?>&nbsp;</td>
						<td class="actions">										
							<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $resourceType['ResourceType']['id']), array('escape' => FALSE, 'class' => 'btn btn-default')) ?>															
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>	
		<div class="pagination-centered">   
			<ul class="pagination">
				<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
				<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
			</ul>
		</div>
	</div>
</div>
