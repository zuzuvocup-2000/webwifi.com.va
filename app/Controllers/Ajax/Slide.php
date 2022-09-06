<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Slide extends BaseController{
	
	public function __construct(){
	}
	public function delete_all(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'slide_catalogue',
			'data' => ['deleted_at' => 1],
			'where_in' => $id,
			'where_in_field' => 'id',
		]);
		echo $flag;die();
	}

	public function delete_one(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'slide_catalogue',
			'data' => ['deleted_at' => 1],
			'where' => [
				'id' => $id
			]
		]);
		echo $flag;die();
	}
	public function echoview(){
		$file = $this->request->getPost('file');
		$count = $this->request->getPost('count');
		$fileData = [];
		if (isset($file) && is_array($file) && count($file)){
			foreach ($file as $key => $value) {
				$fileData[$key]['image'] = $value;
				$fileData[$key]['order'] = 0;
				$fileData[$key]['url'] = '';
				$fileData[$key]['title'] = '';
				$fileData[$key]['description'] = '';
				$fileData[$key]['content'] = '';
			}
		}else{
				$fileData[$count]['image'] = $file;
				$fileData[$count]['order'] = 0;
				$fileData[$count]['url'] = '';
				$fileData[$count]['title'] = '';
				$fileData[$count]['description'] = '';
				$fileData[$count]['content'] = '';
		}
		$html = view('backend/dashboard/common/slideblock', ['listSlide' => $fileData, 'count' => $count], ['saveData' => true]);
		echo json_encode([
			'fileData' => $fileData,
			'html' => $html,
		]);
		die();
	}

	public function open_modal(){
		$image = $this->request->getPost('image');
		$data = $this->request->getPost('data');
		$data = json_decode(base64_decode($data),true);
        $APPPATH = substr(APPPATH, 0 ,-5);
        $targetPath = urldecode($APPPATH.$image);
        $allowed = ['bmp','gif','jpeg','jpg','png', 'webp'];
		$ext = pathinfo($targetPath, PATHINFO_EXTENSION);
		if (!in_array($ext, $allowed)) {
		    $info = new \CodeIgniter\Files\File($targetPath);
		    $array = [
				'file_name' => $info->getBasename(),
				'file_path' => $info->getRealPath(),
				'file_size' => $info->getSizeByUnit('kb'),
				'file_type' => $info->getMimeType(),
				'file_width' => 'auto',
				'file_time' => date('F j Y, g:i a' , $info->getMTime()),
				'file_height' => 'auto',
			];
		}else{
	        $info = \Config\Services::image('imagick')
	            ->withFile($targetPath)
	            ->getFile();
	        $array = [
				'file_name' => $info->getBasename(),
				'file_path' => $info->getRealPath(),
				'file_size' => $info->getSizeByUnit('kb'),
				'file_type' => $info->mime,
				'file_width' => $info->origWidth,
				'file_time' => date('F j Y, g:i a' , $info->getMTime()),
				'file_height' => $info->origHeight,
			];
		}
		$properties = [];
		if(isset($array) && is_array($array) && count($array)){
			foreach ($array as $key => $value) {
				$properties[] = [
					'name' => $key,
					'value' => $value,
				];
			}
		}
		echo json_encode([
			'image' => $image,
			'info' => $properties, 
			'data' => [
				'title' => $data['title'],
				'canonical' => $data['canonical'],
				'alt' => $data['alt'],
				'description' => $data['description'],
				'content' => $data['content'],
			]
		]);die();
	}

	public function create_data_image(){
		$param = $this->request->getPost('param');
		$data= [];
		if(isset($param) && is_array($param) && count($param)){
			foreach ($param as $key => $value) {
				$data[$value['name']] = $value['value'];
			}
		}
		echo base64_encode(json_encode($data));die();
	}
}
