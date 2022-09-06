<?php 
namespace App\Controllers\Backend\Contact;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'contact_catalogue';
	}

	public function index($page = 1){
		helper(['mypagination']);
		$session = session();
		$explode = explode('_', $this->data['module']);
		// $flag = $this->authentication->check_permission([
		// 	'routes' => 'backend/contact/catalogue/index'
		// ]);
		// if($flag == false){
 	// 		$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 	// 		return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		// }
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select'   => 'tb1.id',
			'table'    => $this->data['module'].' as tb1',
			'join' => [
					[
						$explode[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
					],
			],
			'keyword'  => $keyword,
			'where'    => $where,
			'group_by' => 'tb1.id',
			'count'    => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/contact/catalogue/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$languageDetact = $this->detect_language();
			$this->data['contactList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.title, tb1.publish,tb1.keyword,   tb1.userid_created, tb1.userid_updated, tb1.created_at, tb1.updated_at , '.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
				'table'    => $this->data['module'].' as tb1',
				'join' => [
					[
						$explode[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
					]
				],
				'where'    => $where,
				'keyword'  => $keyword,
				'limit'    => $config['per_page'],
				'start'    => $page * $config['per_page'],
				'order_by' => 'tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);
		}


		

			
		$this->data['template'] = 'backend/contact/catalogue/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$explode = explode('_', $this->data['module']);
		$this->data['method'] = 'create';
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$contact = $this->store(['method' => 'create']);
				


				$insertCat = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'] ,
		 			'data'  => $contact,
		 		]);
		 		
		 		if ($insertCat > 0){
		 			$contactTrans = $this->storeTrans(['method' => 'create', 'objectid' => $insertCat ]);
		 			$insertTrans =  $this->AutoloadModel->_insert([
		 					'table' => $explode[0].'_translate',
			 		 		'data'  => $contactTrans,
		 				]);

		 			if($insertTrans > 0){
	 					$session->setFlashdata('message-success', 'Tạo Bản Ghi Thành Công! Hãy tạo danh mục tiếp theo.');
 						return redirect()->to(BASE_URL.'backend/contact/catalogue/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/contact/catalogue/index');
	 				}
		 		}
	        else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	    }
	}
	    
		
		$this->data['template'] = 'backend/contact/catalogue/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$explode = explode('_', $this->data['module']);
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => ' tb2.title, tb1.order, tb1.keyword',
			'table'  => $this->data['module'].' as tb1',
			'join' => [
					[
						$explode[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
					]
				],
			'where'  => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);

		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Nhóm liên hệ không tồn tại');
 			return redirect()->to(BASE_URL.'backend/contact/catalogue/index');
		}


		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$contact = $this->store(['method' => 'create']);
				$updateCat = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'data'  => $contact,
		 			'where' => ['id' => $id],
		 		]);
				if($updateCat > 0){
					$contactTrans = $this->storeTrans(['method' => 'create', 'objectid' => $id ]);
					$updateTrans = $this->AutoloadModel->_update([
			 			'table' => $explode[0].'_translate',
			 			'data'  => $contactTrans,
			 			'where' => ['objectid' => $id, 'language' => $this->currentLanguage(),'module' => $this->data['module']],
			 		]);
			 		if($updateTrans > 0){
	 					$session->setFlashdata('message-success', 'Tạo Bản Ghi Thành Công! Hãy tạo danh mục tiếp theo.');
 						return redirect()->to(BASE_URL.'backend/contact/catalogue/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/contact/catalogue/index');
	 				}
				}
			}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/contact/catalogue/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$explode = explode('_', $this->data['module']);
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => ' tb2.title, tb1.order, tb1.id',
			'table'  => $this->data['module'].' as tb1',
			'join' => [
					[
						$explode[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
					],
					[
						'user as tb3','tb1.userid_created = tb3.id','inner'
					],
				],
			'where'  => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);

		$this->data['template'] = 'backend/contact/catalogue/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function condition_where(){
		$where = [];

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}
		$where['tb2.language'] = $this->currentLanguage();

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'keyword'   => slug($this->request->getPost('keyword')),
		];
 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		$store['deleted_at'] = 0;
 		$store['publish'] = 1;
 		return $store;
	}
	private function storeTrans($param = []){
		helper(['text']);
		$store = [
 			'title'   => $this->request->getPost('title'),
 			'module'   => $this->data['module'],
 		];

 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 		}
 		$store['deleted_at'] = 0;
 		$store['language'] = $this->currentLanguage();
 		$store['objectid'] = $param['objectid'];
 		return $store;
	}
	private function detect_language($param = []){
		$languageList = $this->AutoloadModel->_get_where([
			'select' => 'id, canonical',
			'table'  => 'language',
			'where'  => ['deleted_at' => 0,'canonical !=' =>  $this->currentLanguage()]
		], TRUE);
		$select = '';
		$i = 3;
		if(isset($languageList) && is_array($languageList) && count($languageList)){
			foreach($languageList as $key => $val){
				$select = $select.'(SELECT  COUNT(objectid) FROM contact_translate WHERE contact_translate.objectid = tb1.id AND contact_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}
		}
		return [
			'select' => $select,
		];
	}
	private function validation(){
		$validate = [
			'title' => 'required',
			'keyword' => 'required|check_keyword['.$this->data['module'].']',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'keyword' => [
				'required' => 'Bạn phải nhập Từ khóa giao diện!',
				'check_keyword' => 'Từ khóa đã tồn tại, vui lòng chọn từ khóa khác!'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
