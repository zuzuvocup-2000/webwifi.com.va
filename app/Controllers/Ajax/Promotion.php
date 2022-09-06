<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Promotion extends BaseController{

	public function __construct(){
	}

	public function update_field_login(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['field'] = $this->request->getPost('field');
		$object = $this->AutoloadModel->_get_where([
			'select' => 'id, '.$post['field'],
			'table' => $post['module'],
			'where' => ['id' => $post['id']],
		]);
		if(!isset($object) || is_array($object) == false || count($object) == 0){
			echo 0;
			die();
		}
		$_update[$post['field']] = (($object[$post['field']] == 1)?0:1);
		$flag = $this->AutoloadModel->_update([
			'data' => [
				$post['field'] => 0
			],
			'table' => $post['module'],
		]);

		$flag = $this->AutoloadModel->_update([
			'data' => [
				$post['field'] => 1
			],
			'table' => $post['module'],
			'where' => ['id' => $post['id']]
		]);
		echo json_encode([
			'flag' => $flag,
			'value' => $_update[$post['field']],
		]);
		die();
	}

	public function update_price_promotion(){
		$id = $this->request->getPost('id');
		$val = $this->request->getPost('val');
		$field = $this->request->getPost('field');
		$flag = $this->AutoloadModel->_update([
			'table' => 'promotion',
			'data' => [$field => $val],
			'where' => [
				'id' => $id
			]
		]);

		$param['data'] = [
			'id' => $id,
			'val' => $val,
			'field' => $field
		];
		echo json_encode($param['data']);die();
	}
}
