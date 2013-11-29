<div class="well span6" style=" margin: 10px auto;">
	<div class="border" style="padding: 20px;background-color: white;">
		<?php echo $this->Form->create('Resource', array('type' => 'file','style'=>'margin:0;')) ?>
			<legend><?php echo __('Upload Files External') ?></legend>		
			<?php
				echo $this->Form->input('name',array('required'=>'required'));
				switch (count($RGT)):
						case 0:	
							break;						
						case 1:
							echo $this->Form->input('ResourceGroup.resource_group_type_id',array('type'=>'hidden','value'=>$RGT[0]['ResourceGroupType']['id']));
							break;
						default:
							echo '<label for="">'.__('Groups').'</label>';
							echo $this->Form->select('ResourceGroup.resource_group_type_id',$this->Upload->parse_to_list_select($RGT,'ResourceGroupType','name'),array('class'=>'chosen_groups','data-placeholder'=>__('Select groups'),'multiple'=>true));
							break;					
				endswitch;

				echo $this->Form->input('url',array('class'=>'span12','required'=>'required','div'=>array('style'=>'margin-top:10px;')));
			?>		
		<?php echo $this->Form->end(array('label' => __('submit'), 'class' => 'btn btn-primary')) ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){		
		$('.chosen_groups').chosen();		
	});
</script>