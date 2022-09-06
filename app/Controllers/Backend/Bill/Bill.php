<?php
namespace App\Controllers\Backend\Bill;
use App\Controllers\BaseController;

class Bill extends BaseController{
	protected $data;


	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'bill';

	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/bill/bill/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 10;
		$keyword = $this->condition_keyword();
		$where = $this->condition_where();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'bill_detail as tb2','tb1.id = tb2.bill_id','inner'
				]
			],
			'keyword' => $keyword,
			'where' => $where,
			'group_by' => 'tb1.id',
			'order_by' => 'tb1.id desc',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/bill/bill/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['billList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.address, tb1.fullname, tb1.phone, tb1.email, tb1.total, tb1.created_at, tb1.quantity, tb1.method, tb1.status, tb1.messages, tb1.bill_id',
				'table' => $this->data['module'].' as tb1',
				'join' => [
					[
						'bill_detail as tb2','tb1.id = tb2.bill_id','inner'
					]
				],
				'where' => $where,
				'keyword' => $keyword,
				'group_by' => 'tb1.id',
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by' => 'tb1.id desc'
			],true);
		}
		$this->data['template'] = 'backend/bill/bill/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function detail($id = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/bill/bill/detail'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$this->data['bill'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.address, tb1.fullname, tb1.phone, tb1.email, tb1.total, tb1.created_at, tb1.quantity, tb1.method, tb1.status, tb1.messages, tb2.name as city, tb3.name as district',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'vn_province as tb2','tb1.cityid = tb2.provinceid','inner'
				],
				[
					'vn_district as tb3','tb1.districtid = tb3.districtid AND tb3.provinceid = tb1.cityid','inner'
				],
			],
			'where' => [
				'tb1.id' => $id
			]
		]);

		$this->data['billDetail'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.product_id, tb1.name, tb1.price, tb1.quantity, tb1.subtotal, tb1.option, tb2.image, tb2.productid',
			'table' => 'bill_detail as tb1',
			'join' => [
				[
					'product as tb2','tb1.product_id = tb2.id','inner'
				]
			],
			'where' => [
				'tb1.bill_id' => $id
			]
		],true);

		$this->data['template'] = 'backend/bill/bill/detail';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');	
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\'  )';
		}
		return $keyword;
	}

	private function condition_where(){
		$where = [];
		$status = $this->request->getGet('status');
		if(isset($status) && $status != 'root'){
			$where['tb1.status'] = $status;
		}
		$daterange = $this->request->getGet('daterange');
		if(isset($daterange) && $daterange != ''){
			$date_explode = explode('-', $daterange);
			$where['tb1.created_at <='] = date('Y-m-d 23:59:59', strtotime(trim($date_explode[1])));
			$where['tb1.created_at >='] = date('Y-m-d 00:00:00', strtotime(trim($date_explode[0])));
		}
		return $where;
	}

}
