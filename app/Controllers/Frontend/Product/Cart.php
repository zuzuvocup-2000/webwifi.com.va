<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;
use App\Libraries\AppotaPay;

class Cart extends FrontendController{
	public $cartbie;
	public $cart;

    public function __construct(){
        $this->data['language'] = $this->currentLanguage();
		$this->cart = \Config\Services::cart();
    }
    public function index(){
		$session = session();
		$this->data['cart'] = $this->get_cart_detail($this->cart->contents());
		$this->data['cartTotal'] = $this->cart->total();
		$this->member = $this->get_member_info();
		$this->data['member'] = $this->member;
        $this->data['general'] = $this->general;
		$this->data['voucher'] = [];
		if(isset($_COOKIE['voucher']) && $_COOKIE['voucher'] != ''){
			$this->data['voucher'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, price, voucherid, max, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid AND bill.member_id = \''.$this->member['id'].'\') as count_member',
				'table' => 'voucher',
				'where' => [
					'voucherid' => $_COOKIE['voucher'],
					'deleted_at' => 0,
					'publish' => 1,
					'max >' => 'count_bill',
				]
			]);
			if(isset($this->data['voucher']['count_member']) && $this->data['voucher']['count_member'] > 0){
				$this->data['voucher'] = [];
			}else{
				$this->data['cartTotal'] = $this->data['cartTotal'] - $this->data['voucher']['price'];
			}
		}
    	if($this->request->getMethod() == 'post'){
    		$setData = (isset($_COOKIE['data_cart']) ? json_decode($_COOKIE['data_cart'],true) : []);
    		if(isset($setData) && is_array($setData) && count($setData)){
    			$setData['cityid'] = $this->request->getPost('cityid');
    			$setData['districtid'] = $this->request->getPost('districtid');
    		}else{
	    		$setData = [
	    			'cityid' => $this->request->getPost('cityid'),
	    			'districtid' => $this->request->getPost('districtid')
	    		];
    		}
			setcookie('data_cart', json_encode($setData), time() + 30*24*3600, "/");
			header('location: '.BASE_URL.'dat-hang');die();
        }

