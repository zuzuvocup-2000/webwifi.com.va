<?php
namespace App\Controllers\Backend\Contact;
use App\Controllers\BaseController;
use App\Controllers\Backend\Contact\Libraries\Configbie;

class Contact extends BaseController{
	protected $data;
	public $configbie;

	public function __construct(){
		$this->configbie = new ConfigBie();
		$this->data = [];
		$this->data['module'] = 'contact';
		$this->data['type'] = $this->configbie->select();
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/contact/contact/index'
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
			'select' => 'tb1.id',
			'table' => $this->data['module'].' as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'group_by' => 'tb1.id',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/contact/contact/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['contactList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.contactid, tb1.email, tb1.fullname, tb1.title, tb1.content, tb1.phone, tb1.reply, tb1.type, tb1.created_at, tb1.userid_replied, tb1.replied_at, tb2.fullname as admin, tb1.address,  tb1.theloai',
				'table' => $this->data['module'].' as tb1',
				'where' => $where,
				'keyword' => $keyword,
				'join' => [
					[
						'user as tb2',  'tb1.userid_replied = tb2.id AND tb2.deleted_at = 0 AND tb2.publish = 1', 'left'
					]
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.created_at desc',
				'group_by' => 'tb1.id'
			], TRUE);
		}
		$this->data['template'] = 'backend/contact/contact/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function reply($id = 0){
		$session = session();
		$id = (int)$id;
		$this->data['contact'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.contactid, tb1.email, tb1.fullname, tb1.title, tb1.content, tb1.phone, tb1.reply, tb1.type, tb1.info, tb1.address, tb1.created_at, tb1.userid_replied, tb1.replied_at, tb2.fullname as admin',
			'table' => $this->data['module'].' as tb1',
			'where'  => ['tb1.id' => $id, 'tb1.deleted_at' => 0],
			'join' => [
				[
					'user as tb2',  'tb1.userid_replied = tb2.id AND tb2.deleted_at = 0 AND tb2.publish = 1', 'left'
				]
			],
		]);
		if(!isset($this->data['contact']) || is_array($this->data['contact']) == false || count($this->data['contact']) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/contact/contact/index');
		}

		if($this->request->getMethod() == 'post'){
			$reply = $this->request->getPost('reply');
			$flag = $this->AutoloadModel->_update([
				'table' => 'contact',
				'data' => [
					'reply' => $reply,
					'userid_replied' => $this->auth['id']
				],
				'where' => ['id' => $id]
			]);
			$session->setFlashdata('message-success', 'Phản hồi thành công');
			return redirect()->to(BASE_URL.'backend/contact/contact/index');
		}

		$this->data['template'] = 'backend/contact/contact/reply';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	private function validation(){

		$validate = [


			'replycontent' => 'required',
		];
		$errorValidate = [
			'replycontent' => [
				'required' => 'Bạn chưa nhập nội dung trả lời!',
			],

		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function condition_where(){
		$where = [];
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}
		$daterange = $this->request->getGet('daterange');
		if(isset($daterange) && $daterange != ''){
			$date_explode = explode('-', $daterange);
			$where['tb1.created_at <='] = date('Y-m-d 23:59:59', strtotime(trim($date_explode[1])));
			$where['tb1.created_at >='] = date('Y-m-d 00:00:00', strtotime(trim($date_explode[0])));
		}
		$type = $this->request->getGet('type');
		if(isset($type) && $type != '0'){
			$where['tb1.type'] = $type;
		}
		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb1.fullname LIKE \'%'.$keyword.'%\' OR tb1.email LIKE \'%'.$keyword.'%\' OR tb1.phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($objectid = 0, $param = []){
		helper(['text']);
		$store = [
 			'content' => $this->request->getPost('replycontent'),
 			'objectid' => $objectid,
 			'deleted_at' => 0,
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

}
