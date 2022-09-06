<?php
namespace App\Controllers\Backend\Page;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Page extends BaseController{
	protected $data;
	public $nestedsetbie;


	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'page';
		$this->data['module2'] = 'page_catalogue';
		$this->nestedsetbie = new Nestedsetbie(['table' => $this->data['module'].'_catalogue','language' => $this->currentLanguage()]);

	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/page/page/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$catalogue = $this->condition_catalogue();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb3.title',
			'table' => $this->data['module'].' as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'where_in' => $catalogue['where_in'],
			'where_in_field' => $catalogue['where_in_field'],
			'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
					],
					[
						'page_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "page" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
					],
					[
						'page_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "page_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
					],
					[
						'user as tb5','tb1.userid_created = tb5.id','inner'
					],
				],
			'group_by' => 'tb1.id',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/page/page/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$languageDetact = $this->detect_language();
			$this->data['pageList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id,  tb1.catalogueid as cat_id, tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,  tb2.catalogueid, tb1.publish, tb3.title as page_title, tb1.catalogue, tb2.objectid, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description,  tb4.title as cat_title ,tb4.objectid as cat_id, tb5.fullname as creator,'.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
				'table' => $this->data['module'].' as tb1',
				'where' => $where,
				'where_in' => $catalogue['where_in'],
				'where_in_field' => $catalogue['where_in_field'],
				'keyword' => $keyword,
				'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
					],
					[
						'page_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "page" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
					],
					[
						'page_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "page_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
					],
					[
						'user as tb5','tb1.userid_created = tb5.id','inner'
					],
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.order desc, tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['template'] = 'backend/page/page/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/page/page/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$insert = $this->store(['method' => 'create']);

		 		$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);

		 		if($resultid > 0){
		 			$sub_content = $this->request->getPost('sub_content');
		 			$storeLanguage = $this->storeLanguage($resultid);
		 			$storeLanguage = $this->convert_content($sub_content, $storeLanguage);
		 			$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'page_translate',
			 			'data' => $storeLanguage,
			 		]);
		 			insert_router([
			 			'method' => 'create',
			 			'id' => $resultid,
			 			'language' => $this->currentLanguage(),
			 			'module' => $this->data['module'],
			 			'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
			 		]);

		 			insert_tags([
		 				'module' => $this->data['module'],
		 				'language' => $this->currentLanguage(),
		 				'objectid' => $resultid,
		 				'tags' => $this->request->getPost('tags')
		 			]);
	 				$flag = $this->create_relationship($resultid);
	 				if($flag > 0){
	 					$session->setFlashdata('message-success', 'Tạo Bài Viết Thành Công! Hãy tạo danh mục tiếp theo.');
 						return redirect()->to(BASE_URL.'backend/page/page/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/page/page/index');
	 				}
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/page/page/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/page/page/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb4.title, tb4.canonical, tb4.description, tb4.content, tb4.meta_title, tb4.meta_description, tb1.catalogueid, tb1.image, tb1.album, tb1.publish, tb1.catalogue,tb1.video, tb4.router, tb4.icon, tb4.template, tb4.sub_title, tb4.sub_content,',
			'table' => $this->data['module'].' as tb1',
			'join' => [
					[
						'page_translate as tb4','tb1.id = tb4.objectid AND tb4.module = "page" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
			'where' => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);

		$this->data['tags'] = get_tag([
			'module' => $this->data['module'],
			'objectid' => $id,
			'language' => $this->currentLanguage(),
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.'backend/page/page/index');
		}

		$this->data[$this->data['module']]['description'] = base64_decode($this->data[$this->data['module']]['description']);
		$this->data[$this->data['module']]['content'] = base64_decode($this->data[$this->data['module']]['content']);
		$this->data[$this->data['module']]['sub_title'] = json_decode(base64_decode($this->data[$this->data['module']]['sub_title']));
		$this->data[$this->data['module']]['sub_content'] = json_decode(base64_decode($this->data[$this->data['module']]['sub_content']));

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$update = $this->store(['method' => 'update']);
	 			$sub_content = $this->request->getPost('sub_content');
		 		$updateLanguage = $this->storeLanguage($id);
	 			$updateLanguage = $this->convert_content($sub_content, $updateLanguage);
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'where' => ['id' => $id],
		 			'data' => $update
		 		]);

		 		if($flag > 0){
		 			$flagLang = $this->AutoloadModel->_update([
			 			'table' => $this->data['module'].'_translate',
			 			'where' => ['objectid' => $id, 'module' => 'page', 'language' => $this->currentLanguage()],
			 			'data' => $updateLanguage,
			 		]);
			 		$flag = $this->create_relationship($id);
			 		insert_tags([
		 				'module' => $this->data['module'],
		 				'language' => $this->currentLanguage(),
		 				'objectid' => $id,
		 				'tags' => $this->request->getPost('tags')
		 			]);
	 				insert_router([
		 				'method' => 'update',
		 				'id' => $id,
		 				'language' => $this->currentLanguage(),
		 				'module' => $this->data['module'],
		 				'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
		 			]);
		 			$session->setFlashdata('message-success', 'Cập Nhật Bài Viết Thành Công!');
 					return redirect()->to(BASE_URL.'backend/page/page/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/page/page/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/page/page/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb4.title ',
			'table' => $this->data['module'].' as tb1',
			'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
					],
					[
						'user as tb3','tb1.userid_created = tb3.id','inner'
					],
					[
						'page_translate as tb4','tb1.id = tb4.objectid AND tb4.module="page" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
			'where' => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.'backend/page/page/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $_id
				]
			]);
			delete_router($id,$this->data['module'], $this->currentLanguage());

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/page/page/index');
		}

		$this->data['template'] = 'backend/page/page/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function get_tags($id = ''){
		$tags = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => 'tags',
			'where' => [
				'module' => $this->data['module'],
				'language' => $this->currentLanguage(),
			]
		],true);
		$array = [];
		if(isset($tags) && is_array($tags) && count($tags)){
			foreach ($tags as $key => $value) {
				$tags[$key]['objectid'] = json_decode($value['objectid']);
			}
			foreach ($tags as $key => $value) {
				foreach ($value['objectid'] as $keytag => $valuetag) {
					if($valuetag == $id){
						array_push($array, $value);
					}
				}
			}
		}
		$text = '';
		$count = 0;
		foreach ($array as $key => $value) {
			$text = $text. $value['title'];
			if($count + 1 < count($array)) $text=$text.', ';
			$count++;
		}

		return $text;
	}

	private function create_relationship($objectid = 0, $catalogue = []){
		if($this->request->getPost('catalogue') != ''){
			$catalogue = $this->request->getPost('catalogue');
		}
		$catalogueid = $this->request->getPost('catalogueid');
		$relationshipId = 	array_unique(array_merge($catalogue, [$catalogueid]));
		$this->AutoloadModel->_delete([
			'table' => 'object_relationship',
			'where' => [
				'module' => $this->data['module'],
				'objectid' => $objectid
			]
		]);
		$insert = [];
		if(isset($relationshipId) && is_array($relationshipId) && count($relationshipId)){
			foreach($relationshipId as $key => $val){
				$insert[] = array(
					'objectid' => $objectid,
					'catalogueid' => $val,
					'module' => $this->data['module'],
				);
			}
		}

		if(isset($insert) && is_array($insert) && count($insert)){
			$flag = $this->AutoloadModel->_create_batch([
				'data' => $insert,
				'table' => 'object_relationship'
			]);
		}

		return $flag;
	}

	public function condition_catalogue(){
		$catalogueid = $this->request->getGet('catalogueid');
		$id = [];
		if($catalogueid > 0){
			$catalogue = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.lft, tb1.rgt, tb4.title',
				'table' => $this->data['module'].'_catalogue as tb1',
				'join' =>  [
					[
						'page_translate as tb4','tb1.id = tb4.objectid AND tb4.module="page_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
					],
									],
				'where' => ['tb1.id' => $catalogueid],
			]);

			$catalogueChildren = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $this->data['module'].'_catalogue',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}
		return [
			'where_in' => $id,
			'where_in_field' => 'tb2.catalogueid'
		];

	}

	private function condition_where(){
		$where = [];
		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['tb1.publish'] = $publish;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function storeLanguage($objectid = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('canonical')),
			'description' => base64_encode($this->request->getPost('description')),
			'router' => $this->request->getPost('router'),
			'template' => $this->request->getPost('template'),
			'icon' => $this->request->getPost('icon'),
			'content' => base64_encode($this->request->getPost('content')),
			'meta_title' => validate_input($this->request->getPost('meta_title')),
			'meta_description' => validate_input($this->request->getPost('meta_description')),
			'language' => $this->currentLanguage(),
			'module' => $this->data['module'],
		];
		return $store;
	}

	private function store($param = []){
		helper(['text']);
		$catalogue = $this->request->getPost('catalogue');
		if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
			foreach($catalogue as $key => $val){
				if($val == (int)$this->request->getPost('catalogueid')){
					unset($catalogue[$key]);
				}
			}
		}
		if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
			$catalogue = array_values($catalogue);
		}

		$store = [
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'catalogue' => json_encode($catalogue),
 			'image' => $this->request->getPost('image'),
 			'video' => $this->request->getPost('video'),
 			'album' => json_encode($this->request->getPost('album'), TRUE),
 			'publish' => $this->request->getPost('publish'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];

 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

	private function insert_router($param = []){
		helper(['text']);
		$view = view_cells($this->data['module']);
		$router = $this->request->getPost('router');
		if(!isset($router) && $router == ''){
			$view = view_cells($this->data['module']);
		}else{
			$view = $router;
		}
		$data = [
			'canonical' => slug($this->request->getPost('canonical')),
			'module' => $this->data['module'],
			'objectid' => $param['id'],
			'language' => $this->currentLanguage(),
			'view' => $view
		];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$insertRouter = $this->AutoloadModel->_insert([
	 			'table' => 'router',
	 			'data' => $data,
	 		]);
 		}else{
 			$this->AutoloadModel->_update([
	 			'table' => 'router',
	 			'where' => ['objectid' => $param['id'], 'module' => $this->data['module'], 'language' => $this->currentLanguage()],
	 			'data' => [
	 				'canonical' => $data['canonical']
	 			]
	 		]);
 		}
 		return true;
	}

	private function detect_language(){
		$languageList = $this->AutoloadModel->_get_where([
			'select' => 'id, canonical',
			'table' => 'language',
			'where' => ['publish' => 1,'deleted_at' => 0,'canonical !=' =>  $this->currentLanguage()]
		], TRUE);


		$select = '';
		$i = 3;
		if(isset($languageList) && is_array($languageList) && count($languageList)){
			foreach($languageList as $key => $val){
				$select = $select.'(SELECT COUNT(objectid) FROM page_translate WHERE page_translate.objectid = tb1.id AND page_translate.module = "page" AND  page_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}
		}


		return [
			'select' => $select,
		];

	}

	private function convert_content($content = [], $store = []){
		$count_1 = 0;
		$count_2 = 0;
		if($content != []){
			foreach ($content['title'] as $key => $value) {
	 			$title[] = $content['title'][$count_1];
	 			$count_1++;
	 		}
	 		foreach ($content['title'] as $key => $value) {
	 			$description[] = $content['description'][$count_2];
	 			$count_2++;
	 		}
	 		$title = base64_encode(json_encode($title));
	 		$description = base64_encode(json_encode($description));
	 		$store['sub_title'] = $title;
	 		$store['sub_content'] = $description;
			return $store;
		}else{
			return $store;
		}
	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router[]',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
