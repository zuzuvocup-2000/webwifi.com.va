<?php 
namespace App\Libraries;

class Cartbie{
	public $request;
	function __construct($params = NULL){
		$this->request = \Config\Services::request();
	}

	

	public function get(){
		$getCookie = [];
	 	if(!isset($_COOKIE['cart_cookie']) || empty($_COOKIE['cart_cookie'])){
	 		setcookie('cart_cookie', '', time() + 1*24*3600, "/");
	 	}else{
	 		$getCookie = $this->content();
	 	}
	 	return $getCookie;
	}

	public function insert($param = []){
		$cookie = base64_encode(json_encode($param));
		setcookie('cart_cookie', $cookie, time() + 1*24*3600, "/");
		return true;
	}

	public function delete($code = ''){
		$content = $this->get();
		foreach ($content as $key => $value) {
			if($value['code'] == $code){
				unset( $content[$key] );
			}
		}
		$this->insert($content);
		return true;
	}

	public function delete_all(){

	}

	public function content(){
		$getCookie = $this->request->getCookie('cart_cookie');
		$data_cookie = json_decode(base64_decode($getCookie),TRUE);
		return $data_cookie;
	}

	public function handle_cookie($param = [], $cookie = []){
		$code = [];
		foreach ($cookie as $key => $value) {
			$abc = [];
			$abc = [
				'code' => $value['code'],
				'quantity' =>  $value['quantity']
			];
			array_push($code,$abc);
		}
		$check = false;
		$edit = [];
		foreach ($code as $key => $value) {
			if($value['code'] == $param['code']){
				$edit['quantity'] = $value['quantity'] + 1;
				$edit['code'] = $value['code'];
				$check = true;
			}
		}
		if($check == true){
			foreach ($cookie as $key => $value) {
				if($value['code'] == $edit['code']){
					$cookie[$key]['title'] = $param['title'];
					$cookie[$key]['price'] = $param['price'];
					$cookie[$key]['avatar'] = $param['avatar'];
					$cookie[$key]['url'] = $param['url'];
					$cookie[$key]['quantity'] = $edit['quantity'];
				}
			}
			return $cookie;
		}else{
			$param['quantity'] = 1;
			array_push($cookie,$param);
			return $cookie;
		}
	}
}