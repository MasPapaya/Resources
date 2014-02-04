<?php echo $this->Form->create('Resource', array('type' => 'file')); ?>
<fieldset>
	<legend><?php echo __(' Add Resource'); ?></legend>
	<?php
	echo $this->Form->input('name', array());
	echo $this->Form->input('file', array('type' => 'file'));
	?>
	<div>
		<?php
		echo __('Allowed types') . ': ';
		foreach ($types as $key => $type) {
			if ($key != 0) {
				echo ', ';
			}
			echo $type['ViewResourceSetting']['resource_type_name'] . ' (' . $type['ViewResourceSetting']['extensions'] . ')';
		}
		?>
	</div>
</fieldset>
<div class="btn-group">
	<?php
	echo $this->Html->link(__('Cancel'), array('action' => 'files', $resource_group_type_id, $parent_entityid, $entity_alias), array('class' => 'btn'));
	echo $this->Form->submit(__('Save'), array('div' => FALSE, 'class' => 'btn btn-primary'));
	?>
</div>
<?php echo $this->Form->end(); ?>