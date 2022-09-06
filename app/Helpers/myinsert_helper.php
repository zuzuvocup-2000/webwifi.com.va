<?php
use App\Models\AutoloadModel;


if (! function_exists('insert_router')){
	function insert_router($param = []){
		$model = new AutoloadModel();
		helper(['text']);
		$view = view_cells($param['module']);
		$router = $param['router'];
		if(!isset($router) && $router == ''){
			$view = view_cells($param['module']);
		}else{
			$view = $router;
		}
		$data = [
			'canonical' => $param['canonical'],  
			'module' => $param['module'],
			'objectid' => $param['id'],  
			'language' => $param['language'],  
			'view' => $view
		];
		$check = $model->_get_where([
			'select' => 'id',
 			'table' => 'router',
 			'where' => ['objectid' => $param['id'], 'module' => $param['module'], 'language' => $param['language']],
 			'count' => true
 		]);

 		if(isset($param['method'])  && $param['method'] == 'create' || $check == 0){	
 			$insertRouter = $model->_insert([
	 			'table' => 'router',
	 			'data' => $data,
	 		]);
 		}else{
 			$model->_update([
	 			'table' => 'router',
	 			'where' => ['objectid' => $param['id'], 'module' => $param['module'], 'language' => $param['language']],
	 			'data' => [
	 				'canonical' => $data['canonical'],
	 				'view' => $data['view'],
	 			]
	 		]);
 		}
 		return true;
	}
}

if (! function_exists('insert_tags')){
	function insert_tags($param = []){
		$model = new AutoloadModel();
		$tags_explode = explode(',', $param['tags']);
		$array_tag = [];
		foreach ($tags_explode as $key => $value) {
			array_push($array_tag, ['title' => $value]);
		}
		if(isset($array_tag) && is_array($array_tag) && count($array_tag)){
			foreach ($array_tag as $key => $value) {
				$array_tag[$key]['keyword'] = slug($array_tag[$key]['title']);
				$array_tag[$key]['module'] = $param['module'];
				$array_tag[$key]['language'] = $param['language'];
				$array_tag[$key]['objectid'] = $param['objectid'];
			}
			foreach ($array_tag as $key => $value) {
			    if($value['title'] == '' || $value['keyword'] == ''){
			    	unset($array_tag[$key]);
			    }
			}
		}
		$get_tags = $model->_delete([
			'table' => 'tag_relationship',
			'where' => [
				'module' => $param['module'],
				'objectid' => $param['objectid'],
				'language' => $param['language']
			]
		], true);
		if(isset($array_tag) && is_array($array_tag) && count($array_tag)){
			$flag = $model->_create_batch([
				'table' => 'tag_relationship',
				'data' => $array_tag
			]);
		}
	}
}


if (! function_exists('insert_wholesale')){
	function insert_wholesale(array $param = [], $module = '', $method = '' , $id = ''){
		$model = new AutoloadModel();
		$new_array = [];
		$module_explode = explode("_", $module);
		foreach ($param as $key => $value) {
			foreach ($param['number_start'] as $keyChild => $valChild) {
				if($param['number_start'][$keyChild] == '' && $param['number_end'][$keyChild] == '' && $param['wholesale_price'][$keyChild] == ''){
					unset($param['number_start'][$keyChild]);
					unset($param['number_end'][$keyChild]);
					unset($param['wholesale_price'][$keyChild]);
				}
			}
		}
		$start = json_encode($param['number_start']);
		$end = json_encode($param['number_end']);
		$price = [];
		foreach ($param['wholesale_price'] as $key => $value) {
			$param['wholesale_price'][$key] = str_replace('.', '', $value);
			$param['wholesale_price'][$key] = (float)$param['wholesale_price'][$key];

		}
		$price = json_encode($param['wholesale_price']);
		$store = [
			'objectid' => $id,
			'module' => $module,
			'number_start' => $start,
			'number_end' => $end,
			'price' => $price
		];
		if($method =='create'){
			$flag = $model->_insert([
				'table' => $module_explode[0].'_wholesale',
				'data' => $store
			]);
		}else{
			$flag = $model->_update([
				'table' => $module_explode[0].'_wholesale',
				'data' => $store,
				'where' => [
					'objectid' => $id,
					'module' => $module
				]
			]);

			if($flag == ''){
				$flag = $model->_insert([
					'table' => $module_explode[0].'_wholesale',
					'data' => $store
				]);
			}
		}

	 	return $flag;
	}
}

if (! function_exists('insert_version')){
	function insert_version(array $param = [], $objectid = '', $language = '', $method = '', $module = '', $type = ''){

		$model = new AutoloadModel();
		$new_array = [];
		$insert = [];
		$module_explode = explode("_", $module);
		if($method == 'update'){
			$delete = $model->_delete([
				'table' => $module_explode[0].'_version',
				'where' => ['objectid' => $objectid,'language' => $language]
			]);
		}
		$attribute['attribute_catalogue'] = array_shift($param);
		$attribute['attribute'] = array_shift($param);
		$new_attribute = [];
		if(isset($attribute) && is_array($attribute) && count($attribute)){
			foreach ($attribute as $key => $value) {
				if(isset($value) && is_array($value) && count($value)){
					foreach ($value as $keyChild => $valChild) {
						$new_attribute[$key][] = $attribute[$key][$keyChild];
					}
				}

			}
		}

		if($param['attribute1'] == [])	{
			$insert = [
				'objectid' => $objectid,
				'language' => $language,
				'attribute' => (isset($new_attribute['attribute'])) ? json_encode($new_attribute['attribute']) : '',
				'attribute_catalogue' => (isset($new_attribute['attribute_catalogue'])) ? $new_attribute['attribute_catalogue'] : '',
			];
			$flag =	$model->_insert([
				'table' => $module_explode[0].'_version',
				'data' => $insert,
			]);
		}else{
			foreach ($param as $key => $value) {
				foreach ($value as $keyChild => $valChild) {
					$new_array[$keyChild][$key] = $param[$key][$keyChild];
				}
			}
			if($type == 'normal'){
				foreach ($new_array as $key => $value) {
					$new_array[$key]['img_version'] = validate_input($value['img_version']);
				}
			}

			foreach ($new_array as $key => $value) {
				$insert[] = [
					'objectid' => $objectid,
					'language' => $language,
					'content' => json_encode($new_array[$key]),
					'checked' => $new_array[0]['checked'],
					'attribute' => json_encode($new_attribute['attribute']),
					'attribute_catalogue' => json_encode($new_attribute['attribute_catalogue']),
					'type' => $type,
				];
			}

			$flag =	$model->_create_batch([
				'table' => $module_explode[0].'_version',
				'data' => $insert,
			]);
		}
	}
}

if (! function_exists('insert_attribute_relationship')){
	function insert_attribute_relationship(array $param = [], $objectid = '', $language = '', $method = '', $module = '', $type = ''){
		$model = new AutoloadModel();
		$new_array = [];
		$insert = [];
		$module_explode = explode("_", $module);
		if($method == 'update'){
			$delete = $model->_delete([
				'table' => 'attribute_relationship',
				'where' => ['objectid' => $objectid,'module' => $module_explode[0]]
			]);
		}
		if($param != []){
			foreach ($param['attribute'] as $key => $value) {
				foreach ($value as $keyChild => $valueChild) {
					$new_array[] = [
						'objectid' => $objectid,
						'attributeid' => $valueChild,
						'module' => $module
					];
				}
			}

			$flag =	$model->_create_batch([
				'table' => 'attribute_relationship',
				'data' => $new_array,
			]);
		}
	}
}


?>
