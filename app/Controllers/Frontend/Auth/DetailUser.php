<?php
namespace App\Controllers\Frontend\Auth;
use App\Controllers\FrontendController;

class DetailUser extends FrontendController{

	public $data = [];

	public function __construct(){
		$this->data['language'] = $this->currentLanguage();
		$this->data['module'] = 'member';
		$this->auth = (isset($_COOKIE[AUTH.'member']) && $_COOKIE[AUTH.'member'] != '' ? json_decode($_COOKIE[AUTH.'member'],TRUE) : []);
	}

	public function index(){
		$this->data['user'] = $this->AutoloadModel->_get_where([
			'select' => 'fullname, id, address, phone, image, gender, birthday, email, cityid, districtid, wardid, description, facebook_link, instagram_link',
			'table' => 'member',
			'where' => [
				'publish' => 1,
				'deleted_at' => 0,
				'id' => $this->auth['id']
			]
		]);

		$this->data['promotion'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.title, tb2.image, tb2.promotionid, tb2.discount_value, tb1.used, tb1.used_at',
			'table' => 'promotion_relationship as tb1',
			'join' => [
				[
					'promotion as tb2', 'tb2.id = tb1.promotionid', 'inner'
				],
				[
					'member as tb3', 'tb3.id = tb1.memberid', 'inner'
				],
			],
			'where' => [
				'tb3.publish' => 1,
				'tb3.deleted_at' => 0,
				'tb2.publish' => 1,
				'tb2.deleted_at' => 0,
				'tb1.memberid' => $this->auth['id']
			]
		], true);
		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL.'thong-tin-chi-tiet'.HTSUFFIX;

		$this->data['home'] = 'detail_user';
        $this->data['template'] = 'frontend/auth/detail/index';
        return view('frontend/homepage/layout/home', $this->data);
	}

	public function update(){
		$session = session();
		$update = $this->store_update();
		$flag = $this->AutoloadModel->_update(['table'=>$this->data['module'],'data' => $update, 'where' => ['id' => $this->auth['id'], 'deleted_at' =>0]]);
		if($flag > 0){
			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công!');
		}else{
			$session->setFlashdata('message-danger', 'Có lỗi xảy ra!Xin vui lòng thử lại!');
		}
		return redirect()->to(BASE_URL.'thong-tin-chi-tiet');
	}

	public function change_pass(){
		$session = session();
		$validation = $this->validation_pass();
		if($this->validate($validation['validate'],$validation['errorValidate'])){
			$update = $this->store_pass();
			$flag = $this->AutoloadModel->_update(['table'=>$this->data['module'],'data' => $update, 'where' => ['id' => $this->auth['id'], 'deleted_at' =>0]]);
			if($flag > 0){
				$session->setFlashdata('message-success', 'Cập nhật mật khẩu thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có lỗi xảy ra!Xin vui lòng thử lại!');
			}
		}else{
			$this->data['validate'] = $this->validator->getErrors();
			foreach ($this->data['validate'] as $value) {
				$session->setFlashdata('message-danger', $value);
				break;
			}
		}
		return redirect()->to(BASE_URL.'thong-tin-chi-tiet');
	}

	private function store_update(){
		helper('text');
		$salt = random_string('alnum', 168);
		$store = [
			'fullname' => $this->request->getPost('fullname'),
			'gender' => (int)$this->request->getPost('gender'),
			'birthday' => date('Y-m-d', strtotime($this->request->getPost('birthday'))),
			'address' => $this->request->getPost('address'),
			'phone' => $this->request->getPost('phone'),
			'email' => $this->request->getPost('email'),
			'facebook_link' => $this->request->getPost('facebook_link'),
			'instagram_link' => $this->request->getPost('instagram_link'),
		];

		$store['updated_at'] = $this->currentTime;
		return $store;
	}

	private function store_pass(){
		helper('text');
		$salt = random_string('alnum', 168);
		$store['password'] = password_encode($this->request->getPost('new_password'),$salt);
		$store['salt'] = $salt;
		$store['updated_at'] = $this->currentTime;
		return $store;
	}

	private function validation_pass(){
		$validate = [
			'old_password' => 'check_pass_member['.$this->auth['id'].']',
			'new_password' => 'required',
			're_password' => 'required|matches[new_password]',

		];
		$errorValidate = [
			'old_password' => [
				'check_pass_member' => 'Mật khẩu hiện tại không chính xác!'
			],
			're_password' => [
				'matches' => 'Mật khẩu nhập lại không đúng!'
			]
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate
		];
	}
}