        return view('frontend/product/cart/index', $this->data);
    }

    public function pay(){
		$session = session();
		$this->data['cart'] = $this->get_cart_detail($this->cart->contents());
		$this->data['cartTotal'] = $this->cart->total();
		$this->member = $this->get_member_info();
		$this->data['member'] = $this->member;
        $this->data['general'] = $this->general;
		$this->data['voucher'] = [];
		if(isset($_COOKIE['voucher']) && $_COOKIE['voucher'] != ''){
			$this->data['voucher'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, price, voucherid, max, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid AND bill.member_id = \''.$this->member['id'].'\') as count_member',
				'table' => 'voucher',
				'where' => [
					'voucherid' => $_COOKIE['voucher'],
					'deleted_at' => 0,
					'publish' => 1,
					'max >' => 'count_bill',
				]
			]);
			if(isset($this->data['voucher']['count_member']) && $this->data['voucher']['count_member'] > 0){
				$this->data['voucher'] = [];
			}else{
				$this->data['cartTotal'] = $this->data['cartTotal'] - $this->data['voucher']['price'];
			}
		}
    	if($this->request->getMethod() == 'post'){
			$store = $this->store($this->data['voucher']);
			$cart = $this->cart->contents();

			if(isset($store) && is_array($store) && count($store)){
				$bill_id = $this->bill_id_generator();
				$store['bill_id'] = $bill_id;
				$resultid = $this->AutoloadModel->_insert([
					'table' => 'bill',
					'data' => $store
				]);
				if($resultid > 0){
					$flag = $this->create_bill_detail($resultid, $cart);
					if($flag > 0){
						$token = base64_encode($resultid);
						// $this->send_mail($this->data['cart'], $store, $bill_id);
						$this->cart->destroy();
						header('location: '.BASE_URL.'dat-hang-thanh-cong?token='.$token);die();
					}
				}
			}
        }

        return view('frontend/product/cart/pay', $this->data);
    }

	public function method(){
		$id = (int)base64_decode($this->request->getGet('token'));
		$this->data['orderDetail'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.fullname, tb1.email, tb1.bill_id',
			'table' => 'bill as tb1',
			'where' => [
				'tb1.id' => $id,
			]
		]);


		$this->data['general'] = $this->general;
		$this->data['meta_title'] = $this->general['homepage_company'].' Đặt hàng Thành Công';
		$this->data['meta_description'] = $this->general['homepage_company'].' Đặt hàng Thành Công';
		return view('frontend/product/cart/method', $this->data);
    }

    private function get_member_info(){
		$memberCookie = (isset($_COOKIE['HTVIETNAM_member'])) ? $_COOKIE['HTVIETNAM_member'] : '';
		$memberCookie = json_decode($memberCookie, TRUE);
		$member = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, email, phone, cityid, districtid, address, wardid',
			'table' => 'member',
			'where' => [
				'id' => $memberCookie['id'],
				'deleted_at' => 0,
				'publish' => 1
			]
		]);
		return $member;
	}

	private function payment_online($param = [], $cart = []){
		$case = 'apota';
		switch ($case) {
		  	case "apota":
		    	$this->apota_pay($param, $cart);
		    	break;
		  	default:
		    	$this->apota_pay($param, $cart);
		}
	}

	private function apota_pay($param = [], $cart = []){
		$path = substr(APPPATH, 0, -4);
		$config = [
		    'partner_code' => $this->general['payment_partner_code'],
		    'api_key' => $this->general['payment_api_key'],
		    'secret_key' => $this->general['payment_secret_key'],
		];
		$appotaPay = new AppotaPay($config);
		$orderDetails = [
		    'order_id' => $param['bill_id'],
		    'order_info' => 'Thanh toán đơn hàng mã: '.$param['bill_id'].' Ghi Chú: '.$param['messages'],
		    'amount' => $this->cart->total(),
		];
		$paymentDetails = [
		    'bank_code' => '',
		    'method' => 'CC',
		    'client_ip' => $_SERVER['REMOTE_ADDR'],
		];
		$paymentUrl = $appotaPay->makeBankPayment($orderDetails, $paymentDetails);
		redirect($paymentUrl);
	}


	private function create_bill_detail($bill_id = 0, $cart = []){
		$insert = [];
		$row = 0;
		if(isset($cart) && is_array($cart) && count($cart)){
			foreach($cart as $key => $val){
				$option = [];
				if(isset($val['comboid'])){
					$option = [
						'type' => $val['type'],
						'comboid' => $val['comboid'],
						'value' => $val['combo_price'],
					];
				}
				$insert[] = [
					'bill_id' => $bill_id,
					'product_id' => str_replace('SKU_', '', $val['id']),
					'name' => $val['name'],
					'subtotal' => $val['subtotal'],
					'quantity' => $val['qty'],
					'price' => $val['price'],
					'type' => (isset($val['comboid']) ? 'combo' : ''),
					'option' => json_encode((isset($option)) ? $option : '')
				];
			}
		}

		if(isset($insert) && is_array($insert) && count($insert)){
			$row = $this->AutoloadModel->_create_batch([
				'table' => 'bill_detail',
				'data' => $insert,
			]);
		}
		return $row;
	}
	private function send_mail($cart = [], $info = [], $bill_id = ''){
		helper(['mymail']);
		$html = '';
		if(isset($cart) && is_array($cart) && count($cart)){
			foreach($cart as $key => $val){
				$image = BASE_URL.$val['detail']['image'];
				$title = $val['detail']['title'];
				$price = $val['price'];
				$price_promotion = $val['detail']['price_promotion'];
				$main_price = $val['detail']['price'];
				$quantity = $val['qty'];
				$subtotal = $val['subtotal'];
				if($main_price < 0) $main_price = 0;
				$html = $html.'<tr>
					<td style="padding:5px 9px">
					<img style="width:40px ; height: 40px" src="'.$image.'"></td>
					<td style=" padding:5px 9px">'.$title.'</td>
					<td style="text-align:right ; padding:5px 9px">'.number_format((int)$main_price,0,',','.').' đ</td>
					<td style="text-align:center ; padding:5px 9px">'.$quantity.'</td>
					<td style="text-align:right ; padding:5px 9px">'.number_format((int)$main_price - (int)$price_promotion).' đ</td>
					<td style="text-align:right ; padding:5px 9px">'.number_format($subtotal).' đ</td>
				</tr>';
			}
		}
		$mailbie = new Mailbie();
		$mailFlag = $mailbie->send([
		   'to' => $info['email'],
		   'subject' => 'Xác nhận đặt hàng thành công tại hệ thống website: '.$this->general['contact_website'],
		   'messages' => mail_html(array(
			   'header' => 'Thông tin đặt hàng',
			   'fullname' => $info['fullname'],
			   'email' => $info['email'],
			   'p_phone' => $info['phone'],
			   'address' => $info['address'],
			   'total_price' => $this->cart->total(),
			   'payment_code' => $bill_id,
			   'payment_created' => $info['created_at'],
			   'fee' =>'-',
			   'product' => $html,
			   'web' => $this->general['contact_website'],
			   'hotline' => $this->general['contact_hotline'],
			   'phone' => $this->general['contact_hotline'],
			   'logo' => base_url($this->general['homepage_logo']),
			   'brandname' => $this->general['contact_website'],
			   'system_email' => $this->general['contact_email'],
			   'system_address' => $this->general['contact_address'],
		   ))
	   	]);
	 	return $mailFlag;
	}
	private function store($voucher = []){
		$total = $this->cart->total();
		$price_voucher= (isset($voucher['price']) ? $voucher['price'] :0);
		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.price',
			'table' => 'price as tb1',
			'where' => [
				'tb1.cityid' => $this->request->getPost('cityid'),
				'tb1.districtid' => $this->request->getPost('districtid'),
			]
		]);
		$price_ship = 0;
		if(isset($object['price'])) $price_ship = $object['price'];
		$total = (($total - $price_voucher) > 0  ? $total - $price_voucher : 0);
		$total = $total + $price_ship;
		$store = [
			'fullname' => $this->request->getPost('name'),
			'phone' => $this->request->getPost('phone'),
			'email' => $this->request->getPost('email'),
			'cityid' => $this->request->getPost('cityid'),
			'districtid' => $this->request->getPost('districtid'),
			'address' => $this->request->getPost('address'),
			'messages' => $this->request->getPost('note'),
			'method' => $this->request->getPost('payment_method'),
			'quantity' => $this->cart->totalItems(),
			'total' => $total,
			'status' => 'pending',
			'created_at' => $this->currentTime,
		];
		return $store;
	}

	private function get_cart_detail($cart = []){
		$id = [];
		$productInCart = [];
		if(isset($cart) && is_array($cart) && count($cart)){
			foreach($cart as $key => $val){
				if(isset($val['comboid'])){
					$objectid =  str_replace(strtoupper($val['type']).'_'.$val['comboid'].'_', '', $val['id']);
				}else{
					$objectid =  str_replace('SKU_', '', $val['id']);
				}
				$id[] = $objectid;
			}
			$id= array_values(array_unique($id));
		}
		if(isset($id) && is_array($id) && count($id)){
			$productInCart = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.title, tb1.image, tb2.canonical, tb1.price, tb1.price_promotion',
				'table' => 'product as tb1',
				'join' => [
					['product_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module ="product" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner']
				],
				'where' => [
					'tb1.publish' => 1, 'tb1.deleted_at' => 0,'tb2.module' => 'product'
				],
				'where_in' => $id,
				'where_in_field' => 'tb1.id'
			], TRUE);
		}

		$cartRemake = $this->cart_remake($cart, $productInCart);

		return $cartRemake;
	}

	private function cart_remake($cart = [], $productInCart = []){
		if(isset($cart) && is_array($cart) && count($cart)){
			foreach($cart as $key => $val){
				if(isset($val['comboid'])){
					$objectid =  str_replace(strtoupper($val['type']).'_'.$val['comboid'].'_', '', $val['id']);
				}else{
					$objectid =  str_replace('SKU_', '', $val['id']);
				}
				if(isset($productInCart) && is_array($productInCart) && count($productInCart)){
					foreach($productInCart as $keyItem => $valItem){
						if($objectid == $valItem['id']){
							$cart[$key]['detail'] = $valItem;
						}
					}
				}
			}
		}
		return $cart;
	}

	private function bill_id_generator(){
		$order = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => 'bill',
			'order_by' => 'id desc'
		]);
		$lastId = 0;
		if(!isset($order) || is_array($order) == false || count($order) == 0){
			$lastId = 1;
		}else{
			$lastId = $order['id']+1;
		}
	 	$orderId = 'ORDER_'.str_pad($lastId, 6, '0', STR_PAD_LEFT);
		return $orderId;
	}

}
