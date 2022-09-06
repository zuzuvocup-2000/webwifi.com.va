<?php 
namespace App\Controllers\Ajax;
use App\Libraries\Nestedsetbie;
use App\Controllers\BaseController;

class Product extends BaseController{

	public $nestedsetbie;

	public function __construct(){
		helper('mydata');
		$this->nestedsetbie = new Nestedsetbie(['table' => 'menu','language' => $this->currentLanguage()]);
		
	}

	public function update_object(){
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');
		$param['form'] = $this->request->getPost('form');

		$flag = $this->authentication->check_permission([
			'routes' => 'change_image'
		]);


		if($flag == false){
 			echo json_encode([
				'code' => 500,
				'message' => 'Bạn không có quyền truy cập vào chức năng này!'
			]);die();
		}

		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.album, tb1.image, tb2.title, tb2.description, tb2.content',
			'table' => $param['module'].' as tb1',
			'join' =>  [
				[
					'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'','inner'
				]
			],
			'where' => ['tb1.id' => $param['id'],'tb1.deleted_at' => 0]
		]);

		if(!isset($object) || !is_array($object) || count($object) == 0){
			echo json_encode([
				'code' => 404,
				'message' => 'Sản phẩm không tồn tại! Xin vui lòng thử lại!'
			]);die();
		}
		$store = [
			'title' => $param['form']['title'],
			'description' => base64_encode($param['form']['description']),
			'content' => base64_encode($param['form']['content']),
			'updated_at' => $this->currentTime
		];
		
		$flag = $this->AutoloadModel->_update([
 			'table' => 'product_translate',
 			'where' => ['objectid' => $param['id'],'module' => $param['module'],'language' => $this->currentLanguage()],
 			'data' => $store
 		]);

 		if($flag > 0){
 			echo json_encode([
				'code' => 10,
				'message' => 'Cập nhật thông tin sản phẩm thành công!'
			]);die();
 		}
	}

	public function get_product_detail(){
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');

		$flag = $this->authentication->check_permission([
			'routes' => 'change_image'
		]);

		if($flag == false){
 			echo json_encode([
				'code' => 500,
				'message' => 'Bạn không có quyền truy cập vào chức năng này!'
			]);die();
		}

		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.album, tb1.image, tb2.title, tb2.description, tb2.content',
			'table' => $param['module'].' as tb1',
			'join' =>  [
				[
					'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\'','inner'
				]
			],
			'where' => ['tb1.id' => $param['id'],'tb1.deleted_at' => 0]
		]);

		if(!isset($object) || !is_array($object) || count($object) == 0){
			echo json_encode([
				'code' => 404,
				'message' => 'Sản phẩm không tồn tại! Xin vui lòng thử lại!'
			]);die();
		}else{
			$object['content'] = base64_decode($object['content']);
			$object['description'] = base64_decode($object['description']);
			echo json_encode([
				'code' => 10,
				'message' => 'Lấy dữ liệu thành công!',
				'data' => $object
			]);die();
		}
	}

	public function change_image(){
		$param['id'] = $this->request->getPost('id');
		$param['image'] = $this->request->getPost('image');

		$flag = $this->authentication->check_permission([
			'routes' => 'change_image'
		]);

		if($flag == false){
 			echo json_encode([
				'code' => 500,
				'message' => 'Bạn không có quyền truy cập vào chức năng này!'
			]);die();
		}

		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.album, tb1.image',
			'table' => 'product as tb1',
			'join' =>  [
				[
					'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\'','inner'
				]
			],
			'where' => ['tb1.id' => $param['id'],'tb1.deleted_at' => 0]
		]);

		if(!isset($object) || !is_array($object) || count($object) == 0){
			echo json_encode([
				'code' => 404,
				'message' => 'Sản phẩm không tồn tại! Xin vui lòng thử lại!'
			]);die();
		}

		$object['album'] = json_decode($object['album'], true);
		if (($key = array_search($object['image'], $object['album'])) !== false) {
		    unset($object['album'][$key]);
		}
		array_unshift($object['album'], $param['image']);
		$store = [
			'image' => $param['image'],
			'updated_at' => $this->currentTime,
			'album' => json_encode($object['album'])
		];

		$flag = $this->AutoloadModel->_update([
 			'table' => 'product',
 			'where' => ['id' => $param['id']],
 			'data' => $store
 		]);

 		if($flag > 0){
 			echo json_encode([
				'code' => 10,
				'message' => 'Cập nhật hình ảnh sản phẩm thành công!'
			]);die();
 		}
	}

	public function get_all_product(){
		$param['type'] = $this->request->getPost('type');
		if($param['type'] == 'minus'){
			echo json_encode([
				'code' => '10',
			]);die();
		}
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');
		$languageDetact = $this->detect_language();
		$module_extract = explode("_", $param['module']);

		$productList = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.catalogueid as cat_id, tb1.image, tb1.price,tb1.hot,tb1.order, tb1.price_promotion, tb1.bar_code, tb1.model,  tb1.album,   tb1.publish, tb2.title as product_title, tb1.catalogue, tb2.objectid, tb2.content, tb2.sub_title, tb2.sub_content, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.made_in, '.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
			'table' => $module_extract[0].' as tb1',
			'where' => [
				'tb1.catalogueid' => $param['id'],
				'tb2.module' => $module_extract[0],
				'tb1.deleted_at' => 0
			],
			'join' => [
				[
					$module_extract[0].'_translate as tb2','tb1.id = tb2.objectid  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				],
			],
			'group_by' => 'tb1.id'
		], TRUE);

		$html = '';
		if(isset($productList) && is_array($productList) && count($productList)){
		$languageList = get_list_language(['currentLanguage' => $this->currentLanguage()]);
            $html = $html .'<tr class="remove-table-child" data-catalogueid="'.$param['id'].'">';
                $html = $html .'<th class="text-center">ID</th>';
                $html = $html .'<th >Tiêu đề sản phẩm</th>';
                if(isset($languageList) && is_array($languageList) && count($languageList)){
                foreach($languageList as $key => $val){
                    $html = $html .'<th class="text-center">';
                        $html = $html .'<span class="icon-flag img-cover"><img src="'.getthumb($val['image']).'" alt=""></span>';
                    $html = $html .'</th>';
                }}
                $html = $html .'<th class="text-center">Vị trí</th>';
                $html = $html .'<th class="text-center">Hot</th>';
                $html = $html .'<th  class="text-center">Giá gốc</th>';
                $html = $html .'<th  class="text-center">Giá khuyến mại</th>';
                
                $html = $html .'<th class="text-center">Tình trạng</th>';
                $html = $html .'<th class="text-center">Thao tác</th>';
            $html = $html .'</tr>';
                foreach($productList as $key => $val){
                    $image = $val['image'];
                    $catalogue = json_decode($val['catalogue'], TRUE);
                    $cat_list = [];
                    if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                        $cat_list = get_catalogue_object([
                            'module' => $module[0],
                            'catalogue' => $catalogue,
                        ]);
                    }
                    $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                $html = $html.'<tr class="remove-table-child" data-catalogueid="'.$param['id'].'" id="product-'.$val['id'].'" data-id="'.$val['id'].'">';
                    $html = $html.'<td class="text-center">'.$val['id'].'</td>';
                    $html = $html.'<td>';
                       $html = $html.' <div class="uk-flex uk-flex-middle">';
                            $html = $html.'<div class="image mr5">';
                                $html = $html.'<span class="image-post image-product-edit img-cover"><img src="'.((isset($image) ? $image : 'public/not-found.png')).'" alt="'.$val['product_title'].'" /></span>';
                            $html = $html.'</div>';
                            $html = $html.'<div class="main-info">';
                                $html = $html.'<div class="title">';
                                    $html = $html.'<a class="maintitle" href="'.site_url('backend/product/product/update/'.$val['id']).'" title="">'.$val['product_title'].'</a>';
                                $html = $html.'</div>';
                            $html = $html.'</div>';
                        $html = $html.'</div>';
                    $html = $html.'</td>';
                    if(isset($languageList) && is_array($languageList) && count($languageList)){ 
                    foreach($languageList as $keyLanguage => $valLanguage){ 
	                    $html = $html.'<td class="text-center "><a class="text-small '.(($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger').' " href="'.base_url('backend/translate/translate/translateProduct/'.$val['id'].'/'.$module_extract['0'].'/'.$valLanguage['canonical'].'').'">';
	                        $html = $html.(($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'Đã Dịch' : 'Chưa Dịch');
	                    $html = $html.'</a></td>';
                    }}
                    $html = $html.'<td class="text-center text-primary">';
                        $html = $html.form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$module_extract[0].'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');
                    $html = $html.'</td>';
                    $html = $html.'<td class="text-center publishonoffswitch" data-field="hot" data-module="'.$module_extract[0].'" data-where="id">';
                        $html = $html.'<div class="switch">';
                            $html = $html.'<div class="onoffswitch">';
                                $html = $html.'<input type="checkbox" class="onoffswitch-checkbox hot" data-id="'.$val['id'].'" id="hot-'.$val['id'].'" '.($val['hot'] == 1 ? 'checked' : '').'>';
                                $html = $html.'<label class="onoffswitch-label" for="hot-'.$val['id'].'">';
                                    $html = $html.'<span class="onoffswitch-inner"></span>';
                                    $html = $html.'<span class="onoffswitch-switch"></span>';
                                $html = $html.'</label>';
                            $html = $html.'</div>';
                        $html = $html.'</div>';
                    $html = $html.'</td>';
                    $html = $html.'<td class="text-center update_price td-status" >';
                        $html = $html.'<div class="view_price text-success">';
                            $html = $html.((!empty($val['price'])) ? $val['price'] : 'Liên hệ');
                        $html = $html.'</div>';
                        $html = $html.'<input type="text" name="price" value="'.(($val['price'] != '' || $val['price'] == 0) ? $val['price'] : '0').'" data-id="'.$val['id'].'" data-field="price" class=" index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">';
                    $html = $html.'</td>';
                    $html = $html.'<td class="text-center update_price text-primary">';
                        $html = $html.'<div class="view_price text-success">';
                            $html = $html.(($val['price_promotion'] != '' || $val['price_promotion'] != 0) ? $val['price_promotion'] : '0');
                        $html = $html.'</div>';
                        $html = $html.'<input type="text" name="price_promotion" value="'.(($val['price_promotion'] != '' || $val['price_promotion'] != 0) ? $val['price_promotion'] : '0').'" data-id="'.$val['id'].'" data-field="price_promotion" class=" index_update_price form-control" style="text-align: right;display:none; padding: 6px 3px;">';
                    $html = $html.'</td>';
                    $html = $html.'<td class="text-center td-status" data-field="publish" data-module="'.$module_extract[0].'" data-where="id">'.$status.'</td>';
                    $html = $html.'<td class="text-center">';
                    $html = $html.'<a type="button" data-toggle="modal" data-target="#add_combo" href="" class="btn btn-success edit-info-product mr5" data-id="'.$val['id'].'"  data-module="product"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                        $html = $html.'<a type="button" href="'.base_url('backend/product/product/update/'.$val['id']).'" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
                        $html = $html.'<a type="button" href="'.base_url('backend/product/product/delete/'.$val['id']).'" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
                    $html = $html.'</td>';
                $html = $html.'</tr>';
                }
		}else{
			echo json_encode([
				'html' => $html,
				'code' => 500
			]);die();
		}
		echo json_encode([
			'html' => $html,
			'code' => 10
		]);die();
	}

	private function detect_language(){
		$languageList = $this->AutoloadModel->_get_where([
			'select' => 'id, canonical',
			'table' => 'language',
			'where' => ['publish' => 1,'deleted_at' => 0,'canonical !=' => $this->currentLanguage()]
		], TRUE);


		$select = '';
		$i = 3;
		if(isset($languageList) && is_array($languageList) && count($languageList)){
			foreach($languageList as $key => $val){
				$select = $select.'(SELECT COUNT(objectid) FROM product_translate WHERE product_translate.objectid = tb1.id AND product_translate.module = "product" AND product_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}
		}


		return [
			'select' => $select,
		];
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
		$param['title'] = $this->request->getPost('title');
		$param['canonical'] = $this->request->getPost('canonical');
		echo json_encode($param);die();
	}
	public function render_input_version(){
		$param['id'] = $this->request->getPost('id');
		$param['barcode'] = $this->request->getPost('barcode');
		$param['model'] = $this->request->getPost('model');
		echo json_encode($param);die();
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

	public function update_price(){
		$id = $this->request->getPost('id');
		$val = $this->request->getPost('val');
		$val = str_replace('.', '', $val);
		$val = (float)$val;
		$field = $this->request->getPost('field');
		$flag = $this->AutoloadModel->_update([
			'table' => 'product',
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

	public function advanced_products(){
		$data = $this->request->getPost('data');
		$data = json_decode($data, TRUE);
		$data['module'] = $this->request->getPost('module');
		$data['catalogueid'] = $this->request->getPost('catalogueid');
		$data['catalogue'] = $this->request->getPost('catalogue');
		$data['lang'] = $this->request->getPost('lang');
		$data['objectid'] = $this->request->getPost('objectid');
		$data =base64_encode(json_encode($data));
		$href = BASE_URL.'backend/product/version/create/'.$data;

		echo $href;die();
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
