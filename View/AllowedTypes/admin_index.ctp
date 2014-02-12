<div class="allowedR_Types cru">
	<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign icon-white"></i>&nbsp;' . __('New Allowed Type'), array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary', 'escape' => FALSE)); ?>
	<div>
		<h2><?php echo __('Allowed Types'); ?></h2>	
		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('resource_type_id', __('Resource Type')); ?></th>
					<th><?php echo $this->Paginator->sort('mimetype'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($allowedTypes as $allowedType): ?>
					<tr>
						<td><?php echo h($allowedType['AllowedType']['id']); ?>&nbsp;</td>
						<td><?php echo h($allowedType['ResourceType']['name']); ?></td>
						<td><?php echo h($allowedType['AllowedType']['mimetype']); ?>&nbsp;</td>
						<td class="actions">
							<div class="btn-group">								
									<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', array('action' => 'edit', $allowedType['AllowedType']['id']), array('escape' => FALSE, 'class' => 'btn btn-default')) ?>																	
							</div>
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