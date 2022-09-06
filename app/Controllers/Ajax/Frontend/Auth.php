<?php 
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;

class Auth extends FrontendController{
	
	public function __construct(){
		helper(['mymail','mystring','mydata','text']);
	}

	public function login(){
		$response = [];
		try {
			$param = $this->request->getPost('form');
			$user = $this->AutoloadModel->_get_where([
				'table' => 'member',
				'select' => 'id, fullname, check_promotion, email, password, salt, image, phone, address, promotion',
				'where' => ['phone' => $param['phone'],'deleted_at' => 0]
			]);
			$passwordEncode = password_encode($param['password'], (isset($user['salt']) ? $user['salt'] : ''));
			if(!isset($user) || is_array($user) == false || count($user) == 0 || $passwordEncode != $user['password']){
				$response['message'] = 'Tài khoản hoặc mật khẩu không chính xác!';
				$response['code'] = '99';
			}else{
				$user_active = $this->AutoloadModel->_get_where([
					'table' => 'member',
					'select' => 'id, fullname, email, password, salt',
					'where' => ['phone' => $param['phone'],'deleted_at' => 0,'publish' => 1]
				]);
				if(!isset($user_active) || is_array($user_active) == false || count($user_active) == 0){
					$response['message'] = 'Tài khoản của bạn đã bị khoá!';
					$response['code'] = '99';
				}else{
			 		$cookieAuth = [
			 			'id' => $user['id'],
			 			'fullname' => $user['fullname'],
			 			'email' => $user['email'],
			 			'address' => $user['address'],
			 			'promotion' => $user['promotion'],
			 			'check_promotion' => $user['check_promotion'],
			 			'phone' => $user['phone'],
			 		];
			 		// if($check_remember == 1){
			 			// setcookie(AUTH.'member', json_encode($cookieAuth), time() + 30*24*3600, "/");
			 		// }else{
			 			setcookie(AUTH.'member', json_encode($cookieAuth), time() + 1*24*3600, "/");
			 		// }
			 		$_update = [
			 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'remote_addr' => $_SERVER['REMOTE_ADDR'],
			 			'check_promotion' => 1
			 		];
			 		$flag = $this->AutoloadModel->_update([
			 			'table' => 'member',
			 			'where' => ['id' => $user['id']],
			 			'data' => $_update
			 		]);

			 		if($user['check_promotion'] == 0){
						$this->insert_promotion_first_login($user);
			 		}

			 		if($flag >0){
			 			$response['message'] = 'Đăng nhập thành công!';
						$response['code'] = '10';
			 		}else{
			 			$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại';
						$response['code'] = '99';
			 		}
				}
			}
	 	}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function insert_promotion_first_login($user){
		$promotion  = $this->AutoloadModel->_get_where([
			'select' => 'title, image, id',
			'table' => 'promotion',
			'where' => [
				'publish' => 1,
				'deleted_at' => 0,
				'login' => 1,
			],
		]);
		if(isset($promotion) && is_array($promotion) && count($promotion)){
			$this->AutoloadModel->_insert([
	 			'table' => 'promotion_relationship',
	 			'data' => [
	 				'memberid' => $user['id'],
	 				'promotionid' => $promotion ['id']
	 			]
	 		]);
		}
	}

	public function change_password(){
	 	$param = $this->request->getPost('form');
	 	$data = [];
	 	$store = [];
	 	foreach ($param as $key => $value) {
	 		$data[$value['name']] = $value['value'];
	 	}
	 	if($data['new_password'] != $data['confirm_password']){
	 		echo 'error_confirm';die();
	 	}

	 	$user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email ,password, salt',
			'where' => ['email' => $data['email']]
		]);
		$passwordEncode = password_encode($data['password'], $user['salt']);
		if(!isset($user) || is_array($user) == false || count($user) == 0){
			echo 'error_email';die();
		}
		if($passwordEncode != $user['password']){
			echo 'error_password';die();
		}

