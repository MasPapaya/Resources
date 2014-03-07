<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title><?php echo $title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script type="text/javascript">var base = '<?php echo $this->html->url('/'); ?>';</script>
		<?php
		echo $this->Html->css(array('bootstrap.min', '/resources/css/media'));
		echo $this->Html->script(array('/resources/js/media'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		?>
		<script type="text/javascript">
			var base_url='<?php echo $this->Html->url('/'); ?>';
		</script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
		<?php echo $this->Js->writeBuffer(); ?>
	</body>
</html>