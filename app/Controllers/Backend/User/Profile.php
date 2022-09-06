<?php namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;
use App\Models\AutoloadModel;
use App\Libraries\Mailbie;



class profile extends BaseController
{
	protected $data;
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'user';

	}

	public function profile($id = 0){
		$session = session();

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, phone, address, email, catalogueid, birthday, gender, cityid, districtid, wardid,image',
			'table' => $this->data['module'],
			'where' => ['id' => $id, 'deleted_at' =>0],
		]);

		if($this->request->getPost('reset')){
			$validation = $this->validation_pass($this->data[$this->data['module']]);


			if($this->validate($validation['validate'],$validation['errorValidate'])){
				$update = $this->store();
				$flag = $this->AutoloadModel->_update(['table'=>$this->data['module'],'data' => $update, 'where' => ['id' => $id, 'deleted_at' =>0]]);
				if($flag > 0){
					$session = session();
					$session->setFlashdata('message-success', 'Cập nhật người dùng Thành Công');
					return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
				}	 
			}
			else{
				$this->data['validate'] = $this->validator->getErrors();
			}
		}

		if($this->request->getPost('update')){
			$validation = $this->validation_update($this->data[$this->data['module']]);

			if($this->validate($validation['validate'],$validation['errorValidate'])){
				$update = $this->store();
				$flag = $this->AutoloadModel->_update(['table'=>$this->data['module'],'data' => $update, 'where' => ['id' => $id, 'deleted_at' =>0]]);
				if($flag > 0){
					$session = session();
					$session->setFlashdata('message-success', 'Cập nhật người dùng Thành Công');
					return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
				}	 
			}
			else{
				$this->data['validate'] = $this->validator->getErrors();
			}
		}



		$this->data['module'] = $this->data['module'];
		$this->data['template'] = 'backend/dashboard/common/profile';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function validation_update($user = []){
		$validate = [
			'catalogueid' => 'is_natural_no_zero',
			'fullname' => 'required|trim'
		];
		$errorValidate = [
			'fullname' => [
				'required' => 'Bạn cần điền vào trường họ tên!'
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn bắt buộc phải chọn Nhóm thành viên!'
			]
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate
		];
	}

	private function validation_pass($user = ''){
		$validate = [
			'old-password' => 'check_pass['.$user['id'].']',
			'password' => 'required|min_length[6]',
			're_password' => 'required|matches[password]',

		];
		$errorValidate = [
			'old-password' => [
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate
		];
	}


	private function store(){
		helper('text');
		$salt = random_string('alnum', 168);
		if($this->request->getPost('update')){
			$store = [
				'email' => $this->request->getPost('email'),
				'fullname' => $this->request->getPost('fullname'),
				'catalogueid' => (int)$this->request->getPost('catalogueid'),
				'gender' => (int)$this->request->getPost('gender'),
				'image' => $this->request->getPost('image'),
				'phone' => $this->request->getPost('phone'),
				'birthday' => $this->request->getPost('birthday'),
				'address' => $this->request->getPost('address'),
				'cityid' => $this->request->getPost('cityid'),
				'districtid' => $this->request->getPost('districtid'),
				'wardid' => $this->request->getPost('wardid'),
			];
		}
		

		if($this->request->getPost('reset')){
			$store['password'] = password_encode($this->request->getPost('password'),$salt);
			$store['salt'] = $salt;
			$store['publish'] = 1;


		}
		
		$store['updated_at'] = $this->currentTime;
		$store['userid_updated'] = $this->auth['id'];

		
		return $store;
	}
}
