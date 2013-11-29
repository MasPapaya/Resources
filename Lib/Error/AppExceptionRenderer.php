<?php

/* ===== Developer William Alarcon ==== */

App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

	public function handleException($error) {
		echo 'Oops that widget is missing!';
	}

	public function notFound($error) {
		$this->controller->beforeFilter();
		$this->controller->set('title_for_layout', 'Not Found');
		$this->controller->set('error', $error->getMessage());
		$this->controller->render('/Errors/error404');
		$this->controller->response->send();
	}

	public function missingController($error) {
		if ($this->controller->request->params['controller'] == 'files') {
			if (!empty($this->controller->request->params['action']) && !empty($this->controller->request->params['pass'][0])
				&& !empty($this->controller->request->params['pass'][1])) {
				$entity_folder = $this->controller->request->params['action'];
				$version_img = $this->controller->request->params['pass'][0];
				$filename = $this->controller->request->params['pass'][1];
				$url_redirect = $entity_folder . '/' . $version_img . '/' . $filename;
				$file_original = WWW_ROOT . 'files' . DS . $entity_folder . DS . $filename;
				if (file_exists($file_original)) {
					$folder_target = WWW_ROOT . DS . 'files' . DS . $entity_folder . DS . $version_img;
					$version = explode('x', trim($version_img, 'c'));
					if (count($version) == 2 && is_numeric($version[0]) && is_numeric($version[1])) {
						$crop = false;
						if (substr($version_img, -1) == 'c') {
							$crop = true;
						}
						if ($this->scaleImage($filename, array('max_width' => $version[0], 'max_height' => $version[1]), $file_original, $folder_target, $crop)) {
							$this->controller->redirect($url_redirect);
						} else {
							$this->renderMissingController($error);
						}
					} else {
						$this->renderMissingController($error);
					}
				} else {
					if (file_exists(WWW_ROOT . 'files' . DS . $version_img . '.jpg')) {
						$this->controller->redirect($version_img . '.jpg');
					} else {
						$this->renderMissingController($error);
					}
				}
			} else {
				$this->renderMissingController($error);
			}
		} else {
			$this->renderMissingController($error);
		}
	}

	public function scaleImage($file_name, $options, $file_path, $path_version, $crop = false) {
		$file_path = $file_path;
		$path_version = $path_version;
		if (!file_exists($path_version)) {
			mkdir($path_version, 0777);
			chmod($path_version, 0777);
		}
		$new_file_path = $path_version . DS . $file_name;
		unset($path_version);
		list($img_width, $img_height) = @getimagesize($file_path);
		if (!$img_width || !$img_height) {
			return false;
		}

		$new_width = $options['max_width'];
		$new_height = $options['max_height'];
		if ($crop) {
			if ($img_width < $new_width || $img_height < $new_height)
				return false;
			$ratio = max($new_width / $img_width, $new_height / $img_height);
			$img_height = $new_height / $ratio;
			$x = ($img_width - $new_width / $ratio) / 2;
			$img_width = $new_width / $ratio;
		}else {
			if ($img_width < $new_width and $img_height < $new_height)
				return false;
			$ratio = min($new_width / $img_width, $new_height / $img_height);
			$new_width = $img_width * $ratio;
			$new_height = $img_height * $ratio;
			$x = 0;
		}

		$new_img = @imagecreatetruecolor($new_width, $new_height);
		switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
			case 'jpg':
			case 'jpeg':
				$src_img = @imagecreatefromjpeg($file_path);
				$write_image = 'imagejpeg';
				$image_quality = Configure::read('Resource.quality.jpg');
				break;
			case 'gif':
				@imagecolortransparent($new_img, @imagecolorallocatealpha($new_img, 0, 0, 0, 127));
				$src_img = @imagecreatefromgif($file_path);
				$write_image = 'imagegif';
				$image_quality = null;
				imagealphablending($new_img, false);
				imagesavealpha($new_img, true);
				break;
			case 'png':
				@imagecolortransparent($new_img, @imagecolorallocatealpha($new_img, 0, 0, 0, 127));
				@imagealphablending($new_img, false);
				@imagesavealpha($new_img, true);
				$src_img = @imagecreatefrompng($file_path);
				$write_image = 'imagepng';
				$image_quality = Configure::read('Resource.quality.png');
				imagealphablending($new_img, false);
				imagesavealpha($new_img, true);
				break;
			default:
				$src_img = null;
		}

		$success = $src_img && @imagecopyresampled($new_img, $src_img, 0, 0, $x, 0, $new_width, $new_height, $img_width, $img_height) && $write_image($new_img, $new_file_path, $image_quality);
		if ($success) {
			chmod($new_file_path, 0777);
		}
		@imagedestroy($src_img);
		@imagedestroy($new_img);
		return $success;
	}

	public function renderMissingController($error) {
		$this->controller->beforeFilter();
		$this->controller->set('title_for_layout', 'Missing Controller');
		$this->controller->set('error', $error->getMessage());
		$this->controller->render('/Errors/missing_controller');
		$this->controller->response->send();
	}

}