<?php
namespace App\Controllers\Frontend\Auth;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;
class Fb extends FrontendController{
	public $data = [];
	public function __construct(){
		$this->data['language'] = $this->currentLanguage();
	}
	public function login(){
		$session = session();
		
		// Từ đây bạn xử lý kiểm tra thông tin user trong database sau đó xử lý.

		if(isset($_POST['data'])){
			$store = [
				'fullname' => $_POST['data']['name'],
				'id_social' => $_POST['data']['id'],
			];
		  	if(isset($store) && is_array($store) && count($store)){
		  		$user = $this->check_login_social($store['id_social'], 'facebook');
		  		if(!isset($user) || !is_array($user) || count($user) == 0){
		  			$store['id'] = $this->insert_new_account_social($store, 'facebook');
		  			$store['check_promotion'] = 0;
		  		}else{
		  			$store = $user;
		  		}
	  			$this->login_social($store);
		  	}
			echo 1;die();
		}else{
			echo 0;die();
		}
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
