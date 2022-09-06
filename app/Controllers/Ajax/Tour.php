<?php 
namespace App\Controllers\Ajax;
use App\Libraries\Nestedsetbie;
use App\Controllers\BaseController;

class Tour extends BaseController{

	public $nestedsetbie;

	public function __construct(){
		helper('mydata');
		$this->nestedsetbie = new Nestedsetbie(['table' => 'menu','language' => $this->currentLanguage()]);
		
	}

	public function get_canonical(){
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');
		$flag = $this->AutoloadModel->_get_where([
			'select' => 'canonical',
			'table' => $param['module'].'_translate',
			'where' => [
				'objectid' => $param['id'],
				'module' => $param['module'],
				'language' => $this->currentLanguage()
			]
		]);
		echo $flag['canonical'];die();
	}

	public function get_select2(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['catalogueid'] = $this->request->getPost('catalogueid');
		if (isset($param['join']) && $param['join'] != '')
			{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'tb1.id, tb2.'.$param['select'].'',
					'table' => $param['module'].' as tb1',
					'join' => [
							[
								$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
							],
						],
					'where' => [
						'tb1.catalogueid' => $param['catalogueid']
					],
					'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
					'order_by' => ''.$param['select'].' asc'
				], TRUE);
			}else{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'id, '.$param['select'],
					'table' => $param['module'],
					'where' => [
						'catalogueid' => $param['catalogueid']
					],
					'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
					'order_by' => ''.$param['select'].' asc'
				], TRUE);
			}
		

		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}

		echo json_encode(array('items' => $temp));die();

	}

	public function pre_select2(){
		$param['value'] = json_decode($this->request->getPost('value'));
		$param['module'] = $this->request->getPost('module');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['catalogueid'] = $this->request->getPost('catalogueid');
		pre($param);
		$object = [];
		if($param['value'] != ''){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.'.$param['select'].'',
				'table' => $param['module'].' as tb1',
				'join' => [
						[
							$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
						],
					],
				'where' =>[
					'tb1.catalogueid' => $param['catalogueid']
				],
				'where_in' => $param['value'],
				'where_in_field' => 'tb2.objectid',
				'order_by' => ''.$param['select'].' asc'
			], TRUE);
		}
		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}
		echo json_encode(array('items' => $temp));die();
	}

	public function delete_all(){
		$id = $this->request->getPost('id');
		$module = $this->request->getPost('module');
		$flag = $this->AutoloadModel->_update([
			'table' => $module,
			'data' => ['deleted_at' => 1],
			'where_in' => $id,
			'where_in_field' => 'id',
		]);
		echo $flag;die();
	}

	public function render_data_detail(){
		$param['id'] = $this->request->getPost('id');
		$param['barcode'] = $this->request->getPost('barcode');
		$param['model'] = $this->request->getPost('model');
		$param['img'] = $this->request->getPost('img');
		echo json_encode($param);die();
	}
	public function render_input_version(){
		$param['id'] = $this->request->getPost('id');
		echo json_encode($param);die();
	}


	public function update_price(){
		$id = $this->request->getPost('id');
		$val = $this->request->getPost('val');
		$val = str_replace('.', '', $val);
		$val = (float)$val;
		$field = $this->request->getPost('field');
		$flag = $this->AutoloadModel->_update([
			'table' => 'tour',
			'data' => [$field => $val],
			'where' => [
				'id' => $id
			]
		]);

		$param['data'] = [
			'id' => $id,
			'val' => number_format($val,0,',','.'),
			'field' => $field
		];
		echo json_encode($param['data']);die();
	}

	public function general_id(){
		$param['suffix'] = $this->request->getPost('suffix');
		$param['data_0'] = $this->request->getPost('data_0');
		$param['prefix'] = $this->request->getPost('prefix');
		$param['module'] = $this->request->getPost('module');

		
		$num0 = '';
		for ($i=0; $i < $param['data_0']; $i++) { 
			$num0 = $num0.'0';
		}

		$code = $param['suffix'].'-'.$num0.'-'.$param['prefix'];

		$dataInsert = [
			'suffix' => $param['suffix'],
			'prefix' => $param['prefix'],
			'objectid' => 1,
			'num0' => $param['data_0'],
			'module' => $param['module'],
			'code' => $code,
		];
		$count = check_id_exist($param['module']);
		if($count == 0){
			$this->AutoloadModel->_insert([
				'table' => 'id_general',
				'data' => $dataInsert
			]);
		}else{
			$this->AutoloadModel->_delete([
				'table' => 'id_general',
				'where' => ['module' => $param['module']]
			]);
			$this->AutoloadModel->_insert([
				'table' => 'id_general',
				'data' => $dataInsert
			]);
		}
		
		die();		
	}

	public function add_brand(){
		$param['title'] = $this->request->getPost('title');
		$param['canonical'] = $this->request->getPost('canonical');
		$param['img'] = $this->request->getPost('img');
		$param['keyword'] = $this->request->getPost('keyword');

		$flag = $this->AutoloadModel->_insert([
			'table' => 'brand',
			'data' => [
				'image' => $param['img'],
				'created_at' => $this->currentTime,
				'deleted_at' => 0,
				'publish' => 1,
				'userid_created' => $this->auth['id']
			]
		]);

		if($flag > 0){
			$insert = $this->AutoloadModel->_insert([
				'table' => 'brand_translate',
				'data' => [
					'module' => 'brand',
					'objectid'=> $flag,
					'language' => $this->currentLanguage(),
					'canonical' => $param['canonical'],
					'title' => $param['title'],
					'keyword' => $param['keyword'],
					'created_at' => $this->currentTime,
					'deleted_at' => 0,
					'userid_created' => $this->auth['id']
				]
			]);
		}
		
		$param['data'] = [
			'title' => $param['title'],
			'value' => $flag,
		];
		echo json_encode($param['data']);
		die();		
	}

	public function add_attribute(){
		$param['title'] = $this->request->getPost('title');
		$param['val'] = $this->request->getPost('val');

		$count = check_attribute(slug($param['title']), 'attribute');
		if($count == 0){
			$flag = $this->AutoloadModel->_insert([
				'table' => 'attribute',
				'data' => [
					'catalogueid' => $param['val'],
					'created_at' => $this->currentTime,
					'deleted_at' => 0,
					'publish' => 1,
					'userid_created' => $this->auth['id']
				]
			]);

			if($flag > 0){
				$insert = $this->AutoloadModel->_insert([
					'table' => 'attribute_translate',
					'data' => [
						'module' => 'attribute',
						'objectid'=> $flag,
						'language' => $this->currentLanguage(),
						'canonical' => slug($param['title']),
						'title' => $param['title'],
						'userid_created' => $this->auth['id']
					]
				]);
			}
			
			$param['data'] = [
				'title' => $param['title'],
				'value' => $flag,
			];
			echo json_encode($param['data']);
			die();		
		}else{
			echo 1;die();
		}
	}

}
