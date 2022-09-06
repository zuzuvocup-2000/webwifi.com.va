<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Language extends BaseController{
	
	public function __construct(){
	}


	public function update_default_language(){
		$post['id'] = $this->request->getPost('id');
		$post['lang'] = $this->request->getPost('lang');

		setcookie('BACKEND_language', $post['lang'] , time() + 1*24*3600, "/");
		echo 1;die();
	}

}
