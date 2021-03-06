<legend><?php echo __('Resource List'); ?> 
	<div class="btn-group">
		<?php echo $this->Html->link(__('Add Resource'), array('action' => 'upload', $resource_group_type_id, $parent_entityid,$entity_alias), array('class' => 'btn btn-primary')); ?>
		<?php if (!empty($entity_alias)): ?>
			<?php echo $this->Html->link(__('Cancel'), array('action' => 'index', $entity_alias, $parent_entityid), array('class' => 'btn btn-default')); ?>
		<?php endif; ?>
	</div>
</legend>
<div>

</div>
<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th><?php echo h('id'); ?></th>
			<th><?php echo __('name'); ?></th>
			<th><?php echo __('created'); ?></th>
			<th><?php echo __('ordering'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($resources)): ?>

			<?php foreach ($resources AS $resource): ?>		
				<tr>
					<td><?php echo h($resource['ViewResource']['id']); ?>&nbsp;</td>
					<td><?php echo h($resource['ViewResource']['name']); ?>&nbsp;</td>
					<td><?php echo h($resource['ViewResource']['created']); ?>&nbsp;</td>
					<td><?php echo h($resource['ViewResource']['ordering']); ?>&nbsp;</td>

					<?php //echo $this->Html->image('/files/' . $resource['ViewResource']['entity_folder'] . '/' . $resource['ViewResource']['filename']); ?>

					<td class="actions">			
						<div class="btn-group">
							<?php
							if ($resource['ViewResource']['ordering'] > 0):
								echo $this->Html->link('<i class="glyphicon glyphicon-chevron-up"></i>', array('action' => 'order', $resource['ViewResource']['id'], $resource['ViewResource']['ordering'], 'up', $this->Paginator->current(), $resource_group_type_id, $parent_entityid,), array('escape' => FALSE, 'class' => 'btn btn-default'));
							endif;
							?>
							<?php
							if ($total_resources - 1 > $resource['ViewResource']['ordering']):
								echo $this->Html->link('<i class="glyphicon glyphicon-chevron-down"></i>', array('action' => 'order', $resource['ViewResource']['id'], $resource['ViewResource']['ordering'], 'down', $this->Paginator->current(), $resource_group_type_id, $parent_entityid), array('escape' => FALSE, 'class' => 'btn btn-default'));
							endif;
							?>
							<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $resource['ViewResource']['id'], $resource_group_type_id, $parent_entityid, $entity_alias), array('escape' => FALSE, 'class' => 'btn')); ?>												
							<?php
							if ($resource['ViewResource']['type_alias'] == 'document') {
								echo $this->Html->link('<i class="glyphicon glyphicon-download-alt"></i>', '/files/' . $resource['ViewResource']['entity_folder'] . '/' . $resource['ViewResource']['filename'], array('escape' => FALSE, 'class' => 'btn', 'target' => '_blank'));
							} else {
								echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('action' => 'view', $resource['ViewResource']['id'], $resource_group_type_id, $parent_entityid, $entity_alias, $this->Paginator->counter('{:count}')), array('escape' => FALSE, 'class' => 'btn btn-default'));
							}
							?>

							<?php
							echo $this->Form->postLink('<i class="glyphicon glyphicon-trash icon-white"></i>', array('action' => 'delete', $resource['ViewResource']['id'], $resource_group_type_id, $parent_entityid,$entity_alias), array('class' => 'btn btn-danger', 'escape' => FALSE), __('Are you sure you want to delete # %s?', $resource['ViewResource']['id']));
							?>							
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<!--<div class="pagination pagination-centered">
	<ul>
<?php echo $this->Paginator->prev('<', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
<?php echo $this->Paginator->next('>', array('tag' => 'li',), NULL, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')); ?>
	</ul>
</div>-->

