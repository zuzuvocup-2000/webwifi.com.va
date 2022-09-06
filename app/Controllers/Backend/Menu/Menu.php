<?php
namespace App\Controllers\Backend\Menu;
use App\Controllers\BaseController;
use App\Controllers\Backend\Menu\Libraries\Configbie;
use App\Libraries\Nestedsetbie;

class Menu extends BaseController{
	protected $data;
	public $nestedsetbie;
	public $configbie;


	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'menu';
		$this->nestedsetbie = new Nestedsetbie(['table' => $this->data['module'],'language' => $this->currentLanguage()]);

	}


	public function index($id = 0, $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/menu/menu/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$session = session();
		$this->data['id'] = $id;
		$this->data['languageSelect'] = $language;
		$this->data['menuCatalogue'] = $this->menuCatalogue($id);
		$this->data['menuList'] = $this->menuList($id, $language);
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/menu/menu/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function listmenu($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/menu/menu/listmenu'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$session = session();

		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id',
			'table' => $this->data['module'].'_catalogue as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'group_by' => 'tb1.id',
			'count' => TRUE
		]);
		// pre($config['total_rows']);


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/menu/menu/listmenu','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$languageDetact = $this->detect_language();
			$this->data['menuCatalogue'] = $this->AutoloadModel->_get_where([
				'select' => '  tb1.title, tb1.id, tb1.value, tb1.created_at, tb1.value, tb1.userid_created,tb2.fullname as creator, '.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
				'table' => $this->data['module'].'_catalogue as tb1',
				'where' => $where,
				'keyword' => $keyword,
				'join' => [
					[
						'user as tb2','tb1.userid_created = tb2.id','inner'
					]
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);

		}

		$this->data['template'] = 'backend/menu/menu/listmenu';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function createmenu($language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/menu/menu/createmenu'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$configbie = $this->configbie->menu();
		$configbieList = [];
		foreach ($configbie as $key => $value) {
			$configbieList[] = $this->ObjectList($language, $key, $value);
		}
		foreach ($configbieList as $key => $value) {
			foreach ($value as $keyChild => $valChild) {
				$configbieList[$key][$keyChild]['name'] =  $configbie[$value[$keyChild]['module']]['title'];
				$configbieList[$key][$keyChild]['translate'] =  $configbie[$value[$keyChild]['module']]['translate'];
			}
		}



		$this->data['languageABC'] = $language;
		$this->data['object'] = $configbieList;
		$session = session();
		$this->data['menuCatalogue'] = $this->AutoloadModel->_get_where([
			'select' => ' value, title, id',
			'table' => 'menu_catalogue',
			'where' => ['deleted_at' => 0],
			'order_by' => 'title asc'
		], TRUE);

		$object = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => 'system_translate',
			'where' => ['language' => $this->currentLanguage()],
		], TRUE);
		$this->data['general']= [];
        if(isset($object) &&  is_array($object)  && count($object)){
            foreach ($object as $key => $value) {
                $this->data['general'][$value['keyword']] = $value['content'];
            }
        }


		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$menu = $this->request->getPost('menu');
				$catalogueid = $this->request->getPost('parentid');
				if(isset($menu) && is_array($menu) && count($menu)){
					$_insert = [];
					$newMenu = [];
					$count = 0;

					$delete = $this->AutoloadModel->_delete([
						'table' => 'menu',
						'where' => ['catalogueid' => $catalogueid]
					]);

					$delete_menuTranslate = $this->AutoloadModel->_delete([
						'table' => 'menu_translate',
						'where' => ['module' => 'menu', 'language' => $this->currentLanguage(), 'catalogueid' => $catalogueid],
					]);


					foreach($menu['order'] as $key => $val){
						$_insert[] = [
							'catalogueid' => $catalogueid,
							'order' => $val,
							'userid_created' => $this->auth['id'],
							'created_at' => $this->currentTime
						];
						$count++;
					}

					$flag = [];
					$flag =	$this->AutoloadModel->_create_batch([
						'table' => 'menu',
						'data' => $_insert,
					]);

					if($flag > 0){
						$getData = $this->AutoloadModel->_get_where([
							'select' => 'id',
							'table' => 'menu',
							'order_by' => 'created_at desc',
							'where' => ['deleted_at' => 0],
							'limit' => $count
						],TRUE);
						foreach ($getData as $key => $value) {

							$newMenu[] = [
								'objectid' => $getData[$key]['id'],
								'title' => $menu['title'][$key],
								'canonical'  => $menu['link'][$key],
								'catalogueid' => $this->request->getPost('parentid'),
								'language' => $language,
								'module' => 'menu',
								'created_at' => $this->currentTime,
								'userid_created' => $this->auth['id']
							];
						}
						$insertData = $this->AutoloadModel->_create_batch([
							'table' => 'menu_translate',
							'data' => $newMenu
						]);

						$this->nestedsetbie->Get('level ASC, order ASC');
						$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
						$this->nestedsetbie->Action();

						$session->setFlashdata('message-success', 'Tạo Menu Thành Công!');
						return redirect()->to(BASE_URL.'backend/menu/menu/index/'.$catalogueid.'/'.$language.'');
					}
		 		}
		 	}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	 	}

		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/menu/menu/store';
		return view('backend/dashboard/layout/home', $this->data);
	}


	public function create($id = 0, $language = '', $id_child = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/menu/menu/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$configbie = $this->configbie->menu($language);
		$configbieList = [];
		foreach ($configbie as $key => $value) {
			$configbieList[] = $this->ObjectList($language, $key, $value);
		}

		$configbieList = array_filter($configbieList, function($v, $k){
			return $v !== [];
		}, ARRAY_FILTER_USE_BOTH);
		$object = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => 'system_translate',
			'where' => ['language' => $this->currentLanguage()],
		], TRUE);
		$this->data['general']= [];
        if(isset($object) &&  is_array($object)  && count($object)){
            foreach ($object as $key => $value) {
                $this->data['general'][$value['keyword']] = $value['content'];
            }
        }

		foreach ($configbieList as $key => $value) {
			if($value == []){

				$configbieList[$key][$key]['name'] =  $configbie['article']['title'];
				$configbieList[$key][$key]['translate'] =  $configbie['article']['translate'];
				$configbieList[$key][$key]['module'] =  'article';

			}else{
				foreach ($configbieList[$key] as $keyChild => $valChild) {
					$configbieList[$key][$keyChild]['name'] =  $configbie[$value[$keyChild]['module']]['title'];
					$configbieList[$key][$keyChild]['translate'] =  $configbie[$value[$keyChild]['module']]['translate'];
				}
			}
		}

		$this->data['languageABC'] = $language;
		$this->data['object'] = $configbieList;
		// prE($this->data['object']);
		$session = session();
		$this->data['id'] = $id;
		$this->data['menuList'] = $this->menuList($id, $language, $id_child);
		$this->data['menuCatalogue'] = $this->AutoloadModel->_get_where([
			'select' => ' value, title, id',
			'table' => 'menu_catalogue',
			'order_by' => 'title asc'
		], TRUE);
		if(isset($id_child) && !empty($id_child)){
			$this->data['parent_menu'] = $this->AutoloadModel->_get_where([
				'select' => ' tb1.id, tb1.catalogueid, tb2.id as langid, tb1.parentid, tb1.lft, tb1.rgt, tb1.level, tb1.order, tb2.title,tb2.objectid, tb2.canonical, tb2.catalogueid as dataid, tb2.language, tb1.type',
				'table' => 'menu as tb1',
				'join' => [
					[
						'menu_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' ','inner'
					]
				],
				'where' => [
					'tb1.id' => $id_child,
					'tb1.level' => 1
				],
			]);
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$menu = $this->request->getPost('menu');
				// if(isset($menu['link'])&& is_array($menu['link']) && count($menu['link'])){
				// 	foreach ($menu['link'] as $key => $value) {
				// 		$menu['link'][$key] = str_replace('.html', '', $value);
				// 	}
				// }
				if(isset($menu) && is_array($menu) && count($menu)){
					$_insert = [];
					$newMenu = [];
					$idLanguageList = [];
					$count = 0;
					$id = $this->request->getPost('parentid');
					$GetdataLanguage = $this->AutoloadModel->_get_where([
						'select' => 'objectid',
						'table' => 'menu_translate',
						'where' => ['language' => $language, 'catalogueid' => $id]
					], TRUE);
					foreach ($GetdataLanguage as $key => $value) {
						$idLanguageList[] =  $value['objectid'];
					}
					$all = [];
					$dem = 0 ;
					foreach($menu['id'] as $key => $val){
						if($val == '[0]'){
							$all['insert'][$dem] = [
								'catalogueid' => $this->request->getPost('parentid'),
								'order' => $menu['order'][$key],
								'userid_created' => $this->auth['id'],
								'created_at' => $this->currentTime,
							];
							if(isset($id_child) && $id_child > 0){
								$all['insert'][$dem]['parentid'] =  $id_child;
							}
							$all['insert_language'][] = [
								'title' => $menu['title'][$key],
								'canonical'  => $menu['link'][$key],
								'language' => $language,
							];
							$dem++;
						}else{
							$all['update'][] = [
								'id' => $val,
								'order' => $menu['order'][$key],
								'userid_updated' => $this->auth['id'],
								'updated_at' => $this->currentTime,
							];
							if(isset($this->data['menuList']) && is_array($this->data['menuList']) && count($this->data['menuList'])){
								foreach ($this->data['menuList'] as $value) {
									if($val == $value['id']){
										$all['update_language'][] = [
											'id' => $value['langid'],
											'title' => $menu['title'][$key],
											'canonical'  => $menu['link'][$key],
											'language'  => $language
										];
									}
								}
							}
							
						}
						$count++;
					}

					if(isset($all['insert'])&& is_array($all['insert']) && count($all['insert'])){
						$this->create_menu([
							'data' => $all,
							'language' => $language,
						]);
					}
					if(isset($all['update'])&& is_array($all['update']) && count($all['update'])){
						$this->update_menu([
							'data' => $all,
							'language' => $language
						]);
					}

					if(isset($this->data['parent_menu']) && is_array($this->data['parent_menu']) && count($this->data['parent_menu'])){
						$this->AutoloadModel->_update([
							'table' => 'menu',
							'where' => [
								'id' => $id_child
							],
							'data' => [
								'type' => $this->request->getPost('type')
							]
						]);
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$session->setFlashdata('message-success', 'Tạo Menu Thành Công!');
					return redirect()->to(BASE_URL.'backend/menu/menu/index/'.$id.'/'.$language.'');
		 		}
		 	}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	 	}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/menu/menu/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function validation(){
		$validate = [
			'parentid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'parentid' => [
				'is_natural_no_zero' => 'Bạn bắt buộc phải chọn vị trí hiển thị cho menu!'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function menuCatalogue($id = 0){
		$menuCatalogue = $this->AutoloadModel->_get_where([
			'select' => ' value, title, id',
			'table' => 'menu_catalogue',
			'where' => ['id' => $id] ,
			'order_by' => 'title asc'
		], TRUE);

		return $menuCatalogue;
	}

	private function create_menu($param = []){
		$_insert =	$this->AutoloadModel->_create_batch([
			'table' => 'menu',
			'data' => $param['data']['insert'],
		]);
		$getData = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => 'menu',
			'order_by' => 'created_at desc',
			'limit' => $_insert
		],TRUE);
		$newMenu = [];
		foreach ($getData as $key => $value) {
			$newMenu[] = [
				'objectid' => $getData[$key]['id'],
				'title' => $param['data']['insert_language'][$key]['title'],
				'canonical'  => $param['data']['insert_language'][$key]['canonical'],
				'catalogueid' => $this->request->getPost('parentid'),
				'language' => $param['language'],
				'module' => 'menu',
				'created_at' => $this->currentTime,
				'userid_created' => $this->auth['id']
			];
		}
		$insertData = $this->AutoloadModel->_create_batch([
			'table' => 'menu_translate',
			'data' => $newMenu
		]);

		return true;
	}

	private function update_menu($param = []){
		$flag = $this->AutoloadModel->_update_batch([
			'table' => 'menu',
			'data' => $param['data']['update'],
			'field' =>'id'
		]);

		$store = $this->AutoloadModel->_update_batch([
			'table' => 'menu_translate',
			'data' => $param['data']['update_language'],
			'field' =>'id'
		]);
		return true;
	}


	private function menuList($id = 0, $language = '', $id_child = 0){
		$where = ['tb1.catalogueid' => $id];
		if($id_child > 0){
		$where['tb1.parentid'] = $id_child;

		}
		$menuList = $this->AutoloadModel->_get_where([
			'select' => ' tb1.id, tb1.catalogueid, tb2.id as langid, tb1.parentid, tb1.lft, tb1.rgt, tb1.level, tb1.order, tb2.title,tb2.objectid, tb2.canonical, tb2.catalogueid as dataid, tb2.language',
			'table' => 'menu as tb1',
			'join' => [
				[
					'menu_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' ','inner'
				]
			],
			'where' => $where,
			'order_by' => 'order desc'
		], TRUE);
		return $menuList;
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
				$select = $select.'(SELECT COUNT(objectid) FROM menu_translate WHERE menu_translate.objectid = tb1.id AND menu_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}
		}


		return [
			'select' => $select,
		];

	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb1.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function ObjectList($language = '', $module = '' , $params = []){
		$moduleExplode = explode('_',  $module);
		if(isset($params['translate']) && $params['translate'] == 0){
			$ObjectList = $this->AutoloadModel->_get_where([
				'select' => 'tb2.title, tb2.canonical, tb1.id, tb2.module',
				'table' => $module.' as tb1',
				'join' => [
					[
						$moduleExplode[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' AND tb2.module = \''.$module.'\' ','inner'
					]
				],
				'where' => ['deleted_at' => 0],
				'order_by' => 'created_at desc',
				'limit' => 5
			],TRUE);
		}else{
			$ObjectList = $this->AutoloadModel->_get_where([
				'select' => 'tb2.title, tb2.canonical, tb1.id, tb2.module',
				'table' => $module.' as tb1',
				'join' => [
					[
						$moduleExplode[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' AND tb2.module = \''.$module.'\' ','inner'
					]
				],
				'where' => [
					'tb1.deleted_at' => 0
				],
				'order_by' => 'tb1.created_at desc',
				'limit' => 5
			],TRUE);
			// $ObjectList[] = ['name' => $params['title']];
		}
		return $ObjectList;
	}

	private function condition_where(){
		$where = [];

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}

		return $where;
	}

}
