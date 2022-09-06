<?php
namespace App\Controllers\Frontend\Contact;
use App\Controllers\FrontendController;

class Contact extends FrontendController{

	protected $data;

	public function __construct(){
        $this->data = [];
        $this->data['module'] = 'article_catalogue';
        $this->data['language'] = $this->currentLanguage();
	}

	public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);

        $this->data['meta_title'] = 'Liên hệ';
        $this->data['meta_description'] = 'Thông tin liên hệ';
        $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = 'lien-he'.HTSUFFIX;
        }

        if($this->request->getMethod() == 'post'){
            $validate = $this->validation();
            if ($this->validate($validate['validate'], $validate['errorValidate'])){
                $store = [
                    'email' => $this->request->getPost('email'),
                    'fullname' => $this->request->getPost('fullname'),
                    'phone' => $this->request->getPost('phone'),
                    'address' => $this->request->getPost('address'),
                    'content' => $this->request->getPost('message'),
                    'title' => 'Gửi thông tin liên hệ',
                    'contactid' => $this->contact_id_generator(),
                    'deleted_at' => 0,
                    'created_at' => $this->currentTime
                ];
                $insert = $this->AutoloadModel->_insert([
                    'table' => 'contact',
                    'data' => $store
                ]);

                if($insert > 0){
                    $session->setFlashdata('message-success', 'Gửi thông tin liên hệ Thành Công!');
                    header('location:'.BASE_URL.'lien-he'.HTSUFFIX);die();
                }else{
                    $session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
                    header('location:'.BASE_URL.'lien-he'.HTSUFFIX);die();
                }
            }else{
                $this->data['validate'] = $this->validator->listErrors();
            }
        }

        $this->data['template'] = 'frontend/contact/contact/index';
        $this->data['general'] = $this->general;
        return view('frontend/homepage/layout/home', $this->data);
	}

    public function datlich($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $this->data['meta_title'] = 'Đặt lịch tư vấn';
        $this->data['meta_description'] = 'Đặt lịch tư vấn';
        $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = 'lien-he'.HTSUFFIX;
        }

        if($this->request->getMethod() == 'post'){
            $validate = $this->validation();
            if ($this->validate($validate['validate'], $validate['errorValidate'])){
                $store = [
                    'email' => $this->request->getPost('email'),
                    'fullname' => $this->request->getPost('fullname'),
                    'phone' => $this->request->getPost('phone'),
                    'address' => $this->request->getPost('address'),
                    'info' => json_encode($this->request->getPost('info')),
                    'content' => 'Khách hàng đã gửi tờ khai y tế vui lòng click để xem chi tiết',
                    'title' => 'Gửi tờ khai y tế',
                    'contactid' => $this->contact_id_generator(),
                    'deleted_at' => 0,
                    'created_at' => $this->currentTime
                ];
                $insert = $this->AutoloadModel->_insert([
                    'table' => 'contact',
                    'data' => $store
                ]);

                if($insert > 0){
                    $session->setFlashdata('message-success', 'Đặt lịch tư vấn Thành Công!');
                    header('location:'.BASE_URL.'dat-lich-tu-van'.HTSUFFIX);die();
                }else{
                    $session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
                    header('location:'.BASE_URL.'dat-lich-tu-van'.HTSUFFIX);die();
                }
            }else{
                $this->data['validate'] = $this->validator->listErrors();
            }
        }

        $this->data['template'] = 'frontend/contact/contact/datlich';
        $this->data['general'] = $this->general;
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function contact_id_generator(){
        $order = $this->AutoloadModel->_get_where([
            'select' => 'id',
            'table' => 'contact',
            'order_by' => 'id desc'
        ]);
        $lastId = 0;
        if(!isset($order) || is_array($order) == false || count($order) == 0){
            $lastId = 1;
        }else{
            $lastId = $order['id']+1;
        }
        $orderId = 'CT_'.str_pad($lastId, 6, '0', STR_PAD_LEFT);
        return $orderId;
    }

    private function validation(){
        $validate = [
            'fullname' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];
        $errorValidate = [
            'fullname' => [
                'required' => 'Bạn phải nhập vào trường họ và tên'
            ],
            'phone' => [
                'required' => 'Bạn phải nhập vào trường số điện thoại',
            ],
            'address' => [
                'required' => 'Bạn phải nhập vào trường địa chỉ',
            ],
        ];
        return [
            'validate' => $validate,
            'errorValidate' => $errorValidate,
        ];
    }

}
