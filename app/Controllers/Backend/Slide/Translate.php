<?php 
namespace App\Controllers\Backend\Slide;
use App\Controllers\BaseController;

class Translate extends BaseController
{
		protected $data;
		public function __construct(){
			$this->data = [];
			$this->data['module'] = 'slide';
		}

		public function translate($id = 0,  $language = 'vi'){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/slide/translate/translate'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data[$this->data['module'].'_catalogue'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id,tb1.keyword, tb2.title, tb2.description',
			'table'    => $this->data['module'].'_catalogue as tb1',
			'join' => [
				[
					$this->data['module'].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "slide_catalogue" AND tb2.language = \''.$this->currentLanguage().'\' ', 'inner'
				],
			],
			'where'    => [
				'tb1.deleted_at' => 0,
				'tb1.id' => $id
			],
		]);
		if(!isset($this->data[$this->data['module'].'_catalogue']) || is_array($this->data[$this->data['module'].'_catalogue']) == false || count($this->data[$this->data['module'].'_catalogue']) == 0){
			$session->setFlashdata('message-danger', 'Slide không tồn tại');
 			return redirect()->to(BASE_URL.'backend/slide/slide/index');
		}
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.image, tb1.order, tb2.title, tb2.canonical, tb2.alt, tb2.description, tb2.content',
			'table'    => $this->data['module'].' as tb1',
			'join'    => [
				[
					'slide_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "slide" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
				]
			],
			'where'    => [
				'tb1.deleted_at' => 0,
				'tb1.catalogueid' => $id
			],
		],true);
		$this->data[$this->data['module'].'_catalogue_translate'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id,tb1.keyword, tb2.title, tb2.description',
			'table'    => $this->data['module'].'_catalogue as tb1',
			'join' => [
				[
					$this->data['module'].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "slide_catalogue" AND tb2.language = \''.$language.'\' ', 'inner'
				],
			],
			'where'    => [
				'tb1.deleted_at' => 0,
				'tb1.id' => $id
			],
		]);
		$this->data[$this->data['module'].'_translate'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.image, tb1.order, tb2.title, tb2.canonical, tb2.alt, tb2.description, tb2.content',
			'table'    => $this->data['module'].' as tb1',
			'join'    => [
				[
					'slide_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "slide" AND tb2.language = \''.$language.'\'', 'inner'
				]
			],
			'where'    => [
				'tb1.deleted_at' => 0,
				'tb1.catalogueid' => $id
			],
		],true);
		if(!isset($this->data[$this->data['module'].'_catalogue_translate']) || !is_array($this->data[$this->data['module'].'_catalogue_translate']) || count($this->data[$this->data['module'].'_catalogue_translate']) == 0){
			if($this->request->getMethod() == 'post'){
				$insertLangCat =  $this->AutoloadModel->_insert([
 					'table' => 'slide_translate',
	 		 		'data'  => [
	 		 			'module' => 'slide_catalogue',
	 		 			'title' => $this->request->getPost('title_catalogue'),
	 		 			'description' => $this->request->getPost('description_catalogue'),
	 		 			'objectid' => $id,
	 		 			'language' => $language
	 		 		],
 				]);
				if($insertLangCat > 0){
					$this->AutoloadModel->_delete([
			 			'table' => 'slide',
			 			'where'  => [
			 				'catalogueid' => $id,
			 				'language' => $language,
			 			],
			 		]);
			 		$this->AutoloadModel->_delete([
			 			'table' => 'slide_translate',
			 			'where'  => [
			 				'catalogueid' => $id,
			 				'module' => 'slide',
		 		 			'language' => $language
			 			],
			 		]);
 					$store = $this->store(['method' => 'create', 'catalogueid' => $id, 'language' => $language]);
	 				$insert_batch = $this->AutoloadModel->_create_batch([
			 			'table' => 'slide',
			 			'data'  => $store,
			 		]);

	 				if($insert_batch > 0){
	 					$storeLang = $this->storeLanguage(count($store), $id, $language);
	 					$insert_batch_lang = $this->AutoloadModel->_create_batch([
				 			'table' => 'slide_translate',
				 			'data'  => $storeLang,
				 		]);
	 				}
 				}
				$session->setFlashdata('message-success', 'Tạo bản dịch thành công! Hãy tạo danh mục tiếp theo.');
				return redirect()->to(BASE_URL.'backend/slide/slide/index');
			}
		}else{
			if($this->request->getMethod() == 'post'){
				$updateLangCat =  $this->AutoloadModel->_update([
					'table' => 'slide_translate',
			 		'data'  => [
			 			'title' => $this->request->getPost('title_catalogue'),
			 		],
			 		'where' => [
			 			'module' => 'slide_catalogue',
			 			'objectid' => $id,
			 			'language' => $language
			 		]
				]);

				$this->AutoloadModel->_delete([
		 			'table' => 'slide',
		 			'where'  => [
		 				'catalogueid' => $id,
		 				'language' => $language,
		 			],
		 		]);
		 		$this->AutoloadModel->_delete([
		 			'table' => 'slide_translate',
		 			'where'  => [
		 				'catalogueid' => $id,
		 				'module' => 'slide',
	 		 			'language' => $language
		 			],
		 		]);
				$store = $this->store(['method' => 'create', 'catalogueid' => $id, 'language' => $language]);
				$updateCatId = $this->AutoloadModel->_create_batch([
		 			'table' => 'slide',
		 			'data'  => $store,
		 		]);
				$storeLang = $this->storeLanguage(count($store), $id);
		 		$insert_batch_lang = $this->AutoloadModel->_create_batch([
		 			'table' => 'slide_translate',
		 			'data'  => $storeLang,
		 		]);

				$session->setFlashdata('message-success', 'Tạo bản dịch thành công! Hãy tạo danh mục tiếp theo.');
				return redirect()->to(BASE_URL.'backend/slide/slide/index');
			}
		}
		
		$this->data['template'] = 'backend/translate/translate/translateSlide';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function store($param = []){
		helper(['text']);

		$album = $this->request->getPost('album');
		$store = [];
		if(isset($album) && is_array($album) && count($album)){
			$count = 0;
			foreach ($album as $key => $value) {
				$store[$count] = [
					'image' => $value,
					'catalogueid' => $param['catalogueid'],
					'language' => $param['language']
				];
				if($param['method'] == 'create' && isset($param['method'])){	
		 			$store[$count]['created_at'] = $this->currentTime;
		 			$store[$count]['userid_created'] = $this->auth['id'];
		 		}else{
		 			$store[$count]['updated_at'] = $this->currentTime;
		 			$store[$count]['userid_updated'] = $this->auth['id'];
		 		}
				$count ++;
			}
		}
 		return $store;
	}

	private function storeLanguage($count = 0, $catalogueid = 0, $language = 'vi'){
		$slide_data  = $this->AutoloadModel->_get_where([
			'select' => 'id, image, order, catalogueid',
			'table' => 'slide',
			'where' => [
				'catalogueid' => $catalogueid,
			],
			'limit' => $count,
			'order_by' => 'created_at desc'
		],true);
		$data = $this->request->getPost('data');
		if(isset($data) && is_array($data) && count($data)){
			foreach ($data as $key => $value) {
				$data[$key] = json_decode(base64_decode($value),true);
			}
		}
		$store = [];
		if(isset($slide_data) && is_array($slide_data) && count($slide_data)){
			foreach ($slide_data as $key => $value) {
				$alt = (isset($data[$key]['alt']) && $data[$key]['alt'] != null ? $data[$key]['alt'] : '');
				$title = (isset($data[$key]['title']) && $data[$key]['title'] != null ? $data[$key]['title'] : '');
				$canonical = (isset($data[$key]['canonical']) && $data[$key]['canonical'] != null ? $data[$key]['canonical'] : '');
				$description = (isset($data[$key]['description']) && $data[$key]['description'] != null ? $data[$key]['description'] : '');
				$content = (isset($data[$key]['content']) && $data[$key]['content'] != null ? $data[$key]['content'] : '');
				$store[] = [
					'catalogueid' => $value['catalogueid'],
					'module' => 'slide',
					'objectid' => $value['id'],
					'alt' => $alt,
					'language' => $language,
					'title' => $title,
					'canonical' => $canonical,
					'description' => $description,
					'content' => $content,
				];
			}
		}
 		return $store;
	}

}