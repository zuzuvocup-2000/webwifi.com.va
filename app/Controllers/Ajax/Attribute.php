<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Attribute extends BaseController{
	
	public function __construct(){
	}
	public function deleteCatalogue(){
		$id = $this->request->getPost('id');
		$level = $this->request->getPost('level');

		$flag = $this->AutoloadModel->_update([
			'table' => 'attribute_catalogue',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id],
		]);
		$result = $this->AutoloadModel->_update([
			'table' => 'attribute',
			'data' => ['deleted_at' => 1],
			'where' => [
				'catalogueid' => $id
			]
		]);
		
		
		
		echo $flag; die();
	}
	public function deleteAttribute(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_update([
			'table' => 'attribute',
			'data' => ['deleted_at' => 1],
			'where' => ['id' => $id],
		]);
		
		
		
		echo $flag;die();
	}
	
	

	
}
