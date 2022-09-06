<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Article extends BaseController{
	
	public function __construct(){
	}
	public function deleteCat(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'article_catalogue',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id]
		]);
		echo $flag;die();
	}
	public function deleteArt(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'article',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id]
		]);
		echo $flag;die();
	}

	
}
