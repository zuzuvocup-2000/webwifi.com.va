<?php 
namespace App\Controllers\Backend\Price;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Price extends BaseController{
	protected $data;
	public $nestedsetbie;
	
	
	public function __construct(){
		$this->data = [];
		helper(['mypagination','mydatafrontend']);
		$this->data['module'] = 'price';
		$this->data['module2'] = 'price_catalogue';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/price/price/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$this->data['type'] = $this->AutoloadModel->_get_where([
			'select' => '*',
			'table' => 'price_catalogue',
			'where' => [
				'name' => 'type',
				'status' => 1,
			],
		]);


		if(isset($this->data['type']) && is_array($this->data['type']) && count($this->data['type'])){
			if($this->data['type']['value'] == 'auto'){
				$price = $this->AutoloadModel->_get_where([
					'select' => '*',
					'table' => 'price_catalogue',
					'where_in' => ['apikey','secretkey'],
					'where_in_field' => 'name',
				],true);
				$this->data['price'] = [];
				if(isset($price) && is_array($price)&&count($price)){
					foreach ($price as $value) {
					    $this->data['price'][$value['name']] = $value['value'];
					}
				}

			}else{
				$page = (int)$page;
				$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
				$keyword = $this->condition_keyword();
				$config['total_rows'] = $this->AutoloadModel->_get_where([
					'select' => 'tb1.id, tb1.price , tb2.name as city, tb3.name as district',
					'table' => 'price as tb1',
					'join' => [
						[
							'vn_province as tb2' , 'tb2.provinceid = tb1.cityid', 'inner'
						],
						[
							'vn_district as tb3' , 'tb3.provinceid = tb1.cityid AND tb3.districtid = tb1.districtid', 'inner'
						],
					],
					'keyword' => $keyword,
					'count' => true
				]);
				if($config['total_rows'] > 0){
					$config = pagination_config_bt(['url' => 'backend/price/price/index','perpage' => $perpage], $config);
					$this->pagination->initialize($config);
					$this->data['pagination'] = $this->pagination->create_links();


					$totalPage = ceil($config['total_rows']/$config['per_page']);
					$page = ($page <= 0)?1:$page;
					$page = ($page > $totalPage)?$totalPage:$page;
					$page = $page - 1;
					$this->data['priceList'] = $this->AutoloadModel->_get_where([
						'select' => 'tb1.id, tb1.price , tb2.name as city, tb3.name as district',
						'table' => 'price as tb1',
						'keyword' => $keyword,
						'join' => [
							[
								'vn_province as tb2' , 'tb2.provinceid = tb1.cityid', 'inner'
							],
							[
								'vn_district as tb3' , 'tb3.provinceid = tb1.cityid AND tb3.districtid = tb1.districtid', 'inner'
							],
						],
						'limit' => $config['per_page'],
						'start' => $page * $config['per_page'],
						'order_by' => 'tb2.name asc, tb3.name asc'
					],true);
				}
			}
		}
		$this->data['template'] = 'backend/price/price/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb3.name LIKE \'%'.$keyword.'%\' OR tb2.name LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}
}	
