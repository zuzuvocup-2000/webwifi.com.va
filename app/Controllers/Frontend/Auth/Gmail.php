<?php
namespace App\Controllers\Frontend\Auth;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;
use Google_Client;
use Google_Service_Oauth2;

class Gmail extends FrontendController{

	public $data = [];
	public function __construct(){
		$this->data['language'] = $this->currentLanguage();
		$this->google_client = new Google_Client();
		$this->google_service = new Google_Service_Oauth2($this->google_client);
	}
	public function login(){
		$session = session();
		if(isset($_GET['code'])){
			$this->google_client->setClientId(GOOGLE_CLIENT_ID);
		    $this->google_client->setClientSecret(GOOGLE_SECRET_ID);
		    $this->google_client->setRedirectUri(BASE_URL.'login-gmail');
		    $this->google_client->addScope('email');
		    $this->google_client->addScope('profile');
		 	//It will Attempt to exchange a code for an valid authentication token.
		 	$token = $this->google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
		 	//This condition will check there is any error occur during geting authentication token. If 	there is no any error occur then it will execute if block of code/
		 	if(!isset($token['error'])){
				//Set the access token used for requests
				$this->google_client->setAccessToken($token['access_token']);

				//Store "access_token" value in $_SESSION variable for future use.
				$_SESSION['access_token'] = $token['access_token'];

				//Create Object of Google Service OAuth 2 class

				//Get user profile data from google
				$data = $this->google_service->userinfo->get();

			  	if(!empty($data['name'])) $store['fullname'] = $data['name'];
			  	if(!empty($data['email'])) $store['email'] = $data['email'];
			  	if(!empty($data['gender'])) $store['gender'] = $data['gender'];
			  	if(!empty($data['picture'])) $store['image'] = $data['picture'];
			  	if(!empty($data['id'])) $store['id_social'] = $data['id'];

			  	if(isset($store) && is_array($store) && count($store)){
			  		$user = $this->check_login_social($store['id_social'], 'gmail');
			  		if(!isset($user) || !is_array($user) || count($user) == 0){
			  			$store['id'] = $this->insert_new_account_social($store, 'gmail');
			  			$store['check_promotion'] = 0;
			  		}else{
			  			$store = $user;
			  		}

		  			$this->login_social($store);
			  	}
		 	}
			$session->setFlashdata('message-succes', 'Đăng nhập thành công!');
		}else{
			$session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
		}
		return redirect()->to(BASE_URL);
	}

	public function check_login_social($id = '', $social = ''){
		$user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => '*',
			'where' => ['id_social' => $id,'deleted_at' => 0, 'social' => $social, 'publish' => 1]
		]);

		return $user;
	}

	public function insert_new_account_social($store = [], $social = ''){
		$store['created_at'] = $this->currentTime;
		$store['publish'] = 1;
		$store['social'] = $social;

		$insertid = $this->AutoloadModel->_insert(['table' => 'member','data' => $store]);

		return $insertid;
	}

	public function login_social($store = []){
		setcookie(AUTH.'member', json_encode($store), time() + 1*24*3600, "/");
		$_update = [
 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
 			'check_promotion' => 1
 		];

 		$flag = $this->AutoloadModel->_update([
 			'table' => 'member',
 			'where' => ['id' => $store['id']],
 			'data' => $_update
 		]);

 		if($store['check_promotion'] == 0){
			$this->insert_promotion_first_login($store);
 		}
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
}
