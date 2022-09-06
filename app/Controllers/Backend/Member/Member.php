<?php 
namespace App\Controllers\Backend\Member;
use App\Controllers\BaseController;
use App\Controllers\Backend\Member\Libraries\Configbie;

class Member extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'member';
		$this->configbie = new ConfigBie();
		$this->data['type'] = $this->configbie->index();
	}

	public function index($page = 1){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/member/member/index'
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
			$config = pagination_config_bt(['url' => 'backend/member/member/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['memberList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, image, email, phone, address, created_at, image, gender,publish',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

		$this->data['template'] = 'backend/member/member/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/member/member/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/member/member/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$insert = $this->store();
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			// $flag = $this->create_relationship($insertid);
		 			$session->setFlashdata('message-success', 'Thêm mới người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/member/member/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/member/member/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/member/member/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/member/member/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email, phone, address, birthday, gender, cityid, districtid, wardid, image, detail',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/member/member/index');
		}
		// $this->data[$this->data['module']]['detail'] = json_decode($this->data[$this->data['module']]['detail'],true);
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$update = $this->store();
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			// $this->create_relationship($id);
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/member/member/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/member/member/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/member/member/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/member/member/index');
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
 			return redirect()->to(BASE_URL.'backend/member/member/index');
		}

		if($this->request->getPost('delete')){
			$memberID = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $memberID],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/member/member/index');
		}

		$this->data['template'] = 'backend/member/member/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function create_relationship($objectid = 0, $catalogue = []){
		unset($this->data['type']['']);
		if($this->request->getPost('detail') != ''){
			$catalogue = $this->request->getPost('detail');
		}
		$insert = [];
		if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
			foreach($catalogue as $key => $val){
				if(isset($val) && is_array($val) && count($val)){
					foreach ($val as $keyChild => $valueChild) {
						$insert[] = array(
							'objectid' => $objectid,
							'catalogueid' => $valueChild,
							'module' => $this->data['module'],
							'type' => $key
						);
					}
				}
			}
		}
		$this->AutoloadModel->_delete([
			'table' => 'member_relationship',
			'where' => [
				'module' => $this->data['module'],
				'objectid' => $objectid
			]
		]);


		if(isset($insert) && is_array($insert) && count($insert)){
			$flag = $this->AutoloadModel->_create_batch([
				'data' => $insert,
				'table' => 'member_relationship'
			]);
		}

		return true;
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_member_exist',
			// 'catalogueid' => 'is_natural_no_zero',
			'fullname' => 'required',
		];
		$errorValidate = [
			'email' => [
				'check_email_member_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			// 'catalogueid' => [
			// 	'is_natural_no_zero' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Thành Viên'
			// ]
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
		// $detail = $this->request->getPost('detail');
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'gender' => (int)$this->request->getPost('gender'),
 			'image' => $this->request->getPost('image'),
 			'birthday' => $this->request->getPost('birthday'),
 			'address' => $this->request->getPost('address'),
 			// 'detail' => json_encode($detail),
 			'phone' => $this->request->getPost('phone'),
 			'cityid' => $this->request->getPost('cityid'),
 			'districtid' => $this->request->getPost('districtid'),
 			'wardid' => $this->request->getPost('wardid'),
 		];
 		if($this->request->getPost('password')){
 			$store['password'] = password_encode($this->request->getPost('password'), $salt);
 			$store['salt'] = $salt;
 			$store['created_at'] = $this->currentTime;
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 		}
 		return $store;
	}

}
