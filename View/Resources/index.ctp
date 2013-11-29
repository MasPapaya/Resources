<?php foreach ($resources as $key => $value):?>
	<div class="groups_resources">
		<?php if($value['ResourceGroupType']['name'] !== null):?>
			<h4><?php echo $value['ResourceGroupType']['name']?></h4>
			<?php if($value['ResourceGroupType']['is_single']):?>
				<?php foreach ($value['ResourceGroupType']['Resources'] as $key => $resource):?>
					<div class="span12">
						<img class="img-polaroid unique in_group img" src="<?php echo $this->Html->webroot($this->Resource->Url_resource($resource['Resource']['filename']))?>" alt="<?php echo $resource['Resource']['name']?>" data-group_id="<?php echo $resource['Resource']['group_id']?>" data-ordering="<?php echo $resource['Resource']['ordering']?>" data-id="<?php echo $resource['Resource']['id']?>" data-group_type_id="<?php echo $value['ResourceGroupType']['id']?>" />
					</div>
				<?php endforeach; ?>			
			<?php else:?>
				<ul class="container-fluid sortable_groups" data-gti="<?php echo $value['ResourceGroupType']['id']?>">
					<?php foreach ($value['ResourceGroupType']['Resources'] as $key => $resource):?>
						<li class="span4 img-polaroid">
							<div class="img in_group" style="background-image: url('<?php echo $this->Html->webroot($this->Resource->Url_resource($resource['Resource']['filename']),true)?>')" alt="<?php echo $resource['Resource']['name']?>" data-group_id="<?php echo $resource['Resource']['group_id']?>" data-ordering="<?php echo $resource['Resource']['ordering']?>" data-id="<?php echo $resource['Resource']['id']?>" >								
							</div>							
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;?>
		<?php else:?>
			<h4><?php echo __('Files without group')?></h4>
			<ul class="container-fluid">				
				<?php foreach ($value['ResourceGroupType']['Resources'] as $key => $resource):?>
					<li class="span4 img-polaroid">
						<div class="img in_group" style="background-image: url('<?php echo $this->Html->webroot($this->Resource->Url_resource($resource['Resource']['filename']),true)?>')" alt="<?php echo $resource['Resource']['name']?>" data-group_id="<?php echo $resource['Resource']['group_id']?>" data-ordering="<?php echo $resource['Resource']['ordering']?>" data-id="<?php echo $resource['Resource']['id']?>" >							
						</div>							
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif;?>		
	</div>
	<div style="clear: both"></div>
<?php endforeach; ?>
<div class="pagination pagination-centered">
	<?php echo $this->Resource->numbers(); ?>
</div>
<?php // echo $this->element('sql_dump');  ?>