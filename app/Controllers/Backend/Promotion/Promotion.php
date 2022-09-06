<?php 
namespace App\Controllers\Backend\Promotion;
use App\Controllers\BaseController;

class Promotion extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'promotion';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/promotion/promotion/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$this->data['code'] = $this->AutoloadModel->_get_where([
			'select' => 'id, suffix, prefix, module, num0',
			'table' => 'id_general',
			'where' => ['module' => $this->data['module']]
		]);
		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.title, tb1.price',
			'table' => $this->data['module'].' as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'group_by' => 'tb1.id',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/promotion/promotion/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['promotionList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.title, tb1.price, tb1.max, tb1.promotionid, tb1.publish , tb1.login, tb1.discount_value',
				'table' =>$this->data['module'].' as tb1',
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.id asc',
				'group_by' => 'tb1.id'
			], TRUE);
		}
		$this->data['template'] = 'backend/promotion/promotion/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/promotion/promotion/create'
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
 					$session->setFlashdata('message-success', 'Tạo khuyến mãi thành công! Hãy tạo danh mục tiếp theo.');
					return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
 				}else{
 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
 					return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
 				}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/promotion/promotion/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/promotion/promotion/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Khuyến mãi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
		}
		$this->data[$this->data['module']]['daterange'] = date('d/m/Y', strtotime($this->data[$this->data['module']]['date_start'])).' - '.date('d/m/Y', strtotime($this->data[$this->data['module']]['date_end']));
		if($this->request->getMethod() == 'post'){

			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$update = $this->store(['method' => 'update']);
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'where' => ['id' => $id],
		 			'data' => $update
		 		]);

		 		if($flag > 0){
		 			$session->setFlashdata('message-success', 'Cập nhật khuyến mãi thành công!');
 					return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/promotion/promotion/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/promotion/promotion/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title ',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Khuyến mãi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
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

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/promotion/promotion/index');
		}

		$this->data['template'] = 'backend/promotion/promotion/delete';
		return view('backend/dashboard/layout/home', $this->data);
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
			$keyword = '(promotionid LIKE \'%'.$keyword.'%\' OR title LIKE \'%'.$keyword.'%\' OR max LIKE \'%'.$keyword.'%\' )';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'promotionid' => $this->request->getPost('promotionid'),
 			'title' => $this->request->getPost('title'),
 			'max' => $this->request->getPost('max'),
 			'type' => $this->request->getPost('type'),
 			'image' => $this->request->getPost('image'),
 			'discount_value' => $this->request->getPost('discount_value'),
 			'publish' => 1,
		];
		$daterange = $this->request->getPost('daterange');
		if(isset($daterange) && !empty($daterange)){
			$date_explode = explode('-', $daterange);
			$store['date_start'] = date('Y-m-d 23:59:59', strtotime(trim($date_explode[1])));
			$store['date_end'] = date('Y-m-d 00:00:00', strtotime(trim($date_explode[0])));
		}
 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

	
	private function validation(){
		$validate = [
			'title' => 'required',
			'promotionid' => 'required|min_length[6]|max_length[20]|check_promotionid['.$this->data['module'].']',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề khuyến mãi!'
			],
			'promotionidid' => [
				'required' => 'Bạn phải nhập vào trường Mã khuyến mãi!',
				'min_length' => 'Mã khuyến mãi phải tối thiểu 6 kí tự!',
				'max_length' => 'Mã khuyến mãi tối đa 20 kí tự!',
				'check_promotionidid' => 'Mã khuyến mãi đã tồn tại!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
