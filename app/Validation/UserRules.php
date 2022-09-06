<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class UserRules {

	protected $AutoloadModel;
	protected $user;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	public function checkMemberAuth(string $phone = ''){
		$phone = trim($phone);
		$member = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, phone, password, salt',
			'table' => 'member',
			'where' => ['phone' => $phone]
		]);
		if(isset($member) && is_array($member) && count($member)){
			return false;
		}
		return true;
	}

	public function checkMember(){
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$this->member = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, email, salt, password',
			'where' => ['email' => $email,'deleted_at' => 0]
		]);
	
		if(!isset($this->member) || is_array($this->member) == false || count($this->member) == 0){
			return false;
		}

		$passwordEncode = password_encode($password, $this->member['salt']);
		if($passwordEncode != $this->member['password']){
			return false;
		}

		return true;
	}

	public function checkAuth(string $password = '' ,string $email = ''): bool{

		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0]
		]);

		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}

		$passwordEncode = password_encode($password, $this->user['salt']);
		if($passwordEncode != $this->user['password']){
			return false;
		}

		return true;
	}

	public function check_pass($oldPass = 0, $id = ''): bool{

		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email,password, salt',
			'where' => ['id' => $id]
		]);
		$passwordEncode = password_encode($oldPass, $this->user['salt']);
		
		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}
		if($passwordEncode != $this->user['password']){
			return  false;
		}
		return true;
	}

	public function check_pass_member($oldPass = 0, $id = ''): bool{

		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email,password, salt',
			'where' => ['id' => $id]
		]);
		$passwordEncode = password_encode($oldPass, $this->user['salt']);
		
		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}
		if($passwordEncode != $this->user['password']){
			return  false;
		}
		return true;
	}

	public function checkActive($password = '', $email = ''){
		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'user as tb1',
			'select' => 'tb1.id, tb1.fullname, tb1.email, tb1.password, tb1.salt',
			'where' => ['tb1.email' => $email,'tb1.deleted_at' => 0,'tb1.publish' => 1,'tb2.deleted_at' => 0,'tb2.publish' => 1],
			'join' => [
				[
					'user_catalogue as tb2', 'tb1.catalogueid = tb2.id', 'inner'
				]
			]
		]);

		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}

		return true;
	}

	public function check_email(string $email = ''){

		$count = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($count == 0){
			return false;
		}

		return true;
	}

	public function check_email_member(string $email = ''){

		$count = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($count == 0){
			return false;
		}

		return true;
	}

	public function check_otp(string $otp = ''){
		$token = $_GET['token'];
		$token = json_decode(base64_decode($token), TRUE);


		if(!isset($token) || is_array($token) == false || count($token) == 0){
			return false;
		}

		$user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'otp, otp_live',
			'where' => ['id' => $token['id'],'deleted_at' => 0],
		]);

		$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);

		if(strtotime($currentTime) > strtotime($user['otp_live'])){
			echo 2;die();
			return false;
		}

		if($user['otp'] != $otp){
			return false;
		}

		return true;

	}

	public function check_otp_member(string $otp = ''){
		$token = $_GET['token'];
		$token = json_decode(base64_decode($token), TRUE);

		if(!isset($token) || is_array($token) == false || count($token) == 0){
			return false;
		}

		$user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'otp, otp_live',
			'where' => ['id' => $token['id'],'deleted_at' => 0],
		]);

		$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);

		if(strtotime($currentTime) > strtotime($user['otp_live'])){
			return false;
		}

		if($user['otp'] != $otp){
			return false;
		}

		return true;

	}

	public function check_email_exist(string $email = ''){
		$emailOriginal = $this->request->getPost('email_original');
		$count = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($emailOriginal != $email){
			if($count > 0){
				return false;
			}
		}
		return true;
	}

	public function check_email_member_exist(string $email = ''){
		$emailOriginal = $this->request->getPost('email_original');
		$count = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($emailOriginal != $email){
			if($count > 0){
				return false;
			}
		}
		return true;
	}

}

