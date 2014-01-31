<div class="btn-group">
<?php foreach ($group_types as $group_type): ?>
	<?php echo $this->Html->link(__($group_type['ResourceGroupType']['name']),array('controller'=>'Media','action'=>'files',$group_type['ResourceGroupType']['id'],$parent_entityid,$entity_alias), array('class' => 'btn btn-primary')); ?>
<?php endforeach; ?>
</div>