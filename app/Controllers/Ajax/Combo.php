<?php 
namespace App\Controllers\Ajax;
use App\Libraries\Nestedsetbie;
use App\Controllers\BaseController;

class Combo extends BaseController{

	public $nestedsetbie;

	public function __construct(){
		helper('mydata');
		$this->nestedsetbie = new Nestedsetbie(['table' => 'menu','language' => $this->currentLanguage()]);
	}

	public function add_combo(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$form = $this->request->getPost('form');
			$param['module'] = $this->request->getPost('module');
			$param['type'] = $this->request->getPost('type');
			$param['form']['objectid'][] = $this->request->getPost('id');
			if(isset($form) && is_array($form) && count($form)){
				foreach ($form as $key => $value) {
					if($value['name'] == 'objectid' ){
						if($value['value'] != $param['form']['objectid'][0]){
							$param['form'][$value['name']][] = $value['value'];
						}
					}else{
						$param['form'][$value['name']]	 = $value['value'];
					}
				}
			}
			if(!isset($param['form']['objectid']) || !is_array($param['form']['objectid']) || count($param['form']['objectid']) <= 1){
			    $response['message'] = 'Bạn phải chọn ít nhất 1 sản phẩm để tạo Combo!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}

			$resultid = $this->create_combo($param);
			if($resultid > 0){
				$flag = $this->create_combo_relationship($resultid, $param);
				if($flag > 0){
					$response['message'] = 'Tạo Combo thành công!';
	 				$response['code'] = '10';
					echo json_encode($response);die();
				}else{
					$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
	 				$response['code'] = '23';
					echo json_encode($response);die();
				}
			}else{
				$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function delete_combo(){
		$id = $this->request->getPost('id');
		$module = $this->request->getPost('module');
		$flag = $this->AutoloadModel->_delete([
			'table' => 'combo',
			'where' => ['id' => $id, 'module' => $module],
		]);

		$flag = $this->AutoloadModel->_delete([
			'table' => 'combo_relationship',
			'where' => ['comboid' => $id, 'module' => $module],
		]);
		echo $flag;die();
	}

	public function update_combo(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$form = $this->request->getPost('form');
			$param['module'] = $this->request->getPost('module');
			$param['type'] = $this->request->getPost('type');
			$param['comboid'] = $this->request->getPost('comboid');
			if(isset($form) && is_array($form) && count($form)){
				foreach ($form as $key => $value) {
					if($value['name'] == 'objectid' ){
						$param['form'][$value['name']][] = $value['value'];
					}else{
						$param['form'][$value['name']]	 = $value['value'];
					}
				}
			}
			if(!isset($param['form']['objectid']) || !is_array($param['form']['objectid']) || count($param['form']['objectid']) <= 1){
			    $response['message'] = 'Bạn phải chọn ít nhất 2 sản phẩm để tạo Combo!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}

			$resultid = $this->update_combo_change($param);
			if($resultid > 0){
				$flag = $this->update_combo_relationship( $param);
				if($flag > 0){
					$response['message'] = 'Cập nhật Combo thành công!';
	 				$response['code'] = '10';
					echo json_encode($response);die();
				}else{
					$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
	 				$response['code'] = '23';
					echo json_encode($response);die();
				}
			}else{
				$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function create_combo_relationship($id = 0, $param = []){
		$store = [];
		$flag = 0;
		if(isset($param['form']['objectid']) && is_array($param['form']['objectid']) && count($param['form']['objectid'])){
			foreach ($param['form']['objectid'] as $key => $value) {
			    $store[$key] = [
			    	'comboid' => $id,
			    	'objectid' => $value,
			    	'module' => $param['module']
			    ];
			}
		}
		if(isset($store) && is_array($store) && count($store)){
			$flag = $this->AutoloadModel->_create_batch([
				'table' => 'combo_relationship',
				'data' => $store
			]);
		}
		return $flag;
	}

	public function create_combo($param = []){
		$store = [
			'objectid' => json_encode($param['form']['objectid']),
			'module' => $param['module'],
			'type' => $param['form']['type'],
			'text' => $param['type'],
			'value' => $param['form']['value'],
			'time_end' => $param['form']['time_end'],
			'created_at' => $this->currentTime,
			'userid_created' => $this->auth['id'],
		];
		$flag = $this->AutoloadModel->_insert([
			'table' => 'combo',
			'data' => $store
		]);
		return $flag;
	}

	public function update_combo_relationship($param = []){
		$store = [];
		$flag = 0;
		$this->AutoloadModel->_delete([
			'table' => 'combo_relationship',
			'where' => [
				'comboid' => $param['comboid']
			]
		]);
		if(isset($param['form']['objectid']) && is_array($param['form']['objectid']) && count($param['form']['objectid'])){
			foreach ($param['form']['objectid'] as $key => $value) {
			    $store[$key] = [
			    	'comboid' => $param['comboid'],
			    	'objectid' => $value,
			    	'module' => $param['module']
			    ];
			}
		}
		if(isset($store) && is_array($store) && count($store)){
			$flag = $this->AutoloadModel->_create_batch([
				'table' => 'combo_relationship',
				'data' => $store
			]);
		}
		return $flag;
	}

	public function update_combo_change($param = []){
		$store = [
			'objectid' => json_encode($param['form']['objectid']),
			'module' => $param['module'],
			'type' => $param['form']['type'],
			'text' => $param['type'],
			'value' => $param['form']['value'],
			'time_end' => $param['form']['time_end'],
			'created_at' => $this->currentTime,
			'userid_created' => $this->auth['id'],
		];
		$flag = $this->AutoloadModel->_update([
			'table' => 'combo',
			'where' => [
				'id' => $param['comboid']
			],
			'data' => $store
		]);
		return $flag;
	}

	public function get_data_combo(){
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');
		$catalogueid = $this->AutoloadModel->_get_where([
			'select' => 'comboid',
			'table' => 'combo_relationship',
			'where' => [
				'module' => $param['module'],
				'objectid' => $param['id']
			],
			'group_by' => 'comboid'
		], true);
		$catalogue = [];
		$object = [];
		if(isset($catalogueid) && is_array($catalogueid) && count($catalogueid)){
			foreach ($catalogueid as $key => $value) {
			    $catalogue[] = $value['comboid'];
			}
		}
		if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.type, tb1.value, tb1.time_end, tb2.objectid, tb3.title',
				'table' => 'combo as tb1',
				'join' => [
					[
						'combo_relationship as tb2', 'tb1.id = tb2.comboid AND tb2.module = \''.$param['module'].'\' ','inner'
					],
					[
						'product_translate as tb3', 'tb2.objectid = tb3.objectid AND tb3.module = \''.$param['module'].'\' AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
					],
				],
				'group_by' => 'tb2.objectid, tb1.id',
				'order_by' => 'tb1.time_end asc',
				'where_in' => $catalogue,
				'where_in_field' => 'tb1.id',
			], TRUE);
		}
		$arr['data'] = [];
		$arr['count'] = 0;

		if(isset($object) && is_array($object) && count($object)){
			foreach ($object as $key => $value) {
			    $arr['data'][$value['id']][] = $value;
			}
		}
		$arr['count'] = count($arr['data']);
		echo json_encode($arr);die();
	}

	public function get_product(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');

		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => $param['module'].' as tb1',
			'join' => [
					[
						$param['module'].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					],
				],
			'where' => [
				'tb1.deleted_at' => 0
			],		
			'keyword' => '(tb2.title LIKE \'%'.$param['keyword'].'%\')',
		], TRUE);
		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val['title'],
				);
			}
		}

		echo json_encode(array('items' => $temp));die();
	}

}