<?php 
namespace App\Controllers\Backend\System;
use App\Controllers\BaseController;
use App\Controllers\Backend\System\Libraries\Configbie;

class System extends BaseController{
	protected $data;
	public $configbie;
	
	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'website_system';
	}
	public function store(){
		$session = session();
		// $flag = $this->authentication->check_permission([
		// 	'routes' => 'backend/system/system/store'
		// ]);
		// if($flag == false){
 	// 		$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 	// 		return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		// }
		$this->data['systemList'] = $this->configbie->canonical_system();
		$this->data['system'] = $this->AutoloadModel->_get_where([
			'select' => 'keyword, content, module',
			'table' => $this->data['module'],
		], TRUE);
		$temp = [];
		if(isset($this->data['system']) && is_array($this->data['system']) && count($this->data['system'])){
			foreach ($this->data['system'] as $key => $value) {
				$this->data['system'][$key]['content'] = base64_decode($value['content']);
			}
			foreach($this->data['system'] as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
		}
		$this->data['temp'] = $temp;

		// pre($this->data['system']);
		if($this->request->getMethod() == 'post'){
			$config  = $this->request->getPost('config');
			if(isset($config) && is_array($config) && count($config)){
				$delete = $this->AutoloadModel->_delete([
					'table' => $this->data['module'],
					'where' => [
						'deleted_at' => 0
					]
				]);
				$_update = [];
				foreach($config as $key => $val){
					$_update[] = [
						'keyword' => $key,
						'content' => base64_encode($val['content']),
						'module' => $val['module'],
					];
				}

				$flag =	$this->AutoloadModel->_create_batch([
					'table' => $this->data['module'],
					'data' => $_update,
				]);
			}
	 		if($flag > 0){

	 			$session->setFlashdata('message-success', 'Cập Nhật Cấu hình hệ thống Thành Công!');
				return redirect()->to(BASE_URL.'backend/system/system/store');
	 		}

	        
		}
		$this->data['template'] = 'backend/system/system/store';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
