<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Color extends BaseController{
	
	public function __construct(){
	}
	public function deleteColor(){
		$code = $this->request->getPost('code');
		$flag = $this->AutoloadModel->_update([
			'table' => 'color',
			'data' => ['deleted_at' => 1],
			'where' => ['code' => $code],
		]);
		
		
		echo $flag;die();
	}
	public function update(){
		$code = $this->request->getPost('code');
		$value = $this->request->getPost('value');
		$lang = $this->request->getPost('lang');
		$flag = 0;
		for ($i = 0; $i < count($code); $i++){
			$value[$i] = (($value[$i] == '') ? 'Chưa dịch' : $value[$i]);
			$flag = $this->AutoloadModel->_update([
			'table' => 'color',
			'data' => ['title' => $value[$i]],
			'where' => ['code' => $code[$i], 'language' => $lang[$i]],
		]);
		}
		
		
		
		echo $flag;die();
	}

	
}
