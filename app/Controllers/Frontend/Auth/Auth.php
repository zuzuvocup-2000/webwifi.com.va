<?php
namespace App\Controllers\Frontend\Auth;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;

class Auth extends FrontendController{

	public $data = [];
	public function __construct(){
		$this->data['language'] = $this->currentLanguage();
	}
	public function login(){
		$this->data['general'] = $this->general;

        $panel = get_panel([
			'locate' => 'login',
			'language' => $this->data['language']
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}

		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required',
				'password' => 'required|min_length[5]|checkMember['.$this->request->getPost('email').']',
			];
			$errorValidate = [
				'password' => [
					'checkMember' => 'Tài khoản Hoặc Mật khẩu không chính xác!',
				],
			];
 		 	if ($this->validate($validate, $errorValidate)){
		 		$member = $this->AutoloadModel->_get_where([
		 			'table' => 'member',
		 			'select' => 'id, fullname, email, phone, image, birthday',
		 			'where' => ['email' => $this->request->getPost('email'),'deleted_at' => 0]
		 		]);
		 		$cookieAuth = [
		 			'id' => $member['id'],
		 			'fullname' => $member['fullname'],
		 			'email' => $member['email'],
		 			'image' => $member['image'],
		 			'birthday' => $member['birthday'],
		 		];
		 		setcookie(AUTH.'member', json_encode($cookieAuth), time() + 1*24*3600, "/");
		 		$_update = [
		 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'remote_addr' => $_SERVER['REMOTE_ADDR']
		 		];
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'where' => ['id' => $member['id']],
		 			'data' => $_update
		 		]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Đăng nhập Thành Công');
		 			return redirect()->to(BASE_URL);
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['meta_title'] = (!empty($this->genera['seo_meta_title'])) ? $this->genera['seo_meta_title'] : 'Đăng nhập/Đăng ký tài khoản';

        $this->data['template'] = 'frontend/auth/login/index';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function signup(){
		helper('mydata');
		$this->data['general'] = $this->general;
        return view('frontend/auth/signup/index', $this->data);
	}

	public function forgot(){
		$panel = get_panel([
			'locate' => 'login',
			'language' => $this->data['language']
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}
		helper(['mymail']);
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email|check_email_member',
			];
			$errorValidate = [
				'email' => [
					'check_email_member' => 'Email không tồn tại trong hệ thống!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$member = $this->AutoloadModel->_get_where([
		 			'select' => 'id, fullname, email',
		 			'table' => 'member',
		 			'where' => ['email' => $this->request->getVar('email'),'deleted_at' => 0],
		 		]);

		 		$otp = $this->otp(); 
		 		$otp_live = $this->otp_time();
		 		$mailbie = new MailBie();
		 		$otpTemplate = otp_template([
		 			'fullname' => $member['fullname'],
		 			'otp' => $otp,
		 		]);

		 		$flag = $mailbie->send([
		 			'to' => $member['email'],
		 			'subject' => 'Quên mật khẩu cho tài khoản: '.$member['email'],
		 			'messages' => $otpTemplate,
		 		]);

		 		$update = [
		 			'otp' => $otp,
		 			'otp_live' => $otp_live,
		 		];
		 		$countUpdate = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'data' => $update,
		 			'where' => ['id' => $member['id']],
		 		]);

		 		if($countUpdate > 0 && $flag == true){
		 			return redirect()->to(BASE_URL.'verify.html?token='.base64_encode(json_encode($member)));
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['general'] = $this->general;
		$this->data['template'] = 'frontend/auth/forgot/index';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function verify(){
		helper('text');
		$panel = get_panel([
			'locate' => 'login',
			'language' => $this->data['language']
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'otp' => 'required|check_otp_member',
			];
			$errorValidate = [
				'otp' => [
					'check_otp_member' => 'Mã OTP không chính xác hoặc đã hết thời gian sử dụng!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$member = json_decode(base64_decode($_GET['token']), TRUE);
		 		$salt = random_string('alnum', 168);
		 		$password = random_string('numeric', 6);
		 		$password_encode = password_encode($password, $salt);
		 		$update = [
		 			'password' => $password_encode,
		 			'salt' => $salt,
		 		];

		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'data' => $update,
		 			'where' => ['id' => $member['id']]
		 		]);
		 		if($flag > 0){
		 			$mailbie = new Mailbie();
				 	$mailFlag = $mailbie->send([
			 			'to' => $member['email'],
			 			'subject' => 'Quên mật khẩu cho tài khoản: '.$member['email'],
			 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url(BACKEND_DIRECTORY).'">Click vào đây để tiến hành đăng nhập</a></div>',
			 		]);
			 		if($mailFlag == true){
			 			return redirect()->to(BASE_URL.'login.html');
			 		}
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['general'] = $this->general;
		$this->data['template'] = 'frontend/auth/verify/index';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function logout(){
		unset($_COOKIE[AUTH.'member']);
        setcookie(AUTH.'member', null, -1, '/');
        return redirect()->to(BASE_URL);
	}

	private function otp(){
		helper(['text']);
		$otp = random_string('numeric', 6);
		return $otp;
	}

	private function otp_time(){
		$timeToLive = gmdate('Y-m-d H:i:s', time() + 7*3600 + 300);
		return $timeToLive;
	}
}
