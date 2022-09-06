<?php
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Cart extends FrontendController{

	public $cart;
	public function __construct(){
		$this->cart = \Config\Services::cart();
	}

	public function get_price_ship(){
		$cityid = $this->request->getPost('cityid');
		$districtid = $this->request->getPost('districtid');

		$object = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.price',
			'table' => 'price as tb1',
			'where' => [
				'tb1.cityid' => $cityid,
				'tb1.districtid' => $districtid,
			]
		]);

		$price = 0;
		if(isset($object) && is_array($object) && count($object)) {
			$price = $object['price'];
		}
		echo json_encode([
			'price' => $price,
			'total' => $this->cart->total() + $price
		]);die();
	}

	public function add_combo(){
		$response = [];
		try {
			$sku = $this->request->getPost('sku');
			$id = $this->request->getPost('id');
			$combo = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.type, tb1.value, tb1.time_end,tb3.canonical, tb2.objectid, tb3.title, tb4.image, tb4.price, tb4.price_promotion',
                'table' => 'combo as tb1',
                'join' => [
                    [
                        'combo_relationship as tb2', 'tb1.id = tb2.comboid AND tb2.module = "product" ','inner'
                    ],
                    [
                        'product_translate as tb3', 'tb2.objectid = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product as tb4', 'tb2.objectid = tb4.id AND tb4.publish = 1 AND tb4.deleted_at = 0 ','inner'
                    ],
                ],
                'group_by' => 'tb2.objectid, tb1.id',
                'order_by' => 'tb1.time_end asc',
                'where_in' => $id,
                'where_in_field' => 'tb1.id',
            ], TRUE);
            $cartData = [];
            if(isset($combo) && is_array($combo) && count($combo)){
            	foreach ($combo as $key => $value) {
            		$price = price($value['price'], $value['price_promotion']);
            		$new_price = $price['finalPrice'];
            		if($value['type'] == 'normal'){
						$new_price = (($price['finalPrice'] > $value['value']) ? ($price['finalPrice'] - $value['value']) : $price['finalPrice']);
					}else if($value['type'] == 'percent'){
						$new_price = (($value['value'] > 0) ? ($price['finalPrice'] - ($price['finalPrice'] * $value['value'] / 100) ) : $price['finalPrice']);
					}
            		$cartData = [
						'id'      		=> strtoupper($value['type']).'_'.$value['id'].'_'.$value['objectid'],
						'qty'     		=> 1,
						'price'   		=> $new_price,
						'name'    		=> $value['title'],
						'combo_price'   => $value['value'],
						'type'	  		=> $value['type'],
						'comboid'	  	=> $value['id'],
					];
					$flag = $this->cart->insert($cartData);

            	}
            }


			$response['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());

		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function insert(){
		$response = [];
		try {
			$sku = $this->request->getPost('sku');
			$qty = $this->request->getPost('qty');
			$objectId = str_replace('SKU_','', $sku);
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.title, tb1.price, tb1.price_promotion',
				'table' => 'product as tb1',
				'join' => [
					['product_translate as tb2', 'tb1.id = tb2.objectid', 'inner']
				],
				'where' => ['tb1.publish' => 1,'tb1.deleted_at' => 0,'tb1.id' => $objectId, 'tb2.module' => 'product']
			]);

			$price = price($object['price'], $object['price_promotion']);
			$option = makeCartOption();
			if(isset($option) && is_array($option) && count($option)){
				$cart['options'] = $option;
			}
			$cartData = [
				'id'      => $sku,
				'qty'     => (int)$qty,
				'price'   => $price['finalPrice'],
				'name'    => $object['title'],
			];


			$flag = $this->cart->insert($cartData);
			$response['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());
			$response['cartTotal'] = number_format($this->cart->total(),0,',','.');
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function change_quantity(){
		$qty = $this->request->getPost('quantity');
		$rowid = $this->request->getPost('code');
		$cart = $this->cart->contents();

		$cartUpdate = array(
		   'rowid'   => $rowid,
		   'qty'     => $qty,
	   );
		$this->cart->update($cartUpdate);

	}

	public function voucher(){
		$voucherid = $this->request->getPost('voucherid');
		$memberCookie = (isset($_COOKIE['HTVIETNAM_member'])) ? json_decode($_COOKIE['HTVIETNAM_member'], TRUE) : '';
		if(isset($memberCookie) && is_array($memberCookie) && count($memberCookie)){
			$member = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, email, phone, cityid, districtid',
				'table' => 'member',
				'where' => [
					'id' => $memberCookie['id'],
				]
			]);

			$voucher = $this->AutoloadModel->_get_where([
				'select' => 'id, title, price, max, voucherid, publish,(SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid AND bill.member_id = \''.$member['id'].'\') as count_member',
				'table' => 'voucher',
				'where' => ['voucherid' => $voucherid,'deleted_at' => 0,'publish' => 1]
			]);
			if(isset($voucher['count_member']) && $voucher['count_member'] > 0){
				echo json_encode([
					'text' => 'Voucher đã được sử dụng',
					'type' => 'error',
					'price' => '0',
					'cartTotal' => $this->cart->total(),
				]);die();
			}
		}else{
			$voucher = $this->AutoloadModel->_get_where([
				'select' => 'id, title, price, max, voucherid, publish,(SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill',
				'table' => 'voucher',
				'where' => ['voucherid' => $voucherid,'deleted_at' => 0,'publish' => 1]
			]);
		}

		if(isset($voucher) && is_array($voucher) && count($voucher)){
			if($voucher['max'] > $voucher['count_bill']){
				setcookie('voucher', $voucher['voucherid'], time() + 1*24*3600, "/");
				echo json_encode([
					'text' => 'Bạn đã sử dụng '.$voucher['title'].' thành công',
					'type' => 'success',
					'price' => $voucher['price'],
					'cartTotal' => $this->cart->total(),
				]);die();
			}else{
				echo json_encode([
					'text' => 'Mã Voucher đã vượt quá số lần sử dụng!',
					'type' => 'error',
					'price' => '0',
					'cartTotal' => $this->cart->total(),
				]);die();
			}
		}else{
			echo json_encode([
				'text' => 'Mã Voucher không tồn tại!Xin vui lòng thử lại!',
				'type' => 'error',
				'price' => '0',
				'cartTotal' => $this->cart->total(),
			]);die();
		}
	}

	public function change_quantity_new(){
		$qty = $this->request->getPost('quantity');
		$rowid = $this->request->getPost('code');
		$type = $this->request->getPost('type');

		if($type == 'plus'){
			$qty++;
		}else{
			$qty--;
		}

		$cartUpdate = array(
		   'rowid'   => $rowid,
		   'qty'     => $qty,
	   );
		$this->cart->update($cartUpdate);
		$cart = $this->cart->contents();
		$price_voucher = check_voucher();
		echo json_encode([
			'totalItems' => count($this->cart->contents()),
			'cartTotal' => (float)$this->cart->total() - $price_voucher,
			'qty' => $qty,
			'price' => number_format($qty * $cart[$rowid]['price'],0,',','.').' đ',
		]);die();
	}

	public function remove(){
		$rowid= $this->request->getPost('code');
		$content = $this->cart->remove($rowid);
		$price_voucher = check_voucher();
		echo json_encode([
			'totalItems' => count($this->cart->contents()),
			'cartTotal' => (float)$this->cart->total() - $price_voucher
		]);
		die();
	}

	

	

	public function remove_combo(){
		$response = [];
		try {
			$param['code']= $this->request->getPost('code');
			$param['comboid']= $this->request->getPost('comboid');
			$param['type']= $this->request->getPost('type');
			$param['value']= $this->request->getPost('value');
			$cart = $this->cart->contents();
			$object = [];
			if(isset($cart) && is_array($cart) && count($cart)){
				foreach ($cart as $key => $value) {
					if(isset($value['comboid']) && $value['comboid'] == $param['comboid']){
				    	$object[] = $value;
					}
				}
			}

			if(isset($object) && is_array($object) && count($object)){
				foreach ($object as $key => $value) {
					$content = $this->cart->remove($value['rowid']);
				}
			}

			$response['message'] = 'Xóa combo thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());

		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function show(){
		$response = [];
		try {
			$cartDetail = $this->get_cart_detail($this->cart->contents());
			$response['html'] = $this->render_cart($cartDetail);
			$response['code'] = '1';
		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
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


	public function render_cart($cart = []){
		$html = '';
		if(isset($cart) && is_array($cart) && count($cart)){
			$html = $html .'<div class="products scrollable list-cart__loadding">';
				foreach ($cart as $key => $value) {
	                $html = $html .'<div class="product product-cart delete-cart-'.$key.'" id="delete-cart-'.$key.'">';
					    $html = $html .'<figure class="product-media">';
					        $html = $html .'<a href="'.$value['detail']['canonical'].HTSUFFIX.'">';
					            $html = $html .'<img src="'.$value['detail']['image'].'" width="80" height="88" alt="'.$value['detail']['title'].'">';
					        $html = $html .'</a>';
					        $html = $html .'<button data-update="'.$key.'" class="cart-remove remove btn btn-link btn-close">';
					            $html = $html .'<i class="d-icon-times"></i><span class="sr-only">Close</span>';
					        $html = $html .'</button>';
					    $html = $html .'</figure>';
					    $html = $html .'<div class="product-detail">';
					        $html = $html .'<a href="'.$value['detail']['canonical'].HTSUFFIX.'">'.$value['detail']['title'].'</a>';
					        $html = $html .'<div class="price-box">';
					            $html = $html .'<span class="product-quantity">'.$value['qty'].'</span>';
					            $html = $html .'<span class="product-price">'.number_format($value['price'],0,',','.').' ₫ </span>';
					        $html = $html .'</div>';
					    $html = $html .'</div>';
					$html = $html .'</div>';
				}
			$html = $html .'</div>';
			$html = $html .'<div class="cart-total cart-total__loadding">';
			    $html = $html .'<label>Thành tiền:</label>';
			    $html = $html .'<span class="cart-price price">'.number_format($this->cart->total(),0,',','.').' ₫</span>';
			$html = $html .'</div>';
			$html = $html .'<div class="cart-action cart-action__loadding">';
			    $html = $html .'<a href="gio-hang'.HTSUFFIX.'" class="btn btn-dark"><span>Đặt hàng</span></a>';
			$html = $html .'</div>';
		}else{
			$html = $html .'<div class="products scrollable list-cart__loadding">';
				$html = $html .'<p style="margin-top: 25px;">Không có sản phẩm nào trong giỏ hàng!</p>';
			$html = $html .'</div>';
		}

		return $html;
	}
}
