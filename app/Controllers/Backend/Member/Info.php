<?php 
namespace App\Controllers\Backend\Member;
use App\Controllers\BaseController;
use App\Controllers\Backend\Member\Libraries\Configbie;

class Info extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->configbie = new ConfigBie();
		$this->data['module'] = 'member_info';
		$this->data['type'] = $this->configbie->index();
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/member/info/index'
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
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/member/info/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['memberCatalogueList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, userid_created, order, userid_updated,type,  publish, (SELECT COUNT(id) FROM member WHERE member.catalogueid = member_info.id) as total_user',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'order_by' => 'order desc',
				'start' => $page * $config['per_page'],
			], TRUE);


		}

		$this->data['template'] = 'backend/member/info/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
				'type' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm Đảng viên!',
				],
				'type' => [
					'required' => 'Bạn phải chọn kiểu dữ liệu!'
				]
			];


			if ($this->validate($validate, $errorValidate)){
		 		$insert = $this->store(['method' => 'create']);
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Thêm mới người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/member/info/create');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/member/info/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, type',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Nhóm Đảng viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/member/info/index');
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm Đảng viên!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$update = $this->store(['method' => 'update']);
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/member/info/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/member/info/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title,type',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Nhóm Đảng viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/member/info/index');
		}

		if($this->request->getPost('delete')){
			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $id],
				'table' => $this->data['module']
			]);

			$result = $this->AutoloadModel->_delete([
				'where' => [
					'type' => $this->data[$this->data['module']]['type'],
					'catalogueid' => $id,
					'module' => 'member',
				],
				'table' => 'member_relationship'
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/member/info/index');
		}

		$this->data['template'] = 'backend/member/info/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != -1 && $gender != '' && isset($gender)){
			$where['gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		$type = $this->request->getGet('type');
		if(isset($type) && $type != ''){
			$where['type'] = $type;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'title' => $this->request->getPost('title'),
 			'type' => $this->request->getPost('type'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

}
