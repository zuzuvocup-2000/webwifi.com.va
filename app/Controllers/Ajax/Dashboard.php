<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Dashboard extends BaseController{
	public function __construct(){
		
	}

	public function get_time_simple(){
		$time = $this->request->getPost('time');

		$time = date('Y-m-d H:i:s', strtotime($time));
		echo $time ;die();
	}



	public function dangvien_select2(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['type'] = $this->request->getPost('type');
		$module_explode =  explode('_', $param['module']);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'id, title, type',
			'table' => $module_explode[0].'_info',
			'keyword' => '(title LIKE \'%'.$param['keyword'].'%\')',
			'where' => [
				'deleted_at' => 0,
				'type' => $param['type']
			],	
			'order_by' => 'title asc'
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

	public function pre_select2_dangvien(){
		$param['value'] = json_decode(base64_decode($this->request->getPost('value')));
		$param['module'] = $this->request->getPost('module');
		$param['type'] = $this->request->getPost('type');
		$module_explode =  explode('_', $param['module']);
		if($param['value'] != []){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'id, title, type',
				'table' => $module_explode[0].'_info',
				'where_in' => $param['value'],
				'where_in_field' => 'id',
				'where' => [
					'deleted_at' => 0,
					'type' => $param['type']
				],	
				'order_by' => 'title asc'
			], TRUE);
		}
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
	
	public function select_widget(){
		$param['title'] = $this->request->getPost('title');
		$param['catalogueid'] = $this->request->getPost('catalogueid');
		$param['keyword'] = $this->request->getPost('keyword');
		$param['css'] = $this->request->getPost('css');
		$param['html'] = $this->request->getPost('html');
		$param['script'] = $this->request->getPost('script');

		$del = $this->AutoloadModel->_delete([
			'table' => 'website_widget',
			'where' =>[
				'catalogueid' => $param['catalogueid']
			]
		]);

		$data = [
			'catalogueid' => $param['catalogueid'],
			'title' => $param['title'],
			'keyword' => $param['keyword'],
			'css' => $param['css'],
			'html' => $param['html'],
			'script' => $param['script'],
		];

		$flag = $this->AutoloadModel->_insert([
			'table' => 'website_widget',
			'data' => $data
		]);

		echo json_encode($data);die();
	}

	public function delete_widget(){
		$param['catalogueid'] = $this->request->getPost('catalogueid');

		$del = $this->AutoloadModel->_delete([
			'table' => 'website_widget',
			'where' =>[
				'catalogueid' => $param['catalogueid']
			]
		]);


		echo json_encode($del);die();
	}

	public function set_title_canonical(){
		$param['language'] = $this->request->getPost('language');
		$param['module'] = $this->request->getPost('module');
		$param['id'] = $this->request->getPost('id');
		$module_explode = explode('_',$param['module']);
		$result = $this->AutoloadModel->_get_where([
			'select' => 'tb2.canonical, tb2.title, tb1.id',
			'table' => $param['module'].' as tb1',
			'join' => [
				[
					$module_explode[0].'_translate as tb2','tb2.objectid = tb1.id AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$param['language'].'\'','inner'
				]
			],
			'where' => [
				'tb1.id' => $param['id'],
				'tb1.deleted_at' => 0,
				'tb1.publish' => 1,
			]
		]);

		echo json_encode($result);die();
	}

	public function get_canonical_comment(){
		$param['module'] = $this->request->getPost('module');
		$param['language'] = $this->request->getPost('language');

		$result = $this->AutoloadModel->_get_where([
			'select' => 'tb2.canonical, tb2.title',
			'table' => $param['module'].' as tb1',
			'join' => [
				[
					$param['module'].'_translate as tb2','tb2.objectid = tb1.id AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$param['language'].'\'','inner'
				]
			],
			'where' => [
				'tb1.deleted_at' => 0,
				'tb1.publish' => 1,
			]
		], TRUE);

		echo json_encode($result);die();
	}

	public function translate_location(){
		$param['module'] = $this->request->getPost('module');
		$param['id'] = $this->request->getPost('id');
		$param['lang'] = $this->request->getPost('lang');
		$param['title'] = $this->request->getPost('title');

		$check = $this->AutoloadModel->_get_where([
			'select' => 'title',
			'table' => 'location_translate',
			'where' =>[
				'module' => $param['module'],
				'objectid' => $param['id'],
				'language' => $param['lang'],
			]
		]);

		$param['title_translate'] = $check['title'];

		echo json_encode($param);die();
	}

	public function translate(){
		$param['module'] = $this->request->getPost('module');
		$param['id'] = $this->request->getPost('id');
		$param['lang'] = $this->request->getPost('lang');
		$param['title'] = $this->request->getPost('title');

		$check = $this->AutoloadModel->_get_where([
			'select' => 'title',
			'table' => 'location_translate',
			'where' =>[
				'module' => $param['module'],
				'objectid' => $param['id'],
				'language' => $param['lang'],
			],
			'count' => true
		]);
		if($check > 0){
			$data= [
				'title' => $param['title'],
			];
			$check = $this->AutoloadModel->_update([
				'table' => 'location_translate',
				'data' => $data,
				'where' =>[
					'module' => $param['module'],
					'objectid' => $param['id'],
					'language' => $param['lang'],
				],
			]);
		}else{
			$abc = $this->AutoloadModel->_get_where([
				'select' => 'keyword, attribute',
				'table' => 'location_translate',
				'where' =>[
					'module' => $param['module'],
					'objectid' => $param['id'],
					'language' => $this->currentLanguage(),
				]
			]);
			$data= [
				'title' => $param['title'],
				'objectid' => $param['id'],
				'module' => $param['module'],
				'language' => $param['lang'],
				'keyword' => $abc['keyword'],
				'attribute' => $abc['attribute'],
			];
			$check = $this->AutoloadModel->_insert([
				'table' => 'location_translate',
				'data' => $data,
			]);
		}

		echo 1;die();
	}

	public function get_module_primary(){
		$val = $this->request->getPost('val');
		
		$flag = $this->AutoloadModel->_get_where([
			'select' => 'module_primary',
			'table' => 'attribute_translate',
			'where' => [
				'module' => 'attribute_catalogue',
				'objectid' => $val,
				'language' => $this->currentLanguage()
			]
		]);
		echo json_encode($flag);die();
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

	public function get_catalogue(){
		$id = $this->request->getPost('id');
		$module = $this->request->getPost('module');
		$module_explode = explode('_', $module);


		$data = $this->AutoloadModel->_get_where([
			'select' => 'id,lft, rgt, level',
			'table' => $module_explode[0].'_catalogue',
			'where' => [
				'id' => $id
			]
		]);
		$breadcum = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => $module_explode[0].'_catalogue as tb1',
			'join' => [
				[
					$module_explode[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module= \''.$module_explode[0].'_catalogue \' AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
				]
			],
			'where' => [
				'tb1.lft <=' => $data['lft'],
				'tb1.rgt >=' => $data['rgt']
			],
			'order_by' => 'tb1.lft ASC , tb1.rgt DESC'
		],TRUE);
		$text = '';
		foreach ($breadcum as $key => $value) {
			$length = count($breadcum);
			$title = slug($value['title']);
			if($key == 0){
				$text = $title;
			}else if($key > 0 && $key < $length){
				$text = $text.'/'.$title;
			}
		}
		echo $text;die();
	}

	public function pre_select2(){
		$param['value'] = json_decode($this->request->getPost('value'));
		$param['module'] = $this->request->getPost('module');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['language'] = $this->request->getPost('language');
		if(isset($param['language'])&& $param['language'] !=''){
			$language = $param['language'];
		}else{
			$language = $this->currentLanguage();
		}
		$object = [];
		
		if($param['value'] != ''){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.'.$param['select'].'',
				'table' => $param['module'].' as tb1',
				'join' => [
						[
							$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$language.'\' ','inner'
						],
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

	public function get_select2(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['language'] = $this->request->getPost('language');
		if(isset($param['language'])&& $param['language'] !=''){
			$language = $param['language'];
		}else{
			$language = $this->currentLanguage();
		}
		if (isset($param['join']) && $param['join'] != ''){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.'.$param['select'].'',
				'table' => $param['module'].' as tb1',
				'join' => [
						[
							$param['join'].' as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'  AND tb2.language = \''.$language.'\' ','inner'
						],
					],
				'where' => [
					'tb1.deleted_at' => 0
				],		
				'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
				'order_by' => ''.$param['select'].' asc'
			], TRUE);
		}else{
			$object = $this->AutoloadModel->_get_where([
				'select' => 'id, '.$param['select'],
				'table' => $param['module'],
				'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
				'where' => [
					'tb1.deleted_at' => 0
				],	
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

	public function get_multiple(){
		$param['key'] = $this->request->getPost('key');
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['condition'] = $this->request->getPost('condition');
		if (isset($param['condition']) && $param['condition'] != '')
			{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'tb1.id, tb2.'.$param['select'].'',
					'table' => $param['module'].' as tb1',
					'join' => [
							[
								$param['module'].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\' '.$param['condition'].'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
							],
						],
					'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
					'order_by' => ''.$param['select'].' asc'
				], TRUE);
			}else{
				$object = $this->AutoloadModel->_get_where([
					'select' => 'id, '.$param['select'],
					'table' => $param['module'],
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

	public function getDataMultiple(){
		$param['key'] = $this->request->getPost('key');
		$param['module'] = $this->request->getPost('module');
		$param['data'] = json_decode($this->request->getPost('data'));
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['condition'] = $this->request->getPost('condition');
		$object = [];
		if (isset($param['condition']) && $param['condition'] != '')
			{
				if(isset($param['data']) && is_array($param['data']) && count($param['data'])){
					foreach ($param['data'] as $key => $value) {
						$object[] = $this->AutoloadModel->_get_where([
							'select' => 'tb1.id, tb2.'.$param['select'].'',
							'table' => $param['module'].' as tb1',
							'join' => [
								[
									$param['module'].'_translate as tb2', 'tb2.objectid = \''.$value.'\' AND tb2.module = \''.$param['module'].'\' '.$param['condition'].'  AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
								],
							],
							'where' => [
								'tb1.id' => $value
							],
							'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
							'order_by' => ''.$param['select'].' asc'
						]);
					}
				}
			}

		echo json_encode($object);die();

	}

	public function update_by_field(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['value'] = $this->request->getPost('value');
		$post['field'] = $this->request->getPost('field');


		$flag = $this->AutoloadModel->_update([
			'table' => $post['module'],
			'data' => [$post['field'] => $post['value']],
			'where_in' => $post['id'],
			'where_in_field' => 'id',
		]);
		echo $flag;

	}

	public function update_canonical(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$module = explode('_', $post['module']);

		$data = $this->AutoloadModel->_get_where([
			'select' => 'title',
			'table' => $module[0].'_translate',
			'where' => [
				'objectid' => $post['id'],
				'module' => $module[0].'_catalogue',
				'language' => $this->currentLanguage()
			]
		]);
		$data = '/'.slug($data['title']).'/';
		echo($data); die();

	}


	public function update_field(){
		$post['id'] = $this->request->getPost('id');
		$post['module'] = $this->request->getPost('module');
		$post['field'] = $this->request->getPost('field');
		$module = explode('_', $post['module']);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'id, '.$post['field'],
			'table' => $post['module'],
			'where' => ['id' => $post['id']],
		]);
		if(!isset($object) || is_array($object) == false || count($object) == 0){
			echo 0;
			die();
		}
		if(isset($module) && count($module) == 2){
			$flag = $this->AutoloadModel->_update([
				'data' => ['publish' => (($object[$post['field']] == 1)?0:1)],
				'table' => current($module),
				'where' => ['catalogueid' => $post['id']],
			]);
		}
		$_update[$post['field']] = (($object[$post['field']] == 1)?0:1);
		$flag = $this->AutoloadModel->_update([
			'data' => $_update,
			'table' => $post['module'],
			'where' => ['id' => $post['id']]
		]);
		echo json_encode([
			'flag' => $flag,
			'value' => $_update[$post['field']],
		]);
		die();
	}

	public function get_location(){
		$post = $this->request->getPost('param');

		$object = $this->AutoloadModel->_get_where([
			'select' => $post['select'],
			'table' => $post['table'],
			'where' => $post['where'],
			'order_by' => 'name asc'
		], TRUE);


		$html = '<option value="0">'.$post['text'].'</option>';
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $key => $val){
				$html = $html . '<option value="'.$val['id'].'">'.$val['name'].'</option>';
			}
		}
		echo json_encode([
			'html' => $html
		]); die();
	}

	public function clone_all(){
		$param['id'] = $this->request->getPost('id');
		$param['module'] = $this->request->getPost('module');
		$param['quantity'] = $this->request->getPost('quantity');
		$flag = 0;
		$explode = explode('_', $param['module']);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.canonical, tb2.description, tb2.content, tb2.meta_title, tb2.meta_description, tb1.catalogueid, tb1.image, tb1.album, tb1.publish,tb2.module, tb3.view  ',
			'table' => $param['module'].' as tb1',
			'join' => [
				[
					$explode[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				],
				[
					'router as tb3','tb1.id = tb3.objectid AND tb3.module = \''.$param['module'].'\' AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where_in' => $param['id'],
			'where_in_field' => 'tb1.id',
			'where' => ['tb1.deleted_at' => 0],
			'group_by' => 'tb1.id'
		],true);
		if(isset($object) &&is_array($object) && count($object)){
			$flag = $this->storeClone($param, $object, $param['quantity']);
			$storeLanguage = $this->storeLanguageClone($param, $object, $param['quantity']);
		}
		echo $flag;die();
	}
	public function storeClone($param = [], $object = [], $quantity = 0){
		$store = [];
		$flag = 0;
		$this->auth = ((isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '');
		$this->auth = json_decode($this->auth, TRUE);
		foreach ($object as $key => $value) {
			for ($i = 1; $i <= $quantity ; $i++) { 
				$store[] = [
					'catalogueid' => $value['catalogueid'],
					'image' => $value['image'],
					'album' => $value['album'],
					'publish' => $value['publish'],
					'cloneid' => $value['id'],
					'userid_created' => $this->auth['id'],
					'created_at' => $this->currentTime
				];
			}
		}

		if(isset($store) && is_array($store) && count($store)){
			$flag = $this->AutoloadModel->_create_batch([
	 			'table' => $param['module'],
	 			'data' => $store,
	 		]);
		}
		return $flag;
	}

	public function storeLanguageClone($param = [], $object = [], $quantity = 0){
		$store = [];
		$router = [];
		$object_relationship = [];
		$flag = 0;
		helper('text');
		foreach ($object as $key => $value) {
			$clone = $this->AutoloadModel->_get_where([
				'select' => 'id  , catalogueid',
				'table' => $param['module'],
				'where' => ['deleted_at' => 0, 'cloneid' => $value['id']],
				'order_by' => 'id desc',
				'limit' => $quantity
			],true);
			for ($i = 0; $i < $quantity ; $i++) { 
				$salt = random_string('alnum', 6);
		 		$canonical = random_string('numeric', 6);
		 		$canonical_encode = password_encode($canonical, $salt);
				$store[] = [
					'objectid' => $clone[$i]['id'],
					'module' => $param['module'],
					'language' => $this->currentLanguage(),
					'title' => $value['title'].' - Clone '.($i + 1),
					'canonical' => $value['canonical'].'-'.$canonical_encode,
					'description' => $value['description'],
					'content' => $value['content'],
					'meta_title' => $value['meta_title'],
					'meta_description' => $value['meta_description'],
				];
				$router[] = [
					'objectid' => $clone[$i]['id'],
					'module' => $param['module'],
					'language' => $this->currentLanguage(),
					'view' => $value['view'],
					'canonical' => $value['canonical'].'-'.$canonical_encode,
				];
				$object_relationship[] = [
					'objectid' => $clone[$i]['id'],
					'catalogueid' => $value['catalogueid'],
					'module' => $param['module']
				];
			}
		}
		if(isset($object_relationship) && is_array($object_relationship) && count($object_relationship)){
			$flag = $this->AutoloadModel->_create_batch([
	 			'table' => 'object_relationship',
	 			'data' => $object_relationship,
	 		]);
		}
		$explode = explode('_', $param['module']);
		if(isset($store) && is_array($store) && count($store)){
			$flag = $this->AutoloadModel->_create_batch([
	 			'table' => $explode[0].'_translate',
	 			'data' => $store,
	 		]);
	 		if(isset($router) && is_array($router) && count($router)){
 				$flag = $this->AutoloadModel->_create_batch([
		 			'table' => 'router',
		 			'data' => $router,
		 		]);
			}
		}
		return $flag;
	}
}
