<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Contact extends BaseController{
	
	public function __construct(){
	}
	
	public function deleteContact(){
		$id = $this->request->getPost('id');
		$language = $this->request->getPost('language');
		$flag = $this->AutoloadModel->_update([
			'table' => 'contact_catalogue',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id]
		]);
		if ($flag > 0){
			$delete = $this->AutoloadModel->_update([
				'table' => 'contact_translate',
				'data' => ['deleted_at' => 1],
				'where' => ['objectid' => $id, 'language' => $language]
			]);
		}

		echo $flag;die();
	}
	public function delete1Contact(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'contact',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id]
		]);

		echo $flag;die();
	}


	
}
