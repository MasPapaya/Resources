<div style="margin-top: 20px;">
	<form action="<?php echo Router::url(array('controller' => 'resources', 'action' => 'manager',$ResourceEntity['ResourceEntity']['alias'], $parent_entityid), true) ?>" id="fileupload" enctype="multipart/form-data" method="post" accept-charset="utf-8">

		<div class="row-fluid btns_files_upload fileupload-buttonbar">		
			
			<span class="btn btn-success fileinput-button">
				<i class="icon-plus icon-white"></i>
				<span><?php echo __('Add files')?></span>
				<?php
				echo $this->Form->input('filename.', array('type' => 'file', 'div' => false, 'label' => false, 'required' => false, 'multiple' => 'multiple', 'id' => 'ResourceFilename'));
				?>			
			</span>

			<button type="submit" class="btn btn-primary start">
				<i class="icon-upload-alt icon-white"></i>
				<span><?php echo __('Start upload')?></span>
			</button>

			<button type="reset" class="btn btn-warning cancel">
				<i class="icon-ban-circle icon-white"></i>
				<span><?php echo __('Cancel upload')?></span>
			</button>
			
			<button type="button" class="btn btn-danger delete">
				<i class="icon-trash icon-white"></i>
				<span><?php echo __('Delete')?></span>
			</button>

			<input type="checkbox" class="toggle">
			
			<?php echo $this->Html->link('<i class="icon-upload "></i> '.__('Upload Files External'),array('action'=>'external',$ResourceEntity['ResourceEntity']['alias'], $parent_entityid),array('escape'=>false,'class'=>'btn btn-info'))?>
		</div>
		<div class="row-fluid" style="margin-bottom: 20px;">
			<!-- The loading indicator is shown during file processing -->
			<span class="fileupload-loading"></span>
		</div>

		<!-- The global progress information -->
		<div class="span12 fileupload-progress fade">
			<!-- The global progress bar -->
			<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
				<div class="bar" style="width:0%;"></div>
			</div>
			<!-- The extended global progress information -->
			<div class="progress-extended">&nbsp;</div>
		</div>	

		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped">
			<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">

			</tbody>
		</table>

	</form>
</div>

<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3 class="modal-title"></h3>
	</div>
	<div class="modal-body"><div class="modal-image"></div></div>
	<div class="modal-footer">
		<a class="btn modal-download" target="_blank">
			<i class="icon-download"></i>
			<span><?php echo __('Download')?></span>
		</a>
		<a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
			<i class="icon-play icon-white"></i>
			<span><?php echo __('Slideshow')?></span>
		</a>
		<a class="btn btn-info modal-prev">
			<i class="icon-arrow-left icon-white"></i>
			<span><?php echo __('Previous')?></span>
		</a>
		<a class="btn btn-primary modal-next">
			<span><?php echo __('Next')?></span>
			<i class="icon-arrow-right icon-white"></i>
		</a>
	</div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-upload fade">
				<td>
						<span class="preview"></span>
				</td>
				<td>
						<?php echo $this->Form->input('Resource.name',array('label'=>false,'placeholder'=>'Nombre de archivo','div'=>'false','required'=>false,'id'=>false,'class'=>'ResourceName'));?>
				</td>
				<td>
						<?php
								switch (count($RGT)):						
										case 0:	
											break;						
										case 1:
											echo $this->Form->input('ResourceGroup.resource_group_type_id',array('type'=>'hidden','value'=>$RGT[0]['ResourceGroupType']['id']));
											break;
										default:
											echo $this->Form->select('ResourceGroup.resource_group_type_id',$this->Upload->parse_to_list_select($RGT,'ResourceGroupType','name'),array('class'=>'chosen_groups','data-placeholder'=>__('Select groups'),'multiple'=>true));
											break;					
								endswitch;
						?>
				</td>
				<td>
						<p class="size">{%=o.formatFileSize(file.size)%}</p>
						{% if (!o.files.error) { %}
								<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
						{% } %}
				</td>
				<td>
						{% if (!o.files.error && !i && !o.options.autoUpload) { %}
								<button class="btn btn-primary start">
										<i class="icon-upload icon-white"></i>
										<span><?php echo __('Start')?></span>
								</button>
						{% } %}
						{% if (!i) { %}
								<button class="btn btn-warning cancel">
										<i class="icon-ban-circle icon-white"></i>
										<span><?php echo __('Cancel')?></span>
								</button>
						{% } %}
				</td>
		</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-download fade">
				<td>
						{% if (file.thumbnail_url) { %}
								<span class="preview">
										<a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img class="img-polaroid" src="{%=file.thumbnail_url%}"></a>
								</span>
						{% } %}

				</td>
				<td>
						<p class="name">
								<a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
						</p>
						{% if (file.error) { %}
								<div><span class="label label-important"><?php echo __('Error')?></span> {%=file.error%}</div>
						{% } %}

						{% if (file.status) { %}
								<div><span class="label label-info"><?php echo __('Info')?></span> {%=file.status%}</div>
						{% } %}
				</td>
				<td>
						<span class="size">{%=o.formatFileSize(file.size)%}</span>
				</td>
				<td>
						<button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
								<i class="icon-trash icon-white"></i>
								<span><?php echo __('Delete')?></span>
						</button>
						<input type="checkbox" name="delete" value="1" class="toggle">
				</td>
		</tr>
{% } %}
</script>
 