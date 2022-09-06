<?php

namespace App\Controllers\Backend\Member\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}

	// meta_title là 1 row -> seo_meta_title
	// contact_address
	// chưa có thì insert
	// có thì update
	public function index(){
		$data =  array(
			'' => '-- Chọn kiểu dữ liếu --',
            'chucvu' => 'Chức vụ',
            'donvi' => 'Đơn vị',
		);

		return $data;
	}
}
