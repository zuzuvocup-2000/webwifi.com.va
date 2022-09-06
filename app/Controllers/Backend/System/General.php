<?php 
namespace App\Controllers\Backend\System;
use App\Controllers\BaseController;
use App\Controllers\Backend\System\Libraries\Configbie;

class General extends BaseController{
	protected $data;
	public $configbie;
	
	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'system';
		$this->data['module_2'] = 'system_catalogue';

	}

	
	public function index($page = 1){
		// pre($this->configbie->system() );
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/system/general/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		
		$this->data['systemList'] = $this->configbie->system();
		$this->data['system'] = $this->AutoloadModel->_get_where([
			'select' => 'keyword, content',
			'table' => 'system_translate',
			'where' => ['language' => $this->currentLanguage() ]
		], TRUE);

		$temp = [];
		if(isset($this->data['system'])){
			foreach($this->data['system'] as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
		}

		$this->data['temp'] = $temp;

		if($this->request->getMethod() == 'post'){
			$config  = $this->request->getPost('config');
			if(isset($config) && is_array($config) && count($config)){
				$delete = $this->AutoloadModel->_delete([
					'table' => 'system_translate',
					'where' => ['language' => $this->currentLanguage()]
				]);
				$_update = [];
				foreach($config as $key => $val){
					$_update[] = [
						'language' => $this->currentLanguage(),
						'keyword' => $key,
						'content' => $val,
						'userid_updated' => $this->auth['id'],
						'updated_at' => $this->currentTime
					];
					
				}
				$flag =	$this->AutoloadModel->_create_batch([
					'table' => 'system_translate',
					'data' => $_update,
				]);
			}
	 		if($flag > 0){

	 			$session->setFlashdata('message-success', 'Cập Nhật Cấu hình chung Thành Công!');
				return redirect()->to(BASE_URL.'backend/system/general/index');
	 		}

	        
		}

		$this->data['template'] = 'backend/system/general/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function translator($languageCurrent = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/system/general/translator'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data['systemList'] = $this->configbie->system();
		$this->data['languageCurrent'] = $languageCurrent;


		$this->data['system'] = $this->AutoloadModel->_get_where([
			'select' => 'keyword, content',
			'table' => 'system_translate',
			'where' => ['language' => $this->data['languageCurrent']]
		], TRUE);

		$temp = [];
		if(isset($this->data['system'])){
			foreach($this->data['system'] as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
		}

		$this->data['temp'] = $temp;

		if($this->request->getMethod() == 'post'){
			$config  = $this->request->getPost('config');



	 		$delete = $this->AutoloadModel->_delete([
				'table' => 'system_translate',
				'where' => ['language' => $this->data['languageCurrent']]
			]);
			if(isset($config) && is_array($config) && count($config)){
				$_insert = [];
				foreach($config as $key => $val){
					
					$_insert[] = [
						'language' => $this->data['languageCurrent'],
						'keyword' => $key,
						'content' => $val,
						'userid_updated' => $this->auth['id'],
						'updated_at' => $this->currentTime
					];
				}

				$flag =	$this->AutoloadModel->_create_batch([
					'table' => 'system_translate',
					'data' => $_insert,
				]);

			}
	 		if($flag > 0){

	 			$session->setFlashdata('message-success', 'Cập Nhật Cấu hình chung Thành Công!');
				return redirect()->to(BASE_URL.'backend/system/general/translator/'.$this->data['languageCurrent']);
	 		}
		    
		}



		$this->data['template'] = 'backend/system/general/translate';
		return view('backend/dashboard/layout/home', $this->data);
	}
	
	
	

}
