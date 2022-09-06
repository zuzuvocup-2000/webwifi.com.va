<?php 
namespace App\Controllers\Backend\Authentication;
use App\Controllers\BaseController;
use App\Libraries\Mailbie;

class Auth extends BaseController{
	protected $data;
	

	public function __construct(){
		$this->data = [];
	}

	public function login(){
		$session = session();
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email',
				'password' => 'required|min_length[6]|checkAuth['.$this->request->getVar('email').']|checkActive['.$this->request->getVar('email').']',
			];
			$errorValidate = [
				'password' => [
					'checkAuth' => 'Email Hoặc Mật khẩu không chính xác!',
					'checkActive' => 'Tài khoản của bạn đang bị khóa!',
				],
			];

 		 	if ($this->validate($validate, $errorValidate)){
		 		$user = $this->AutoloadModel->_get_where([
		 			'table' => 'user',
		 			'select' => 'id, fullname, email, (SELECT permission FROM user_catalogue WHERE user_catalogue.id = user.catalogueid) as permission',
		 			'where' => ['email' => $this->request->getVar('email'),'deleted_at' => 0]
		 		]);
		 		if(!empty($user['permission'])){
			 		$user['permission'] = json_decode($user['permission'],true);
			 		$cookieAuth = [
			 			'id' => $user['id'],
			 			'fullname' => $user['fullname'],
			 			'email' => $user['email'],
			 			// 'permission' => base64_encode($user['permission']),
			 		];
			 		$permission = [];
			 		$_SESSION['permission'] = $user['permission'];
			 		if(isset($user['permission']) && is_array($user['permission']) && count($user['permission'])){
			 			foreach ($user['permission'] as $value) {
			 			    if($value == 'All' || $value == 'folderView' || $value == 'folderCreate' || $value == 'folderRename' || $value == 'folderDelete' || $value == 'fileView' || $value == 'fileUpload' || $value == 'fileRename' || $value == 'fileDelete'){
			 			    	$permission[] = $value;
			 			    }
			 			}
			 		}

			 		setcookie(AUTH.'backend', json_encode($cookieAuth), time() + 1*24*3600, "/");
			 		setcookie(AUTH.'permission', json_encode($permission), time() + 1*24*3600, "/");
			 		$_update = [
			 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'remote_addr' => $_SERVER['REMOTE_ADDR']
			 		];
			 		$flag = $this->AutoloadModel->_update([
			 			'table' => 'user',
			 			'where' => ['id' => $user['id']],
			 			'data' => $_update
			 		]);
			 		if($flag > 0){
			 			$session->setFlashdata('message-success', 'Đăng nhập Thành Công');
			 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
			 		}
		 		}else{
		 			$session->setFlashdata('message-danger', 'Có lỗi xảy ra');
		 			return redirect()->to(BASE_URL.'admin');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		return view('backend/authentication/login', $this->data);
	}

	public function logout(){
	 	unset($_COOKIE[AUTH.'backend']); 
	 	unset($_COOKIE[AUTH.'permission']); 
        setcookie(AUTH.'backend', null, -1, '/'); 
        setcookie(AUTH.'permission', null, -1, '/'); 
        return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
	}

	public function forgot(){

		helper(['mymail']);
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email|check_email',
			];
			$errorValidate = [
				'email' => [
					'check_email' => 'Email không tồn tại trong hệ thống!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$user = $this->AutoloadModel->_get_where([
		 			'select' => 'id, fullname, email',
		 			'table' => 'user',
		 			'where' => ['email' => $this->request->getVar('email'),'deleted_at' => 0],
		 		]);

		 		$otp = $this->otp(); 
		 		$otp_live = $this->otp_time();
		 		$mailbie = new MailBie();
		 		$otpTemplate = otp_template([
		 			'fullname' => $user['fullname'],
		 			'otp' => $otp,
		 		]);

		 		$flag = $mailbie->send([
		 			'to' => $user['email'],
		 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
		 			'messages' => $otpTemplate,
		 		]);

		 		$update = [
		 			'otp' => $otp,
		 			'otp_live' => $otp_live,
		 		];
		 		$countUpdate = $this->AutoloadModel->_update([
		 			'table' => 'user',
		 			'data' => $update,
		 			'where' => ['id' => $user['id']],
		 		]);

		 		if($countUpdate > 0 && $flag == true){
		 			return redirect()->to(BASE_URL.'backend/authentication/auth/verify?token='.base64_encode(json_encode($user)));
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		return view('backend/authentication/forgot', $this->data);
	}

	public function verify(){
		helper('text');
		if($this->request->getMethod() == 'post'){
			$validate = [
				'otp' => 'required|check_otp',
			];
			$errorValidate = [
				'otp' => [
					'check_otp' => 'Mã OTP không chính xác hoặc đã hết thời gian sử dụng!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$user = json_decode(base64_decode($_GET['token']), TRUE);
		 		$salt = random_string('alnum', 168);
		 		$password = random_string('numeric', 6);
		 		$password_encode = password_encode($password, $salt);

		 		$update = [
		 			'password' => $password_encode,
		 			'salt' => $salt,
		 		];

		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'user',
		 			'data' => $update,
		 			'where' => ['id' => $user['id']]
		 		]);
		 		if($flag > 0){
		 			$mailbie = new Mailbie();
				 	$mailFlag = $mailbie->send([
			 			'to' => $user['email'],
			 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
			 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url(BACKEND_DIRECTORY).'">Click vào đây để tiến hành đăng nhập</a></div>',
			 		]);
			 		if($mailFlag == true){
			 			return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
			 		}
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		return view('backend/authentication/verify', $this->data);
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
