<?php

namespace App\Controllers\Backend\Contact\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}
	public function select(){
		$type =  array(
			0 => '-- Chọn loại liên hệ --',
            'email' => 'Liên hệ nhận tin qua Email',
            'all' => 'Liên hệ nhận tin qua Email hoặc số điện thoại',
            'phone' => 'Liên hệ nhận tin qua Số điện thoại',
            'ticket' => 'Thông tin phản hồi',
            'support' => 'Hỗ trợ báo giá',
            'baogia' => 'Báo giá',
		);
		$text =  array(
            'email' => '[email] đã đăng ký nhận tin! Mong hệ thống phản hồi sớm nhất có thể!',
            'all' => '[fullname] đã đăng ký nhận tin! Mong hệ thống phản hồi sớm nhất có thể!',
            'phone' => '[phone] đã đăng ký nhận tin! Mong hệ thống phản hồi sớm nhất có thể!',
            'ticket' => '[fullname] đã gửi phản hồi về Website của bạn, xin vui lòng trả lời sớm nhất có thể!',
            'support' => '[fullname] đã gửi hỗ trợ nhờ admin tư vấn báo giá, xin vui lòng trả lời sớm nhất có thể!',
            'baogia' => '[fullname] đã gửi báo giá về Sản phẩm, xin vui lòng trả lời sớm nhất có thể!',
		);
		return [
			'type' => $type,
			'text' => $text
		];
	}
}
