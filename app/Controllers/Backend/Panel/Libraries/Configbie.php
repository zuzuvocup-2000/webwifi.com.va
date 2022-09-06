<?php

namespace App\Controllers\Backend\Panel\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}
	public function panel(){
		$data['locate'] =  array(
			0 => '-- Chọn vị trí Panel --',
            // 'home' => 'Trang chủ',
            'footer' => 'Chân trang',
            // 'article' => 'Bài viết',
            // 'aside_home' => 'Aside trang chủ',
            // 'aside_art' => 'Aside bài viết',
            // 'product' => 'Sản phẩm',
		);
		$data['dropdown'] =  array(
			0 => '-- Chọn danh mục --',
            // 'product' => 'Sản phẩm',
            // 'product_catalogue' => 'Danh mục Sản phẩm',
            'article' => 'Bài viết',
            'article_catalogue' => 'Danh mục Bài viết',
            // 'media' => 'Dự án',
            // 'media_catalogue' => 'Danh mục Dự án',
		);

		return $data;
	}
}
