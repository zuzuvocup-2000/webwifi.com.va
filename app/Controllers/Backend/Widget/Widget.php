<?php 
namespace App\Controllers\Backend\Widget;
use App\Controllers\BaseController;
use App\Controllers\Backend\Widget\Libraries\Configbie;

class Widget extends BaseController{
	protected $data;
	public $configbie;
	
	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'website_widget';
	}

	public function index(){
		try{
			$session = session();
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/widget/widget/index'
			]);
			if($flag == false){
	 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
	 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
			}
			
			$client = new \CodeIgniter\HTTP\CURLRequest(
		        new \Config\App(),
		        new \CodeIgniter\HTTP\URI(),
		        new \CodeIgniter\HTTP\Response(new \Config\App())
			);
			$listWidget = $client->get('widgetcms.com/api/widget/widget/list');
			if(!isset($listWidget)){
				$session->setFlashdata('message-danger', 'Lỗi không thể kết nối để lấy ra dữ liệu!');
				return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
			}
			$this->data['widgetList'] = json_decode(validate_input($listWidget->getBody()),TRUE);
			$this->data['widgetList'] = $this->data['widgetList']['data'];
			$catalogueWidget = $client->get('widgetcms.com/api/widget/widget/widget_catalogue_list');
			$catalogueWidget = json_decode(validate_input($catalogueWidget->getBody()),TRUE);
			$this->data['widgetCAtalogueList'] = $catalogueWidget['data'];
			$this->data['widgetMatch'] = match_2_arrays($this->data['widgetCAtalogueList'], $this->data['widgetList']);	
			$temp = [];

			$this->data['selectWidget'] = $this->AutoloadModel->_get_where([
				'select' => 'id,catalogueid, keyword',
				'table' => 'website_widget'
			],TRUE);
			foreach ($this->data['widgetMatch'] as $key => $value) {
				if($value['data'] != []){
					foreach ($value['data'] as $keyChild => $valChild) {
						foreach ($this->data['selectWidget'] as $keyPublish => $valPublish) {
							if($valPublish['keyword'] == $valChild['keyword'] && $valPublish['catalogueid'] == $valChild['catalogueid']){
								$this->data['widgetMatch'][$key]['data'][$keyChild]['publish'] = 1;
							}
						}
					}
				}
			}
			// prE($this->data['widgetMatch']);

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
					return redirect()->to(BASE_URL.'backend/widget/widget/index');
		 		}

		        
			}

			$this->data['template'] = 'backend/widget/widget/index';
			return view('backend/dashboard/layout/home', $this->data);
		}catch(\Exception $e){
 			$session->setFlashdata('message-danger', 'Không thể kết nối để lấy dữ liệu!');
			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/widget/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if($this->validate($validate['validate'], $validate['errorValidate'])){
				$insert = $this->store(['method' => 'create']);
				$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);
		 		if($resultid > 0){
		 			$session->setFlashdata('message-success', 'Tạo Widget Thành Công! Hãy tạo Widget tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/widget/widget/index');
		 		}
			}else{
				$this->data['validate'] = $this->validator->listErrors();
			}
		}

		$this->data['template'] = 'backend/widget/widget/create';
		return view('backend/dashboard/layout/home', $this->data);
	}


	public function update($id = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/widget/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data['widget'] = $this->AutoloadModel->_get_where([
			'select' => 'keyword, html,css,script,id,title,publish',
			'table' => 'website_widget',
		]);
		$this->data['widget']['html'] = base64_decode($this->data['widget']['html']);
		$this->data['widget']['css'] = base64_decode($this->data['widget']['css']);
		$this->data['widget']['script'] = base64_decode($this->data['widget']['script']);
		// pre($this->data['widget']);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if($this->validate($validate['validate'], $validate['errorValidate'])){
				$insert = $this->store(['method' => 'create']);
				$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);
		 		if($resultid > 0){
		 			$session->setFlashdata('message-success', 'Tạo Widget Thành Công! Hãy tạo Widget tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/widget/widget/index');
		 		}
			}else{
				$this->data['validate'] = $this->validator->listErrors();
			}
		}

		$this->data['template'] = 'backend/widget/widget/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function store($param = []){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/widget/widget/store'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		helper(['text']);
		$store = [
			'title' => validate_input($this->request->getPost('title')),
			'keyword' => slug($this->request->getPost('keyword')),
			'publish' => $this->request->getPost('publish'),
			'html' => base64_encode(validate_input($this->request->getPost('html'))),
			'css' => base64_encode(validate_input($this->request->getPost('css'))),
			'script' => base64_encode(validate_input($this->request->getPost('script'))),
		];
		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
		return $store;
	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'keyword' => 'required|check_widget',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập tiêu đề Widget!'
			],
			'keyword' => [
				'required' => 'Bạn phải nhập từ khóa Widget!',
				'check_widget' => 'Từ khóa Widget đã tồn tại, vui lòng chọn từ khóa khác!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
