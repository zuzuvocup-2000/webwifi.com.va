<?php 
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'user';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/user/user/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['userList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, image, email, phone, address, created_at, image, gender, userid_created, userid_updated, publish',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

		$this->data['template'] = 'backend/user/user/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$insert = $this->store();
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$session->setFlashdata('message-success', 'Thêm mới người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/user/user/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/user/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email,job, phone, address, birthday, gender, cityid, districtid, wardid, image',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$update = $this->store();
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/user/user/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/user/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email, phone, address, birthday, gender',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		if($this->request->getPost('delete')){
			$userID = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $userID],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$this->data['template'] = 'backend/user/user/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_exist',
			'catalogueid' => 'is_natural_no_zero',
			'fullname' => 'required',
		];
		$errorValidate = [
			'email' => [
				'check_email_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Thành Viên'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != -1 && $gender != '' && isset($gender)){
			$where['gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}
		$catalogueid = $this->request->getGet('catalogueid');
		if(isset($catalogueid) && $catalogueid != 0){
			$where['catalogueid'] = $catalogueid;
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
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store(){
		helper(['text']);
		$salt = random_string('alnum', 168);
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'gender' => (int)$this->request->getPost('gender'),
 			'image' => $this->request->getPost('image'),
 			'job' => $this->request->getPost('job'),
 			'birthday' => $this->request->getPost('birthday'),
 			'address' => $this->request->getPost('address'),
 			'phone' => $this->request->getPost('phone'),
 			'cityid' => $this->request->getPost('cityid'),
 			'districtid' => $this->request->getPost('districtid'),
 			'wardid' => $this->request->getPost('wardid'),
 		];
 		if($this->request->getPost('password')){
 			$store['password'] = password_encode($this->request->getPost('password'), $salt);
 			$store['salt'] = $salt;
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

}
