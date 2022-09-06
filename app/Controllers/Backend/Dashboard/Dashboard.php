<?php 
namespace App\Controllers\Backend\Dashboard;
use App\Controllers\BaseController;

class Dashboard extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function get_time_simple(){
		$time = $this->request->getPost('time');

		$time = date('Y-m-d H:i:s', strtotime($time));
		echo $time ;die();
	}
	public function index( $page = 0){
		
		$this->data['cycle'] = month_number_ago(5);
		$timeGetData = [];
		if(isset($this->data['cycle']) && is_array($this->data['cycle']) && count($this->data['cycle'])){
			foreach ($this->data['cycle'] as $key => $value) {
				$count = 0;
				foreach ($this->data['cycle'] as $key => $value) {
					if($key == 0){
						$timeGetData['start'] = $this->data['cycle'][$key]['start'];
					}
					if($count + 1 == count($this->data['cycle'])){
						$timeGetData['end'] = $this->data['cycle'][$key]['end'];
					}
					$count++;
				}
			}
		}
		$this->data['memberList'] = $this->memberList($timeGetData, $this->data['cycle']);
		$this->data['billList'] = $this->billList($timeGetData, $this->data['cycle']);
		$this->data['userList'] = $this->user_list();


		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 10;
		$keyword = $this->condition_keyword();
		$where = $this->condition_where();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id',
			'table' => 'bill as tb1',
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
			$config = pagination_config_bt(['url' => 'backend/dashboard/dashboard/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['billListDetail'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.address, tb1.fullname, tb1.phone, tb1.email, tb1.total, tb1.created_at, tb1.quantity, tb1.method, tb1.status, tb1.messages, tb1.bill_id',
				'table' => 'bill as tb1',
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


		$this->data['template'] = 'backend/dashboard/home/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function user_list(){
		$userList = $this->AutoloadModel->_get_where([
			'select' => 'tb1.fullname, tb2.title, tb1.image, tb1.id',
			'table' => 'user as tb1',
			'where' => [
				'tb1.deleted_at' => 0,
				'tb1.publish' => 1
			],
			'join' => [
				[
					'user_catalogue as tb2','tb1.catalogueid = tb2.id AND tb2.deleted_at = 0 AND tb2.publish = 1','inner'
				]
			],
			'order_by' => 'tb1.catalogueid asc'
		], TRUE);
		return $userList;
	}

	public function memberList($time = [], $cycle = []){
		$data = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, created_at',
			'table' => 'member',
			'where' => [
				'deleted_at' => 0,
				'publish' => 1,
				'created_at >=' => $time['start'],
				'created_at <=' => $time['end'],
			],
		],true);
		$resut = [];
		foreach ($cycle as $key => $value) {
			$result[$key] = 0;
			foreach ($data as $keyChild => $valueChild) {
				if($valueChild['created_at'] >= $value['start'] && $valueChild['created_at'] <= $value['end'])
				$result[$key] = $result[$key] + 1;
			}
		}

		$member_day =  $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, created_at',
			'table' => 'member',
			'where' => [
				'created_at <=' => date('Y-m-d 23:59:59', strtotime($this->currentTime)),
				'created_at >=' => date('Y-m-d 00:00:00', strtotime($this->currentTime)),
			],
			'count' => true
		]);
		$member_sum =  $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, created_at',
			'table' => 'member',
			'count' => true
		]);
		return [
			'member' => $result,
			'member_day' => $member_day,
			'member_sum' => $member_sum
		];
	}

	public function billList($time = [], $cycle = []){
		$data = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, ,total, created_at',
			'table' => 'bill',
			'where' => [
				'created_at >=' => $time['start'],
				'created_at <=' => $time['end'],
			],
		],true);
		$resut = [];
		foreach ($cycle as $key => $value) {
			$result[$key] = 0;
			foreach ($data as $keyChild => $valueChild) {
				if($valueChild['created_at'] >= $value['start'] && $valueChild['created_at'] <= $value['end'])
				$result[$key] = $result[$key] + 1;
			}
		}

		foreach ($cycle as $key => $value) {
			$total[$key] = 0;
			foreach ($data as $keyChild => $valueChild) {
				if($valueChild['created_at'] >= $value['start'] && $valueChild['created_at'] <= $value['end'])
				$total[$key] = $total[$key] + $valueChild['total'];
			}
		}

		$bill_day =  $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, total, created_at',
			'table' => 'bill',
			'where' => [
				'created_at <=' => date('Y-m-d 23:59:59', strtotime($this->currentTime)),
				'created_at >=' => date('Y-m-d 00:00:00', strtotime($this->currentTime)),
			],
			'count' => true
		]);
		$bill_sum =  $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, total, created_at',
			'table' => 'bill',
			'count' => true
		]);

		return [
			'bill' => $result,
			'total' => $total,
			'bill_day' => $bill_day,
			'bill_sum' => $bill_sum
		];
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
