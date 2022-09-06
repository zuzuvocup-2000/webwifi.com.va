<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class System extends BaseController{
	public function __construct(){
		
	}

	public function create_input(){
		$param['select_catalogue'] = $this->request->getPost('select_catalogue');
		$param['name_system'] = $this->request->getPost('name_system');
		$param['keyword'] = $this->request->getPost('keyword');
		$param['start_text'] = $this->request->getPost('start_text');
		$param['end_text'] = $this->request->getPost('end_text');
		$param['attention'] = $this->request->getPost('attention');
		$param['type_input'] = $this->request->getPost('type_input');
		$param['title_link'] = $this->request->getPost('title_link');
		$param['link_canonical'] = $this->request->getPost('link_canonical');
		$param['keyword'] = slug_database($param['keyword']);
		$param['link_canonical'] = slug($param['link_canonical']);

		$check_keyword = $this->check_keyword($param['keyword'],'system_translate');

		if($check_keyword > 0){
			if($param['type_input'] == 'select' || $param['type_input'] == 'select2'){
				$dataInsert = [
					'created_at' => $this->currentTime,
					'userid_created' => $this->auth['id'],
					'catalogueid' => $param['select_catalogue']
				];
				$flag = $this->AutoloadModel->_insert([
					'table' => 'system',
					'data' => $dataInsert
				]);

				if($flag > 0){
					$storeLanguage = [
						'objectid' => $flag,
						'title' => $param['name_system'],
						'keyword' => $param['keyword'],
						'attention' => $param['attention'],
						'title_link' => $param['title_link'],
						'link' => $param['link_canonical'],
						'type' => $param['type_input'],
						'language' => $this->currentLanguage(),
						'module' => 'system',
						'created_at' => $this->currentTime,
						'userid_created' => $this->auth['id']
					];
		 			$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'system_select',
			 			'data' => $storeLanguage,
			 		]);


				}
			}
			else{
				$dataInsert = [
					'created_at' => $this->currentTime,
					'userid_created' => $this->auth['id'],
					'catalogueid' => $param['select_catalogue']
				];
				$flag = $this->AutoloadModel->_insert([
					'table' => 'system',
					'data' => $dataInsert
				]);

				if($flag > 0){
					$storeLanguage = [
						'objectid' => $flag,
						'title' => $param['name_system'],
						'keyword' => $param['keyword'],
						'start_text' => $param['start_text'],
						'end_text' => $param['end_text'],
						'attention' => $param['attention'],
						'title_link' => $param['title_link'],
						'link' => $param['link_canonical'],
						'type' => $param['type_input'],
						'language' => $this->currentLanguage(),
						'module' => 'system',
						'created_at' => $this->currentTime,
						'userid_created' => $this->auth['id']
					];
		 			$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'system_translate',
			 			'data' => $storeLanguage,
			 		]);


				}
			}
			

			$param['select_catalogue'] = "system-".$param['select_catalogue'];

			$param['data'] = [
				'select_catalogue' => $param['select_catalogue'],
				'name_system' => $param['name_system'],
				'keyword' => $param['keyword'],
				'start_text' => $param['start_text'],
				'end_text' => $param['end_text'],
				'attention' => $param['attention'],
				'link_canonical' => $param['link_canonical'],
				'title_link' => $param['title_link'],
				'type_input' => $param['type_input'] 
			];
			echo json_encode($param['data']);die();

		}else{
			$param['data'] = '';
			echo json_encode($param['data']);die();
		}
		
		// pre($param['data'])
	}

	public function create_catalogue(){
		$session = session();

		$param['name_system_catalogue'] = $this->request->getPost('name_system_catalogue');
		$param['keyword_system_catalogue'] = $this->request->getPost('keyword_system_catalogue');
		$param['description_system_catalogue'] = $this->request->getPost('description_system_catalogue');
		$param['keyword_system_catalogue'] = "system-".slug_database($param['keyword_system_catalogue']);

		$dataInsert = [
			'created_at' => $this->currentTime,
			'userid_created' => $this->auth['id']
		];
		$flag = $this->AutoloadModel->_insert([
			'table' => 'system_catalogue',
			'data' => $dataInsert
		]);

		if($flag > 0){
			$storeLanguage = [
				'objectid' => $flag,
				'title' => $param['name_system_catalogue'],
				'description' => base64_encode($param['description_system_catalogue']),
				'keyword' => $param['keyword_system_catalogue'],
				'language' => $this->currentLanguage(),
				'module' => 'system_catalogue',
				'created_at' => $this->currentTime,
				'userid_created' => $this->auth['id']
			];
 			$insertid = $this->AutoloadModel->_insert([
	 			'table' => 'system_translate',
	 			'data' => $storeLanguage,
	 		]);
		}


		$param['data'] = [
			'name_system_catalogue' => $param['name_system_catalogue'],
			'keyword_system_catalogue' => $param['keyword_system_catalogue'],
			'description_system_catalogue' => $param['description_system_catalogue'],
		];
		echo json_encode($param['data']);die();
	}

	public function create_select(){
		$param['select'] = $this->request->getPost('select');
		$flag = 0;
		$select_title = json_encode($param['select']['title_item']);
		$select_value = json_encode($param['select']['value_item']);
		$user_select = $param['select']['value_item'][0];
		$keyword = $param['select']['name_select'];
		// pre($param['select']);
		$_save = [];


		if(isset($param['select']) && is_array($param['select']) && count($param['select'])){
			
			$_save = [
				'select_title' => $select_title,
				'select_value' => $select_value,
				'user_select' => $user_select,
				'updated_at' => $this->currentTime
			];
			


			$flag = $this->AutoloadModel->_update([
				'table' => 'system_select',
				'where' => ['keyword' => $keyword],
				'data' => $_save
			]);
		}
		die();
	}

	private function check_keyword($keyword = '', string $module = ''): bool{
		$count = 0;
		$count = $this->AutoloadModel->_get_where([
			'select' => 'objectid',
			'table' => $module,
			'where' => ['keyword' => $keyword],
			'count' => TRUE
		]);

		if($count > 0){
			return false;
		}
		return true;
 	}

 // 	public function create_contract_detail(int $insert_id = 0){
	// 	$billing = $this->request->getPost('billing');
	// 	$save = [];
	// 	if(isset($billing['billingPrice']) && is_array($billing['billingPrice']) && count($billing['billingPrice'])){
	// 		foreach($billing['billingPrice'] as $key => $val){
	// 			$save[] = [
	// 				'contractid' => $insert_id,
	// 				'money' => convertMoney($val),
	// 				'cashierid' => $billing['billingCashierId'][$key],
	// 				'date' => gettime($billing['billingDate'][$key],'Y-m-d H:i:s'),
	// 			];
	// 		}
	// 	}
	// 	if(isset($save) && is_array($save) && count($save)){
	// 		$flag  = $this->AutoloadModel->_create_batch([
	// 			'table' => 'contract_website_detail',
	// 			'data' => $save,
	// 		]);
	// 	}
		

	// 	return $flag;
	// }
	
}
