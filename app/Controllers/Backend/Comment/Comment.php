<?php 
namespace App\Controllers\Backend\Comment;
use App\Controllers\BaseController;

class Comment extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'comment';

	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/comment/comment/index'
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
			'group_by' => 'id',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/comment/comment/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			
			$this->data['commentList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, phone, email, url, publish, comment, module,language, rate, parentid',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'parentid asc, created_at desc',
				'group_by' => 'id'
			], TRUE);
			if(isset($this->data['commentList']) && is_array($this->data['commentList']) && count($this->data['commentList'])){
				foreach ($this->data['commentList'] as $key => $value) {
					$this->data['commentList'][$key]['comment'] = strip_tags(base64_decode($value['comment']));
				}
			}
		}
		$this->data['template'] = 'backend/comment/comment/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$this->data['cat'] = [
			0 => 'Chọn Module',
			'article' => 'Bài viết',
			'tour' => 'Tour'
		];
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$insert = $this->store(['method' => 'create']);
		 		$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);

		 		
 				if($resultid > 0){
 					$session->setFlashdata('message-success', 'Tạo Comment Thành Công! Hãy tạo Comment tiếp theo.');
						return redirect()->to(BASE_URL.'backend/comment/comment/index');
 				}else{
 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
 					return redirect()->to(BASE_URL.'backend/comment/comment/index');
 				}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/comment/comment/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, phone, email, url, publish, comment, module,language, rate, album, language',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(isset($this->data[$this->data['module']]) && is_array($this->data[$this->data['module']]) && count($this->data[$this->data['module']])){
			$this->data[$this->data['module']]['comment'] = base64_decode($this->data[$this->data['module']]['comment']);
		}
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Comment không tồn tại');
 			return redirect()->to(BASE_URL.'backend/comment/comment/index');
		}
		$this->data['cat'] = [
			0 => 'Chọn Module',
			'article' => 'Bài viết',
			'tour' => 'Tour'
		];

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
		 			$session->setFlashdata('message-success', 'Cập Nhật Bài Viết Thành Công!');
 					return redirect()->to(BASE_URL.'backend/comment/comment/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/comment/comment/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, phone, email, url, publish, comment, module,language, rate, album, language',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(isset($this->data[$this->data['module']]) && is_array($this->data[$this->data['module']]) && count($this->data[$this->data['module']])){
			$this->data[$this->data['module']]['comment'] = strip_tags(base64_decode($this->data[$this->data['module']]['comment']));
		}
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.'backend/comment/comment/index');
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
			return redirect()->to(BASE_URL.'backend/comment/comment/index');
		}

		$this->data['template'] = 'backend/comment/comment/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function condition_where(){
		$where = [];
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
		$language = $this->request->getGet('language');
		if(isset($language)){
			$where['language'] = $language;
		}else{
			$where['language'] = $this->currentLanguage();
		}
		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' )';
		}
		return $keyword;
	}

	private function store($param = []){
		$image = $this->request->getPost('image');
		$album = $this->request->getPost('album');
		if(isset($image) && $image != ''){
			$image = $image;
		}else{
			$image = 'public/avatar.png';
		}
		$store = [
 			'fullname' => $this->request->getPost('fullname'),
 			'phone' => $this->request->getPost('phone'),
 			'email' => $this->request->getPost('email'),
 			'url' => $this->request->getPost('url'),
 			'language' => $this->currentLanguage(),
 			'module' => $this->request->getPost('module'),
 			'rate' => $this->request->getPost('rate'),
 			'comment' => base64_encode($this->request->getPost('comment')),
 			'image' => $image,
 			'album' => json_encode($album, TRUE),
 			'publish' => $this->request->getPost('publish'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){	
 			$store['created_at'] = $this->currentTime;
 			
 		}else{
 			$store['updated_at'] = $this->currentTime;
 		}
 		return $store;
	}

	private function validation(){
		$validate = [
			'fullname' => 'required',
		];
		$errorValidate = [
			'fullname' => [
				'required' => 'Bạn phải nhập vào trường Họ và tên'
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
