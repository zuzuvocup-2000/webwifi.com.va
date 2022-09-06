<?php 
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Store extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'store';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/store/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$this->data['code'] = $this->AutoloadModel->_get_where([
			'select' => 'id, suffix, prefix, module, num0',
			'table' => 'id_general',
			'where' => ['module' => $this->data['module']]
		]);
		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, vn_ward.name as ward, vn_district.name as district, vn_province.name as city,',
			'table' => $this->data['module'],
			'join' => [
				[
					'vn_ward', ' store.wardid = vn_ward.wardid ', 'inner'
				],
				[
					'vn_district', ' store.districtid = vn_district.districtid ', 'inner'
				],
				[
					'vn_province', ' store.cityid = vn_province.provinceid ', 'inner'
				],
			],
			'keyword' => $keyword,
			'where' => $where,
			'group_by' => 'id',
			'count' => TRUE,
		]);
		// pre($config['total_rows'] );
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/product/store/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['storeList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, email, address, phone, storeid, publish,  vn_ward.name as ward, vn_district.name as district, vn_province.name as city,',
				'table' =>$this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'join' => [
					[
						'vn_ward', ' store.wardid = vn_ward.wardid ', 'inner'
					],
					[
						'vn_district', ' store.districtid = vn_district.districtid ', 'inner'
					],
					[
						'vn_province', ' store.cityid = vn_province.provinceid ', 'inner'
					],
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'id asc',
				'group_by' => 'id'
			], TRUE);
			// pre($this->data['storeList']);
		}
		$this->data['template'] = 'backend/product/store/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/store/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data['check_code'] = $this->AutoloadModel->_get_where([
			'select' => 'code,objectid',
			'table' => 'id_general',
			'where' => ['module' => $this->data['module']],
		]);

		if(!isset($this->data['check_code']) && !is_array($this->data['check_code']) ){
			$session->setFlashdata('message-danger', 'Bạn chưa tạo phần cấu hình chung cho mã Cửa hàng!');
 			return redirect()->to(BASE_URL.'backend/product/store/index');
		}else{
			$this->data['storeid'] = convert_code($this->data['check_code']['code'], $this->data['module']);
			// pre($this->data['storeid']);
			if($this->request->getMethod() == 'post'){
				$validate = $this->validation();
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
			 		$insert = $this->store(['method' => 'create']);

			 		$resultid = $this->AutoloadModel->_insert([
			 			'table' => $this->data['module'],
			 			'data' => $insert,
			 		]);
	 				if($resultid > 0){
	 					$this->AutoloadModel->_update([
	 						'table' => 'id_general',
	 						'data' => [
	 							'objectid' => $this->data['check_code']['objectid'] + 1
	 						],
	 						'where' => ['module' => $this->data['module']]
	 					]);


	 					$session->setFlashdata('message-success', 'Tạo Cửa hàng Thành Công! Hãy tạo danh mục tiếp theo.');
							return redirect()->to(BASE_URL.'backend/product/store/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/product/store/index');
	 				}
		        }else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}
		}

		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/product/store/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/store/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, storeid, email,  phone, description, districtid, wardid, cityid, address, image, publish',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		// pre($this->data[$this->data['module']]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Cửa hàng không tồn tại');
 			return redirect()->to(BASE_URL.'backend/product/store/index');
		}
		$this->data[$this->data['module']]['description'] = base64_decode($this->data[$this->data['module']]['description']);
		if($this->request->getMethod() == 'post'){

			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$update = $this->store(['method' => 'update']);
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'where' => ['id' => $id],
		 			'data' => $update
		 		]);

		 		if($flag > 0){
		 			$session->setFlashdata('message-success', 'Cập Nhật Cửa hàng Thành Công!');
 					return redirect()->to(BASE_URL.'backend/product/store/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/product/store/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/store/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title ',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Cửa hàng không tồn tại');
 			return redirect()->to(BASE_URL.'backend/product/store/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');
		
			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $_id
				]
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/product/store/index');
		}

		$this->data['template'] = 'backend/product/store/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function condition_where(){
		$where = [];
		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}else{
			$where['publish'] = 1;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(storeid LIKE \'%'.$keyword.'%\' OR title LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR vn_province.name LIKE \'%'.$keyword.'%\' OR vn_ward.name LIKE \'%'.$keyword.'%\' OR vn_district.name LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
			'email' => $this->request->getPost('email'),
 			'title' => $this->request->getPost('title'),
 			'storeid' => $this->request->getPost('storeid'),
 			'image' => $this->request->getPost('image'),
 			'address' => $this->request->getPost('address'),
 			'phone' => $this->request->getPost('phone'),
 			'cityid' => $this->request->getPost('cityid'),
 			'districtid' => $this->request->getPost('districtid'),
 			'wardid' => $this->request->getPost('wardid'),
 			'publish' => 1,
 			'description' => base64_encode($this->request->getPost('description')),
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
			'storeid' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tên Cửa hàng!'
			],
			'storeid' => [
				'required' => 'Bạn phải nhập vào trường Mã Cửa hàng!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
