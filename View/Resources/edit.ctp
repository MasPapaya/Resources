<div class="content_options">
	<div style="text-align: center">
		<img class="img-polaroid" src="<?php echo $this->Html->webroot($this->Resource->Url_resource($resource['Resource']['filename'],true))?>" alt="<?php echo $resource['Resource']['name']?>" style="max-height: 140px;max-width: 140px;" />	
	</div>

	<?php echo $this->Form->create('Resource'); ?>	
		<?php echo $this->Form->input('id'); ?>	
		<?php echo $this->Form->input('name',array('class'=>'fields_fluid','label'=>  __('Name'))); ?>	
		<?php echo $this->Form->input('resource_type_id',array('type'=>'hidden')); ?>
		<?php echo $this->Form->input('group_id',array('type'=>'hidden')); ?>
		<?php echo $this->Form->input('group_type_id',array('type'=>'hidden')); ?>

		<strong><?php echo __('Groups')?></strong>
		<br />
		<?php echo $this->Form->select('ResourceGroupType.id',$this->Upload->parse_to_list_select($RGT,'ResourceGroupType','name'),array('class'=>'chosen_groups fields_fluid','data-placeholder'=>__('Select groups'),'multiple'=>true,'default'=>$ViewResourceGroup));?>
		<br />
		<br />

		<?php 
			echo $this->Js->submit(__('Submit'), array(
	//			'url' => array('controller'), 
				'class' => 'btn btn-primary',
				'escape' => FALSE, 
				'update' => "#options_imgs"
			));
		?>
	<?php echo $this->Form->end() ?>

	<ul class="nav nav-pills nav-stacked nav-list" style="width: 100%">
		<li class="nav-header"><?php echo __('Options')?></li>	
		<li > <?php echo $this->Html->link('<i class=" icon-eye-open"></i> '.__('Display'),$this->Resource->UrlWebRoot($resource['Resource']['filename']),array('escape'=>false,'target'=>'blank'))?></li>
		<li>
			<?php
				echo $this->Upload->delete(
					'<i class="icon-trash"></i> '.__('Permanently delete'),
					array('action' => 'delete',$ResourceEntity['ResourceEntity']['alias'],$parent_entityid,'?'=>array('id_resource'=>$resource['Resource']['id'])),
					array('escape' => false),
					array('update'=>'#options_imgs','confirm'=>__('Are you sure you want to delete \" %s \"?',$resource['Resource']['name'])),
					'DELETE',
					'link'
				);
			?>	
		</li>
	</ul>
</div>
<script type="text/javascript">
	//<![CDATA[
		$('.chosen_groups').chosen();
	//]]>
</script>
<?php if(isset($reload_home) && $reload_home):?>
	<script type="text/javascript">
		setTimeout(function(){
			window.location.href = "<?php echo $this->Html->url(array('controller'=>'resources','action'=>'index',$ResourceEntity['ResourceEntity']['alias'],$parent_entityid))?>";
		},500);
	</script>
<?php endif; ?>
