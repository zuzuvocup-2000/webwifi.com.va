<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Note extends BaseController{
	public function __construct(){}

	public function get_all(){
		$response = [];
		try {
			$id = $this->request->getPost('id');
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, description, created_at, userid_created',
				'table' => 'note',
			], true);
			if(isset($data) && is_array($data) && count($data)){
				$response = [
					'message' => 'Lấy dữ liệu ghi chú thành công!',
					'code' => 10,
					'result' => $data
				];
			}else{
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}

	public function get(){
		$response = [];
		try {
			$id = $this->request->getPost('id');
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, description, created_at, userid_created',
				'table' => 'note',
				'where' => [
					'id' => $id
				]
			]);
			if(isset($data) && is_array($data) && count($data)){
				$response = [
					'message' => 'Chọn ghi chú thành công!',
					'code' => 10,
					'result' => $data
				];
			}else{
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}

	public function search(){
		$response = [];
		try {
			$keyword = $this->request->getPost('keyword');
			$keyword = '(description LIKE \'%'.$keyword.'%\')';
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, description, created_at, userid_created',
				'table' => 'note',
				'keyword' => $keyword
			], true);
			if(isset($data) && is_array($data) && count($data)){
				$response = [
					'message' => 'Lấy dữ liệu ghi chú thành công!',
					'code' => 10,
					'result' => $data
				];
			}else{
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}

	public function save(){
		$response = [];
		try {
			$note = $this->request->getPost('note');
			$resultid = $this->AutoloadModel->_insert([
				'table' => 'note',
				'data' => [
					'description' => $note,
					'created_at' => $this->currentTime,
					'userid_created' => $this->auth['id']
				]
			]);
			if($resultid > 0){
				$response = [
					'message' => 'Tạo ghi chú thành công!',
					'code' => 10,
					'note' => $note,
					'id' => $resultid
				];
			}else{
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}

	public function update(){
		$response = [];
		try {
			$check = true;
			$note = $this->request->getPost('note');
			$id = $this->request->getPost('id');
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, description',
				'table' => 'note',
				'where' => [
					'id' => $id
				]
			]);
			if(isset($data) && is_array($data) && count($data)){
				$flag = $this->AutoloadModel->_update([
					'table' => 'note',
					'data' => [
						'description' => $note,
						'updated_at' => $this->currentTime,
						'userid_updated' => $this->auth['id']
					],
					'where' => [
						'id' => $id
					]
				]);
				if($flag > 0){
					$response = [
						'message' => 'Cập nhật ghi chú thành công!',
						'code' => 10,
					];
				}else{$check = false;}
			}else{$check = false;}
			if($check == false){
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}

	public function delete(){
		$response = [];
		try {
			$check = true;
			$id = $this->request->getPost('id');
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, description',
				'table' => 'note',
				'where' => [
					'id' => $id
				]
			]);
			if(isset($data) && is_array($data) && count($data)){
				$flag = $this->AutoloadModel->_delete([
					'table' => 'note',
					'where' => [
						'id' => $id
					]
				]);
				if($flag > 0){
					$response = [
						'message' => 'Xoá ghi chú thành công!',
						'code' => 10,
					];
				}else{$check = false;}
			}else{$check = false;}
			if($check == false){
				$response = [
					'message' => 'Có vấn đề xảy ra xin vui lòng thử lại!',
					'code' => 500
				];
			}
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}
		echo json_encode($response);die();
	}
}
