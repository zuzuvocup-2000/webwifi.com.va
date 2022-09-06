<?php
namespace App\Controllers\Frontend\Tour;
use App\Controllers\FrontendController;
use App\Libraries\Cartbie;

class Cart extends FrontendController{
	public $cartbie;
    public function __construct(){
        $this->cartbie = new Cartbie();
    }
    public function index(){
    	$this->data['cart'] = $this->cartbie->get();
        if(isset($_COOKIE['custome_info']) || !empty($_COOKIE['custome_info'])){
            $this->data['customer'] = $this->request->getCookie('custome_info');
            $this->data['customer'] = json_decode(base64_decode($this->data['customer']), true);
        }
        // pre($this->data['customer']);
    	if($this->request->getMethod() == 'post'){
            $store = [
                'fullname' => $this->request->getPost('fullname'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'cityid' => $this->request->getPost('cityid'),
                'districtid' => $this->request->getPost('districtid'),
                'address' => $this->request->getPost('address'),
                'message' => $this->request->getPost('message'),
            ];
            $cookie  = base64_encode(json_encode($store));
            setcookie('custome_info',  $cookie, time() + 1*24*3600, "/");
            return redirect()->to(BASE_URL.'phuong-thuc-thanh-toan'.HTSUFFIX);
        }

        $this->data['general'] = $this->general;
        // if(in_array($this->detect_type, array('tablet', 'mobile'))){
        //     $this->data['template'] = 'mobile/tour/cart/index';
        //     return view('mobile/homepage/layout/home', $this->data);
        // }else{
            return view('frontend/tour/cart/index', $this->data);
        // }
    }

    public function method(){
        $session = session();
        $this->data['cart'] = $this->cartbie->get();
        if(!isset($_COOKIE['custome_info']) || empty($_COOKIE['custome_info'])){
            $session->setFlashdata('message-danger', 'Chưa có thông tin khách hàng!');
            return redirect()->to(BASE_URL.'gio-hang'.HTSUFFIX);
        }

        $this->data['customer'] = $this->request->getCookie('custome_info');
        $this->data['customer'] = json_decode(base64_decode($this->data['customer']), true);
        $this->data['general'] = $this->general;
         if(in_array($this->detect_type, array('tablet', 'mobile'))){
            $this->data['template'] = 'mobile/tour/cart/method';
            return view('mobile/homepage/layout/home', $this->data);
        }else{
            $this->data['template'] = 'frontend/tour/cart/method';
            return view('frontend/homepage/layout/home', $this->data);
        }
    }
}
