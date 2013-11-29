<?php  
App::uses('AppHelper', 'View/Helper');

class UploadHelper extends AppHelper {
	
	public $helpers = array('Html', 'Session', 'Paginator', 'Js' => array('Jquery'), 'Form','Time');

	public function parse_to_list_select(array $data,$name_view = false,$field= 'name'){		
		$result = array();		
		foreach ($data as $value){
			$result[$value[$name_view]['id']] = $value[$name_view][$field];
		}
		return $result;
	}
	
	public function delete($title, array $url, array $options, array $options_js = null,$request_method = 'POST',$type = 'button'){
		if(empty($url)){
			return false;
		}
		
		$options_js_default = array(
			'update' => '#primary-ajax',
			'confirm' => __('Are you sure you want to delete the record')
		);
		
		$options_js = array_merge($options_js_default, $options_js);
		$id = rand(0, 9999999999);
		//$(this).append(loading);
		$script = '
			$("#link-' . $id . '").bind("click",function(event){
				var loading = $(\'<img src="\'+base_url+\'/img/loading.gif" alt="cargando" />\');				
				 event.preventDefault();
				if(confirm("' . $options_js['confirm'] . '")){
					
					$.ajax({
						url:"' . $this->Html->url($url) . '",
						dataType:"html",
						type:"'.$request_method.'",
						success:function (data, textStatus) {
							$("' . $options_js['update'] . '").html(data);
						}
					});
				}
			}).bind("contextmenu", function(e) {
				return false;
			});
		';
		$this->Js->buffer($script,true);
		switch ($type){
			case 'button':
					return $this->Form->button($title, array_merge_recursive(array('id' => 'link-' . $id), $options));
				break;
			
			case 'link':
					return $this->Html->link($title,$url, array_merge_recursive(array('id' => 'link-' . $id), $options));
				break;
		}		
	}
	
	

}