<script type="text/javascript">	
	setTimeout(function(){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'resources','action'=>'index',$ResourceEntity['ResourceEntity']['alias'],$parent_entityid))?>";
	},50);
</script>