	 	$store['salt'] = random_string('alnum', 168);
	 	$store['password'] = password_encode($data['new_password'],$store['salt']);
		$store['publish'] = 1;
		$store['updated_at'] = $this->currentTime;
		$flag = $this->AutoloadModel->_update(['table'=>'member','data' => $store, 'where' => ['email' => $data['email'], 'deleted_at' =>0]]);
		if($flag > 0){
			echo 'success';die();
		}
	}

	public function send_otp_signup(){
		$response = [];
		try {
		 	$param = $this->request->getPost('form');
		 	$check_exist = $this->check_exist_account($param);
		 	if(isset($check_exist) && is_array($check_exist) && count($check_exist)){
		 		echo json_encode([
					'response' => $check_exist
				]);die();
		 	}
	 		$this->AutoloadModel->_delete([
		 		'table' => 'clipboard_signup',
		 		'where' => [
		 			'email' => $param['email'],
		 		]
		 	]);
		 	$param['id'] = $this->AutoloadModel->_insert([
		 		'table' => 'clipboard_signup',
		 		'data' => [
		 			'email' => $param['email'],
		 			'password' => $param['password'],
		 			'phone' => $param['phone'],
		 			'created_at' => $this->currentTime
		 		]
		 	]);

		 	$otp = $this->otp(); 
	 		$otp_live = $this->otp_time();
	 		$mailbie = new MailBie();
	 		$otpTemplate = otp_template_signup([
	 			'email' => $param['email'],
	 			'otp' => $otp,
	 		]);

	 		$flag = $mailbie->send([
	 			'to' => $param['email'],
	 			'subject' => 'Mã OTP đăng ký cho Email: '.$param['email'],
	 			'messages' => $otpTemplate,
	 		]);
	 		if($flag > 0){
		 		$update = [
		 			'otp' => $otp,
		 			'otp_live' => $otp_live,
		 		];
		 		$countUpdate = $this->AutoloadModel->_update([
		 			'table' => 'clipboard_signup',
		 			'data' => $update,
		 			'where' => ['id' => $param['id']],
		 		]);
		 		$response['message'] = 'Gửi mã OTP thành công! Xin vui lòng đăng nhập Email để lấy mã OTP!';
				$response['code'] = '10';
				$response['id'] = $param['id'];
	 		}else{
	 			$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại';
				$response['code'] = '99';
	 		}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function signup(){
		$response = [];
		try {
			helper(['text']);
		 	$store['id'] = $this->request->getPost('id');
		 	$store['otp'] = $this->request->getPost('otp');

		 	$count = $this->AutoloadModel->_get_where([
		 		'select' => 'otp, otp_live, phone, email, password',
		 		'table' => 'clipboard_signup',
		 		'where' => [
		 			'id' => $store['id'],
		 			'otp' => $store['otp']
		 		]
		 	]);
		 	if($count == [] || (strtotime($this->currentTime) > strtotime($count['otp_live']))){
		 		$response['message'] = 'Mã OTP đã hết hạn!';
				$response['code'] = '99';
		 	}else{
		 		$check_exist = $this->check_exist_account($count);
			 	if(isset($check_exist) && is_array($check_exist) && count($check_exist)){
			 		echo json_encode([
						'response' => $check_exist
					]);die();
			 	}
			 	$store['otp'] = $count['otp'];
			 	$store['otp_live'] = $count['otp_live'];

			 	$salt = random_string('alnum', 168);
		 		$store['password'] = password_encode($count['password'], $salt);
		 		$store['salt'] = $salt;
		 		$store['phone'] = $count['phone'];
		 		$store['email'] = $count['email'];
		 		$store['salt'] = $salt;
		 		$store['created_at'] = $this->currentTime;
				$store['publish'] = 1;
				$insertid = $this->AutoloadModel->_insert(['table' => 'member','data' => $store]);
				if($insertid > 0){
					$this->AutoloadModel->_delete([
						'table' => 'clipboard_signup',
						'where' => [
							'id' => $store['id']
						]
					]);

					$response['message'] = 'Đăng ký tài khoản thành công!';
					$response['code'] = '10';
				}else{
					$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
					$response['code'] = '99';
				}
		 	}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function send_otp_forgot(){
		$response = [];
		try {
		 	$param['email'] = $this->request->getPost('email');
			$check_email = $this->AutoloadModel->_get_where([
		 		'select' => 'id, fullname',
		 		'table' => 'member',
		 		'where' => [
		 			'email' => $param['email']
		 		],
		 	]);
		 	if(count($check_email) == 0){
		 		$response['message'] = 'Tài khoản không tồn tại!';
				$response['code'] = '99';
		 	}else{
			 	$otp = $this->otp(); 
		 		$otp_live = $this->otp_time();
		 		$mailbie = new MailBie();
		 		$otpTemplate = otp_template([
		 			'fullname' => $param['email'],
		 			'otp' => $otp,
		 		]);

		 		$flag = $mailbie->send([
		 			'to' => $param['email'],
		 			'subject' => 'Quên mật khẩu cho tài khoản: '.$param['email'],
		 			'messages' => $otpTemplate,
		 		]);

				$update = [
		 			'otp' => $otp,
		 			'otp_live' => $otp_live,
		 		];
		 		$countUpdate = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'data' => $update,
		 			'where' => ['id' => $check_email['id']],
		 		]);
		 		if($countUpdate > 0 && $flag == true){
		 			$response['message'] = 'Xin vòng đăng nhập vào Email để lấy mã xác thực OTP!';
					$response['code'] = '10';
					$response['id'] = $check_email['id'];
		 		}else{
		 			$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
					$response['code'] = '99';
		 		}
		 	}

	 	}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function get_new_password(){
		$response = [];
		try {
		 	$param['id'] = $this->request->getPost('id');
		 	$param['otp'] = $this->request->getPost('otp');
		 	$user = $this->AutoloadModel->_get_where([
		 		'select' => 'id, fullname, email, otp, otp_live',
		 		'table' => 'member',
		 		'where' => [
		 			'id' => $param['id'],
		 			'deleted_at' => 0
		 		],
		 	]);
			$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);
			if(strtotime($currentTime) > strtotime($user['otp_live']) || $user['otp'] != $param['otp']){
				$response['message'] = 'Mã OTP đã hết hạn hoặc không đúng!';
				$response['code'] = '99';
			}else{
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
		 			'where' => ['id' => $user['id']]
		 		]);
		 		if($flag > 0){
		 			$mailbie = new Mailbie();
				 	$mailFlag = $mailbie->send([
			 			'to' => $user['email'],
			 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
			 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url('login.html').'">Click vào đây để tiến hành đăng nhập</a></div>',
			 		]);
			 		$response['message'] = 'Mật khẩu mới đã được gửi vào Email của bạn!';
					$response['code'] = '10';
		 		}else{
			 		$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
					$response['code'] = '99';
		 		}
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function update_info_member(){
		helper(['text']);
	 	$store['fullname'] = $this->request->getPost('fullname');
	 	$store['id'] = $this->request->getPost('id');
	 	$store['email'] = $this->request->getPost('email');
	 	$store['current_password'] = $this->request->getPost('current_password');
	 	$store['new_password'] = $this->request->getPost('new_password');
	 	$store['address'] = $this->request->getPost('address');
	 	$store['phone'] = $this->request->getPost('phone');

	 	$check_exist = $this->AutoloadModel->_get_where([
	 		'select' => 'id, fullname, salt, password',
	 		'table' => 'member',
	 		'where' => [
	 			'id' => $store['id']
	 		]
	 	]);
	 	if(count($check_exist) == 0){
	 		echo 'no_exist';die();
	 	}
	 	if($store['current_password'] != '' && $store['new_password'] != ''){
		 	$passwordEncode = password_encode($store['current_password'], $check_exist['salt']);
			if($passwordEncode != $check_exist['password']){
				echo 'error_password';die();
			}

			$store['salt'] = random_string('alnum', 168);
		 	$store['password'] = password_encode($store['new_password'],$store['salt']);
			$store['publish'] = 1;
			$store['updated_at'] = $this->currentTime;
			$this->AutoloadModel->_update([
				'table'=>'member',
				'data' => [
					'salt' => $store['salt'],
					'password' => $store['password'],
					'publish' => 1,
				], 
				'where' => ['id' => $store['id'], 
				'deleted_at' =>0]
			]);
	 	}

	 	$flag = $this->AutoloadModel->_update([
	 		'table' => 'member',
	 		'data' => [
	 			'fullname' => $store['fullname'],
	 			'email' => $store['email'],
	 			'address' => $store['address'],
				'updated_at' => $this->currentTime,
	 			'phone' => $store['phone'],
	 		],
	 		'where' => [
	 			'deleted_at' => 0,
	 			'publish' => 1,
	 			'id' => $store['id']
	 		]
	 	]);

	 	if($flag > 0){
	 		echo 'success';die();
	 	}else{
	 		echo 'error';die();
	 	}
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

	private function check_exist_account($param = []){
		$response = [];
		$count = $this->AutoloadModel->_get_where([
	 		'select' => 'COUNT(tb1.id) as count_email, (SELECT COUNT(tb2.id) FROM member as tb2 WHERE tb2.phone = "'.$param['phone'].' AND tb2.deleted_at = 0")  as count_phone',
	 		'table' => 'member as tb1',
	 		'where' => [
	 			'tb1.email' => $param['email'],
	 			'tb1.deleted_at' => 0
	 		]
	 	]);

		if(isset($count['count_email']) && $count['count_email'] > 0){
			$response['message'] = 'Email đã tồn tại!';
			$response['code'] = '99';
		}

		if(isset($count['count_phone']) && $count['count_phone'] > 0){
			$response['message'] = 'Số điện thoại đã tồn tại!';
			$response['code'] = '99';
		}
	 	return $response;
	}
}
