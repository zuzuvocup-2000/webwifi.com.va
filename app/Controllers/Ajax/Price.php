<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Price extends BaseController{
	
	public function __construct(){
	}

	public function set_catalogue_price(){
		$val = $this->request->getPost('val');
		$type = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => 'price_catalogue',
			'where' => [
				'name' => 'type',
				'value' => $val
			],
			'count'=> true
		]);

		if($type == 0){
			$flag = $this->AutoloadModel->_insert([
				'table' => 'price_catalogue',
				'data' => [
					'name' => 'type',
					'value' => $val,
					'status' => 1
				],
			]);
		}else{
			$flag = $this->AutoloadModel->_update([
				'table' => 'price_catalogue',
				'data' => [
					'status' => 0
				],
				'where' => [
					'name' => 'type',
				],
			]);
			$flag = $this->AutoloadModel->_update([
				'table' => 'price_catalogue',
				'data' => [
					'status' => 1
				],
				'where' => [
					'name' => 'type',
					'value' => $val
				],
			]);
		}

		echo $val;die();
	}

	public function set_value_auto(){
		$apikey = $this->request->getPost('apikey');
		$secretkey = $this->request->getPost('secretkey');

		$this->AutoloadModel->_delete([
			'table' => 'price_catalogue',
			'where'=> [
				'name'=>'apikey',
			]
		]);
		$this->AutoloadModel->_delete([
			'table' => 'price_catalogue',
			'where'=> [
				'name'=>'secretkey',
			]
		]);

		$this->AutoloadModel->_create_batch([
			'table' => 'price_catalogue',
			'data'=> [
				[
					'name'=> 'apikey',
					'value'=> $apikey,
				],
				[
					'name'=> 'secretkey',
					'value'=> $secretkey,
				]
			]
		]);
	}

	public function set_value_normal(){
		$city = $this->request->getPost('city');
		$district = $this->request->getPost('district');
		$price = $this->request->getPost('price');
		$price = $this->request->getPost('price');
		$price = str_replace('.', '', $price);
		$price = (float)$price;
		$html = '';

		$count = $this->AutoloadModel->_get_where([
			'table' => 'price',
			'where'=> [
				'cityid'=> $city,
				'districtid'=> $district,
			],
			'count' => true
		]);
		if($count == 0){
			$id = $this->AutoloadModel->_insert([
				'table' => 'price',
				'data' => [
					'cityid'=> $city,
					'districtid'=> $district,
					'price' => $price
				],
			]);
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.price , tb2.name as city, tb3.name as district',
				'table' => 'price as tb1',
				'join' => [
					[
						'vn_province as tb2' , 'tb2.provinceid = tb1.cityid', 'inner'
					],
					[
						'vn_district as tb3' , 'tb3.provinceid = tb1.cityid AND tb3.districtid = tb1.districtid', 'inner'
					],
				],
				'where' => [
					'tb1.id' => $id
				]
			]);
			if(isset($object) && is_array($object) && count($object)){
				$html = $html .'<tr id="post-'.$object['id'].'" data-id="'.$object['id'].'">';
		            $html = $html .'<td>';
		                $html = $html .'<input type="checkbox" name="checkbox[]" value="'.$object['id'].'" class="checkbox-item">';
		                $html = $html .'<div for="" class="label-checkboxitem"></div>';
		            $html = $html .'</td>';
		            $html = $html .'<td> ';
		                $html = $html .$object['city'];
		            $html = $html .'</td>';
		             $html = $html .'<td> ';
		               $html = $html .$object['district'];
		            $html = $html .'</td>';
		            $html = $html .'<td class="text-center update_price td-status" >';
		                $html = $html .'<div class="view_price text-success">';
		                    $html = $html .((!empty($object['price'])) ? number_format(check_isset($object['price']),0,',','.') : '0');
		                $html = $html .'</div>';
		                $html = $html .'<input type="text" name="price" value="'.(($object['price'] != '' || $object['price'] == 0) ? $object['price'] : '0').'" data-id="'.$object['id'].'" data-field="price" class="int index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">';
		            $html = $html .'</td>';
		            $html = $html .'<td class="text-center">';
		                $html = $html .'<a type="button" data-id="'.$object['id'].'" class="btn btn-danger delete_price_ship"><i class="fa fa-trash"></i></a>';
		            $html = $html .'</td>';
		        $html = $html .'</tr>';
			}
		}else{
			$flag = $this->AutoloadModel->_update([
				'table' => 'price',
				'data' => [
					'price' => $price
				],
				'where'=> [
					'cityid'=> $city,
					'districtid'=> $district,
				],
			]);
		}

		echo json_encode(['html' => $html]);die();
	}

	public function update_price(){
		$id = $this->request->getPost('id');
		$val = $this->request->getPost('val');
		$val = str_replace('.', '', $val);
		$val = (float)$val;
		$field = $this->request->getPost('field');
		$flag = $this->AutoloadModel->_update([
			'table' => 'price',
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

	public function delete(){
		$id = $this->request->getPost('id');
		$flag = $this->AutoloadModel->_delete([
			'table' => 'price',
			'where'=> [
				'id'=> $id,
			]
		]);
		echo $flag;die();
	}
}
