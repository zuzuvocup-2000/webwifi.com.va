<?php 
namespace App\Controllers\Backend\Location;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Location extends BaseController{
	protected $data;
	public $nestedsetbie;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'location';
		$this->data['module2'] = 'location_catalogue';
		$this->nestedsetbie = new Nestedsetbie(['table' => $this->data['module'].'_catalogue','language' => $this->currentLanguage()]);

	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/location/location/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$query = '(SELECT location_translate.title 
		FROM location_translate 
		INNER JOIN location_catalogue 
		ON location_translate.objectid = location_catalogue.id  
		WHERE location_translate.module = \''.$this->data['module2'].'\' 
		AND location_translate.language = \''.$this->currentLanguage().'\' 
		AND tb1.catalogueid = location_translate.objectid 
		GROUP BY location_translate.title ) as cat_title,';
		


		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$catalogue = $this->condition_catalogue();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'].' as tb1',
			'join' =>  [
				[
					'location_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				],
			],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/location/location/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$languageDetact = $this->detect_language();
			$this->data['locationList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id,  tb1.catalogueid,  tb2.title, tb2.keyword,  tb1.userid_updated, tb1.publish, tb1.created_at, tb1.updated_at, '.$query.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
				'table' => $this->data['module'].' as tb1',
				'join' =>  [
					[
						'location_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					],
				],
				'where' => $where,
				'where_in' => $catalogue['where_in'],
				'where_in_field' => $catalogue['where_in_field'],
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				
			], TRUE);
			// pre($this->data['locationList']);
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['template'] = 'backend/location/location/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/location/location/create'
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

		 			$storeLanguage = $this->storeLanguage($resultid);
		 			$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'location_translate',
			 			'data' => $storeLanguage,
			 		]);


	 				$flag = $this->create_relationship($resultid);
	 				if($flag > 0){
	 					$session->setFlashdata('message-success', 'Tạo Vị trí Thành Công! Hãy tạo danh mục tiếp theo.');
 						return redirect()->to(BASE_URL.'backend/location/location/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/location/location/index');
	 				}
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/location/location/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$session = session();
		
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/location/location/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id,  tb2.description,  tb1.catalogueid,  tb2.title, tb2.keyword, tb1.userid_updated, tb1.publish, tb1.created_at, tb1.updated_at',

			'table' => $this->data['module'].' as tb1',
			'join' =>  [
					[
						'location_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					],
					
				],
			'where' => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);
		$session = session();
		// if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
		// 	$session->setFlashdata('message-danger', 'Vị trí không tồn tại');
 	// 		return redirect()->to(BASE_URL.'backend/article/article/index');
		// }

		
		
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$update = $this->store(['method' => 'update']);
		 		$updateLanguage = $this->storeLanguage($id);
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'where' => ['id' => $id],
		 			'data' => $update
		 		]);

		 		if($flag > 0){
		 			$flagLang = $this->AutoloadModel->_update([
			 			'table' => $this->data['module'].'_translate',
			 			'where' => ['objectid' => $id,'module' => $this->data['module'],'language' => $this->currentLanguage()],
			 			'data' => $updateLanguage,
			 		]);
			 		$flag = $this->create_relationship($id);
		 			$session->setFlashdata('message-success', 'Cập Nhật Vị trí Thành Công!');
 					return redirect()->to(BASE_URL.'backend/location/location/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['dropdown'] = $this->nestedsetbie->dropdown();
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/location/location/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/location/location/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => 'location_catalogue as tb1',
			'join' =>  [
				[
					'location_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				],
			],
			'where' => [
				'tb1.publish' => 1,
				'tb1.deleted_at' => 0,
				'tb1.id' => $id
			]
		]);
		if($this->data[$this->data['module']] == false){
			$session->setFlashdata('message-danger', 'Nhóm vị trí không tồn tại!');
 			return redirect()->to(BASE_URL.'backend/location/location/index');
		}
		

		if($this->request->getPost('delete')){
		
			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $id
				]
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/location/location/index');
		}

		$this->data['template'] = 'backend/location/location/delete';
		return view('backend/dashboard/layout/home', $this->data);
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
						'location_translate as tb4','tb1.id = tb4.objectid AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
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
			'where_in_field' => 'tb1.catalogueid'
		];

	}

	private function condition_where(){
		$where = [];
		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['tb1.publish'] = $publish;
		}else{
			$where['tb1.publish'] = 1;
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
			$keyword = '(tb2.title LIKE \'%'.$keyword.'%\' OR tb2.keyword LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function storeLanguage($objectid = 0){
		helper(['text']);

		$cat = (int)$this->request->getPost('catalogueid');
		$data = $this->AutoloadModel->_get_where([
			'select' => 'attribute',
			'table' => 'location_translate',
			'where' => [
				'objectid' => $cat,
				'module' => 'location_catalogue',
				'language' => $this->currentLanguage()
			]
		]);

		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'keyword' => slug($this->request->getPost('keyword')),
			'description' => $this->request->getPost('description'),
			'language' => $this->currentLanguage(),
			'module' => $this->data['module'],
			'attribute' => $data['attribute']
		];
		return $store;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
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
				$select = $select.'(SELECT COUNT(objectid) FROM location_translate WHERE location_translate.objectid = tb1.id AND location_translate.module = \''.$this->data['module'].'\' AND  location_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}	
		}


		return [
			'select' => $select,
		];

	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'keyword' => 'required|check_keyword_translate['.$this->data['module'].']',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'keyword' => [
				'required' => 'Bạn phải nhập vào trường từ khóa danh mục',
				'check_keyword_translate' => 'Từ khóa bạn nhập đã tồn tại'
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho Vị trí',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
