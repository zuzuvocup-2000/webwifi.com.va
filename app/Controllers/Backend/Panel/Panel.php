<?php 
namespace App\Controllers\Backend\Panel;
use App\Controllers\BaseController;
use App\Controllers\Backend\Panel\Libraries\Configbie;
use App\Libraries\Nestedsetbie;

class Panel extends BaseController{
	protected $data;
	public $nestedsetbie;
	public $configbie;


	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'panel';
		$this->nestedsetbie = new Nestedsetbie(['table' => $this->data['module'],'language' => $this->currentLanguage()]);

	}

	public function index($language = ''){
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/panel/panel/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$this->data['languageSelect'] = $language;
		$select = $this->configbie->panel();
		$this->data['locate'] = $select['locate'];
		$languageDetact = $this->detect_language();
		$this->data['panel'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.keyword, tb2.title, tb2.description, tb1.module, tb1.catalogue, tb1.locate,tb1.id, tb1.type_data, '.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$language.'\'', 'inner'
				]
			],
			'where' => [
				'tb1.deleted_at' => 0
			],
			'order_by' => 'tb1.locate asc'
		], TRUE);

		$session = session();
		$this->data['languageSelect'] = $language;
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/panel/panel/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create($language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/panel/panel/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$this->data['languageSelect'] = $language;
		$select = $this->configbie->panel();
		$this->data['locate'] = $select['locate'];
		$this->data['dropdown'] = $select['dropdown'];
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$store = $this->store(['method' => 'create','language' => $language]);
				$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $store,
		 		]);
		 		if($resultid > 0){
		 			$storeLanguage = $this->storeLanguage($resultid);
					$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'panel_translate',
			 			'data' => $storeLanguage,
			 		]);
		 			$session->setFlashdata('message-success', 'Tạo Giao diện Thành Công! Hãy tạo danh mục tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/panel/panel/index/'.$language);
		 		}
		 	}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	 	}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/panel/panel/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0, $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/panel/panel/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$select = $this->configbie->panel();
		$this->data['locate'] = $select['locate'];
		$this->data['dropdown'] = $select['dropdown'];
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$this->data['languageSelect'] = $language;
		
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.keyword, tb2.title, tb2.description, tb1.module, tb1.catalogue, tb1.locate,tb1.id, tb1.type_data, tb2.canonical, tb1.image, tb1.time_end',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$language.'\'', 'inner'
				]
			],
			'where' => [
				'tb1.id' => $id,
				'tb1.deleted_at' => 0
			]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$store = $this->store(['method' => 'update','language' => $language]);
				$resultid = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'data' => $store,
		 			'where' => ['id' => $id],
		 		]);
		 		if($resultid > 0){
					$storeLanguage = $this->storeLanguage($id);
					$insertid = $this->AutoloadModel->_update([
			 			'table' => 'panel_translate',
			 			'data' => $storeLanguage,
			 			'where' => ['objectid' => $id, 'language' => $this->currentLanguage()],
			 		]);
		 			$session->setFlashdata('message-success', 'Cập nhật Giao diện Thành Công! Hãy cập nhật danh mục tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/panel/panel/index');
		 		}
		 	}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	 	}
		$this->data['id'] = $id;
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/panel/panel/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0, $language = ''){
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/panel/panel/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$this->data['languageSelect'] = $language;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.keyword, tb2.title, tb2.description, tb1.module, tb1.catalogue, tb1.locate,tb1.id, tb1.type_data, tb2.canonical, tb1.image, tb1.time_end',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$language.'\'', 'inner'
				]
			],
			'where' => [
				'tb1.id' => $id,
				'tb1.deleted_at' => 0
			]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Giao diện không tồn tại');
 			return redirect()->to(BASE_URL.'backend/panel/panel/index');
		}

		if($this->request->getPost('delete')){
		
			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $id,
				]
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/panel/panel/index');
		}

		$this->data['template'] = 'backend/panel/panel/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function translate($id = 0, $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/panel/panel/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$select = $this->configbie->panel();
		$this->data['locate'] = $select['locate'];
		$this->data['dropdown'] = $select['dropdown'];
		if($language == ''){
			$language = $this->currentLanguage();
		}
		$this->data['languageSelect'] = $language;
		$check_language = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$language.'\'', 'inner'
				]
			],
			'where' => [
				'tb1.id' => $id,
				'tb1.deleted_at' => 0
			],
			'count' => true
		]);
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.keyword, tb2.title, tb2.description, tb1.module, tb1.catalogue, tb1.locate,tb1.id, tb1.type_data, tb2.canonical, tb1.image, tb1.time_end',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$language.'\'', 'left'
				]
			],
			'where' => [
				'tb1.id' => $id,
				'tb1.deleted_at' => 0
			]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$store = $this->store(['method' => 'update','language' => $language]);
				if(isset($check_language) && $check_language == 0){
					$storeLanguage = [
						'objectid' => $id,
			 			'title' => $this->request->getPost('title'),
			 			'description' => $this->request->getPost('description'),
			 			'canonical' => slug($this->request->getPost('canonical')),
						'language' => $language,
					];
					$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'panel_translate',
			 			'data' => $storeLanguage,
			 		]);
				}elsE{
					$storeLanguage = [
			 			'title' => $this->request->getPost('title'),
			 			'description' => $this->request->getPost('description'),
			 			'canonical' => slug($this->request->getPost('canonical')),
					];
					$insertid = $this->AutoloadModel->_update([
			 			'table' => 'panel_translate',
			 			'data' => $storeLanguage,
			 			'where' => ['objectid' => $id, 'language' => $language],
			 		]);
				}
	 			$session->setFlashdata('message-success', 'Cập nhật Bản dịch Thành Công!');
					return redirect()->to(BASE_URL.'backend/panel/panel/index');
		 	}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
	 	}
		$this->data['id'] = $id;
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['template'] = 'backend/panel/panel/translate';
		return view('backend/dashboard/layout/home', $this->data);
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
				$select = $select.'(SELECT COUNT(objectid) FROM panel_translate WHERE panel_translate.objectid = tb1.id  AND  panel_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
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
			'keyword' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập Tiêu đề giao diện!',
			],
			'keyword' => [
				'required' => 'Bạn phải nhập Từ khóa giao diện!',
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
	
	private function storeLanguage($objectid = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
 			'title' => $this->request->getPost('title'),
 			'description' => $this->request->getPost('description'),
 			'canonical' => slug($this->request->getPost('canonical')),
			'language' => $this->currentLanguage(),
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
		$type=  $this->request->getPost('select_type');
		$module_explode = explode('_',$this->request->getPost('module'));
		if(isset($module_explode[1]) && $module_explode[1] == 'catalogue' && $type == ''){
			$type = ['normal'];
		}
		$store = [
 			'module' => $this->request->getPost('module'),
 			'catalogue' => json_encode($catalogue),
 			'keyword' => slug($this->request->getPost('keyword')),
 			'time_end' => $this->request->getPost('time_end'),
 			'image' => $this->request->getPost('image'),
 			'type_data' => json_encode($type),
 			'locate' => $this->request->getPost('locate'),
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

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb1.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
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
