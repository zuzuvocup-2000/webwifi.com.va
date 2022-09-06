<?php 
namespace App\Controllers\Backend\Translate;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Translate extends BaseController
{
		protected $data;
		public function __construct(){
		$this->data = [];
	}
	public function translateObject($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translateobject'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$moduleExtract = explode('_', $module);
		$this->data['module'] = $module;
		$select_media = '';
		if($module == 'media'){
			$select_media = ',tb2.area, tb2.customer, tb2.phongcach, tb2.brand ,';
		}
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.canonical, tb2.description, tb2.content, tb2.meta_title, tb2.meta_description'.$select_media,
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if($module == 'brand'){
			$this->data['object'] = array_merge($this->data['object'], $this->AutoloadModel->_get_where([
				'select' => 'tb2.slogan',
				'table' => $module.' as tb1',
				'join' => [
					[
						$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
				'where' => ['tb1.id' => $objectid,'module' => $module]
			]));
		}	
		// pre($this->data['object']);
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['translate'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.canonical, tb2.description, tb2.content, tb2.meta_title, tb2.meta_description'.$select_media,
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$language.'\' ', 'inner'
				]
			],
			'where' => ['tb1.id' => $objectid]
		]);

		$this->data['router'] = $this->AutoloadModel->_get_where([
			'select' => 'view,',
			'table' => 'router',
			'where' => ['module' => $module]
		]);
		// pre($this->data['router']);
		if($module == 'brand' && $this->data['translate'] != []){
			$this->data['translate'] = array_merge($this->data['translate'], $this->AutoloadModel->_get_where([
				'select' => 'tb2.slogan',
				'table' => $module.' as tb1',
				'join' => [
					[
						$moduleExtract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$language.'\' ', 'inner'
					]
				],
				'where' => ['tb1.id' => $objectid]
			]));
		}else if($module == 'brand' && $this->data['translate'] == []){
			$this->data['translate'] = $this->AutoloadModel->_get_where([
				'select' => 'tb2.slogan',
				'table' => $module.' as tb1',
				'join' => [
					[
						$moduleExtract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$language.'\' ', 'inner'
					]
				],
				'where' => ['tb1.id' => $objectid]
			]);
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation($module);
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$store = $this->storeLanguage([
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 		]);
		 		if($module == 'brand'){
					$store['slogan'] = $this->request->getPost('slogan') ;
				}	
				if(isset($this->data['translate']) && is_array($this->data['translate']) && count($this->data['translate'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
			 			'data' => $store,
			 		]);
			 		if($this->data['translate'] != $store['canonical']){
			 			$this->AutoloadModel->_update([
				 			'table' => 'router',
				 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
				 			'data' => [
				 				'canonical' => slug($store['canonical'])
				 			],
				 		]);
			 		}
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $store,
			 		]);
					$this->AutoloadModel->_insert([
			 			'table' => 'router',
			 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
			 			'data' => [
			 				'canonical' => slug($store['canonical']),
			 				'module' => $module,
			 				'objectid' => $objectid,
			 				'language' => $language,
			 				'view' => $this->data['router']['view']
			 			],
			 		]);
				}
		 		if($flag > 0){
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
		 			if($moduleExtract[0] == 'brand'){
		 				return redirect()->to(BASE_URL.'backend/product/brand/'.((isset($moduleExtract[1])) ? 'catalogue' : 'brand').'/index');
		 			}else{
 						return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 			}

		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/translate/translate/translateObject';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function translateProduct($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translateproduct'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$this->data['module'] = $module;
		$moduleExtract = explode('_', $module);
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.content, tb2.sub_title, tb2.sub_content, tb2.made_in, tb2.description',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		// pre($this->data['object']);
		$this->data['object']['sub_title'] = json_decode(base64_decode($this->data['object']['sub_title']));
		$this->data['object']['sub_content'] = json_decode(base64_decode($this->data['object']['sub_content']));
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['translate'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.canonical, tb2.sub_title, tb2.content,tb2.sub_content, tb2.meta_title, tb2.meta_description, tb2.made_in,tb2.description',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$language.'\' ', 'inner'
				]
			],
			'where' => ['tb1.id' => $objectid]
		]);
		if(isset($this->data['translate']) && is_array($this->data['translate']) && count($this->data['translate'])){
			$this->data['translate']['sub_title'] = json_decode(base64_decode($this->data['translate']['sub_title']));
			$this->data['translate']['sub_content'] = json_decode(base64_decode($this->data['translate']['sub_content']));
		}
		$this->data['router'] = $this->AutoloadModel->_get_where([
			'select' => 'view,',
			'table' => 'router',
			'where' => ['module' => $module]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation($module);
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$sub_content = $this->request->getPost('sub_content');
				$store = [
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 			'title' => $this->request->getPost('title'),
		 			'made_in' => $this->request->getPost('made_in'),
		 			'canonical' => slug($this->request->getPost('canonical')),
		 			'meta_title' => $this->request->getPost('meta_title'),
		 			'meta_description' => $this->request->getPost('meta_description'),
		 			'content' => base64_encode(validate_input($this->request->getPost('content'))),
		 			'description' => base64_encode(validate_input($this->request->getPost('description'))),
		 			'sub_title' => base64_encode(json_encode($sub_content['title'])),
		 			'sub_content' => base64_encode(json_encode($sub_content['description'])),
		 		];
				if(isset($this->data['translate']) && is_array($this->data['translate']) && count($this->data['translate'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language],
			 			'data' => $store,
			 		]);
			 		if($this->data['translate']['canonical'] != $store['canonical']){
			 			$this->AutoloadModel->_update([
				 			'table' => 'router',
				 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
				 			'data' => [
				 				'canonical' => $store['canonical']
				 			],
				 		]);
			 		}
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $store,
			 		]);
					$this->AutoloadModel->_insert([
			 			'table' => 'router',
			 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
			 			'data' => [
			 				'canonical' => $store['canonical'],
			 				'module' => $module,
			 				'objectid' => $objectid,
			 				'language' => $language,
			 				'view' => $this->data['router']['view']
			 			],
			 		]);
				}
		 		if($flag > 0){
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
		 			
					return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/translate/translate/translateProduct';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function translateTour($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translatetour'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$this->data['module'] = $module;
		$moduleExtract = explode('_', $module);
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.content, tb2.sub_title, tb2.sub_content, tb2.description, tb2.meta_description, tb2.meta_title',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		$this->data['object']['sub_title'] = json_decode(base64_decode($this->data['object']['sub_title']));
		$this->data['object']['sub_content'] = json_decode(base64_decode($this->data['object']['sub_content']));
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['translate'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.canonical, tb2.sub_title, tb2.content,tb2.sub_content, tb2.meta_title, tb2.meta_description, tb2.description',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$language.'\' ', 'inner'
				]
			],
			'where' => ['tb1.id' => $objectid]
		]);
		if(isset($this->data['translate']) && is_array($this->data['translate']) && count($this->data['translate'])){
			$this->data['translate']['sub_title'] = json_decode(base64_decode($this->data['translate']['sub_title']));
			$this->data['translate']['sub_content'] = json_decode(base64_decode($this->data['translate']['sub_content']));
		}
		$this->data['router'] = $this->AutoloadModel->_get_where([
			'select' => 'view,',
			'table' => 'router',
			'where' => ['module' => $module]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation($module);
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$sub_content = $this->request->getPost('sub_content');
				$store = [
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 			'title' => $this->request->getPost('title'),
		 			'canonical' => slug($this->request->getPost('canonical')),
		 			'meta_title' => $this->request->getPost('meta_title'),
		 			'meta_description' => $this->request->getPost('meta_description'),
		 			'content' => base64_encode(validate_input($this->request->getPost('content'))),
		 			'description' => base64_encode(validate_input($this->request->getPost('description'))),
		 			'sub_title' => base64_encode(json_encode($sub_content['title'])),
		 			'sub_content' => base64_encode(json_encode($sub_content['description'])),
		 		];
				if(isset($this->data['translate']) && is_array($this->data['translate']) && count($this->data['translate'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
			 			'data' => $store,
			 		]);
			 		if($this->data['translate']['canonical'] != $store['canonical']){
			 			$this->AutoloadModel->_update([
				 			'table' => 'router',
				 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
				 			'data' => [
				 				'canonical' => $store['canonical']
				 			],
				 		]);
			 		}
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $store,
			 		]);
					$this->AutoloadModel->_insert([
			 			'table' => 'router',
			 			'where' => ['objectid' => $objectid,'language' => $language,'module' => $module],
			 			'data' => [
			 				'canonical' => $store['canonical'],
			 				'module' => $module,
			 				'objectid' => $objectid,
			 				'language' => $language,
			 				'view' => $this->data['router']['view']
			 			],
			 		]);
				}
		 		if($flag > 0){
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
		 			
					return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/translate/translate/translateTour';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function translateContact($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translatecontact'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$moduleExtract = explode('_', $module);
		$this->data['language'] = $language;
		$this->data['flag'] = $this->AutoloadModel->_get_where([
			'select' => 'image ',
			'table' => 'language',
		],true);
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title,  ',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['dataTrans'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title,  ',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validationContact();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$dataTrans = $this->storeContact([
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 		]);
				$flag = 0;
		 		if(isset($this->data['dataTrans']) && is_array($this->data['dataTrans']) && count($this->data['dataTrans'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language, 'module' => $module],
			 			'data' => $dataTrans,
			 		]);
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $dataTrans,
			 		]);
					
				}
				if($flag > 0){
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 		}
		 		}else{
	        	$this->data['validate'] = $this->validator->listErrors();
			}
		}




		$this->data['template'] = 'backend/translate/translate/translateContact';
		return view('backend/dashboard/layout/home', $this->data);
	}
	public function translateAttributeCatalogue($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translateattributecatalogue'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$moduleExtract = explode('_', $module);
		$this->data['language'] = $language;
		$this->data['flag'] = $this->AutoloadModel->_get_where([
			'select' => 'image ',
			'table' => 'language',
		],true);
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title, tb2.description, tb2.canonical  ',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$this->currentLanguage().'\' AND tb2.module = \''.$module.'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['dataTrans'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title, tb2.description, tb2.canonical  ',
			'table' => $module.' as tb1',
			'join' => [
					[
						'attribute_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\'   AND tb2.language = \''.$language.'\' ','inner'
					],
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validationContact();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$dataTrans = $this->storeAttribute([
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 		]);
				$flag = 0;
		 		if(isset($this->data['dataTrans']) && is_array($this->data['dataTrans']) && count($this->data['dataTrans'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language, 'module' => $module],
			 			'data' => $dataTrans,
			 		]);
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $dataTrans,
			 		]);
					
				
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 		}
		 		}else{
	        	$this->data['validate'] = $this->validator->listErrors();
			}
		}




		$this->data['template'] = 'backend/translate/translate/translateAttributeCatalogue';
		return view('backend/dashboard/layout/home', $this->data);
	}
	public function translateAttribute($objectid = 0, $module = '', $language = ''){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/translate/translate/translateattribute'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$objectid = (int)$objectid;
		$moduleExtract = explode('_', $module);
		$this->data['language'] = $language;
		$this->data['flag'] = $this->AutoloadModel->_get_where([
			'select' => 'image ',
			'table' => 'language',
		],true);
		$this->data['object'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title, tb2.description, tb2.canonical  ',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$this->currentLanguage().'\' AND tb2.module = \''.$module.'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if(!isset($this->data['object']) || is_array($this->data['object']) == false || count($this->data['object']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
			return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		}
		$this->data['dataTrans'] = $this->AutoloadModel->_get_where([
			'select' => 'tb2.objectid, tb2.title, tb2.description, tb2.canonical ',
			'table' => $module.' as tb1',
			'join' => [
				[
					$moduleExtract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $objectid,'module' => $module]
		]);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validationContact();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$dataTrans = $this->storeAttribute([
		 			'objectid' => $objectid,
		 			'module' => $module,
		 			'language' => $language,
		 		]);
				$flag = 0;
		 		if(isset($this->data['dataTrans']) && is_array($this->data['dataTrans']) && count($this->data['dataTrans'])){
					$flag = $this->AutoloadModel->_update([
			 			'table' => $moduleExtract[0].'_translate',
			 			'where' => ['objectid' => $objectid,'language' => $language, 'module' => $module],
			 			'data' => $dataTrans,
			 		]);
				}else{
					$flag = $this->AutoloadModel->_insert([
			 			'table' => $moduleExtract[0].'_translate',
			 			'data' => $dataTrans,
			 		]);
		 			$session->setFlashdata('message-success', 'Tạo Bản Dịch Thành Công! Hãy tạo danh mục tiếp theo.');
 					return redirect()->to(BASE_URL.'backend/'.$moduleExtract[0].'/'.((count($moduleExtract) == 1) ? $moduleExtract[0] : $moduleExtract[1]).'/index');
		 			}
		 		}else{
	        	$this->data['validate'] = $this->validator->listErrors();
			}
		}




		$this->data['template'] = 'backend/translate/translate/translateAttribute';
		return view('backend/dashboard/layout/home', $this->data);
	}
	
	private function storeLanguage($param = []){
		helper(['text']);
		$store = [
			'objectid' => $param['objectid'],
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('canonical')),
			'description' => base64_encode($this->request->getPost('description')),
			'content' => base64_encode($this->request->getPost('content')),
			'meta_title' => validate_input($this->request->getPost('meta_title')),
			'meta_description' => validate_input($this->request->getPost('meta_description')),
			'language' => $param['language'],
			'module' => $param['module'],
			'updated_at' => $this->currentTime,
		];

		if($param['module'] == 'media'){
			$store['brand'] = validate_input($this->request->getPost('brand'));
			$store['area'] = validate_input($this->request->getPost('area'));
			$store['phongcach'] = validate_input($this->request->getPost('phongcach'));
			$store['customer'] = validate_input($this->request->getPost('customer'));
		}

		return $store;
	}
	private function storeContact($param = []){
		helper(['text']);
		$store = [
			'title' => $this->request->getPost('title'),
			'language' => $param['language'],
			'module' => $param['module'],
			'objectid' => $param['objectid'],
		];

		return $store;
	}
	private function storeAttribute($param = []){
		helper(['text']);
		$store = [
			'title' => $this->request->getPost('title'),
			'description' => $this->request->getPost('description'),
			'canonical' => slug($this->request->getPost('canonical')),
			'language' => $param['language'],
			'module' => $param['module'],
			'module_primary' => 'tour',
			'objectid' => $param['objectid'],
		];

		return $store;
	}
	private function validationContact($module = ''){
		$validate = [
			'title' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			
		];
		return [
			'validate'      => $validate,
			'errorValidate' => $errorValidate,
		];
	}
	private function validation($module = ''){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_canonical['.$module.']',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_canonical' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
		];
		return [
			'validate'      => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
