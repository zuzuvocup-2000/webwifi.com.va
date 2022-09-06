<?php

namespace App\Controllers\Backend\Widget\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}

	// meta_title là 1 row -> seo_meta_title
	// contact_address
	// chưa có thì insert
	// có thì update
	public function system(){
		$data['homepage'] =  array(
			'label' => 'Thông tin chung',
			'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu website. Logo của website và icon website trên tab trình duyệt',
			'value' => array(
				'company' => array('type' => 'text', 'label' => 'Tên công ty'),
				'brand' => array('type' => 'text', 'label' => 'Tên thương hiệu'),
				'slogan' => array('type' => 'text', 'label' => 'Slogan'),
				'logo' => array('type' => 'images', 'label' => 'Logo'),
				'logo_footer' => array('type' => 'images', 'label' => 'Logo Chân trang'),
				'favicon' => array('type' => 'images', 'label' => 'Favicon','title' => 'Favicon là gì?','link' => 'https://webchuanseoht.com/favicon-la-gi-tac-dung-cua-favicon-nhu-the-nao.html'),
			),
		);
		$data['homepage_1'] =  array(
			'label' => 'Thông tin chung 1',
			'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu website. Logo của website và icon website trên tab trình duyệt',
			'value' => array(
				'company' => array('type' => 'text', 'label' => 'Tên công ty'),
				'company_1' => array('type' => 'images', 'label' => 'Tên công ty 1'),
				'company_2' => array('type' => 'textarea', 'label' => 'Tên công ty 2'),
				'company_3' => array('type' => 'editor', 'label' => 'Tên công ty 3'),
				'brand' => array('type' => 'text', 'label' => 'Tên thương hiệu'),
				'slogan' => array('type' => 'text', 'label' => 'Slogan'),
				'logo' => array('type' => 'images', 'label' => 'Logo'),
				'logo_footer' => array('type' => 'images', 'label' => 'Logo Chân trang'),
				'favicon' => array('type' => 'images', 'label' => 'Favicon','title' => 'Favicon là gì?','link' => 'https://webchuanseoht.com/favicon-la-gi-tac-dung-cua-favicon-nhu-the-nao.html'),
			),
		);
		$data['contact'] =  array(
			'label' => 'Thông tin liên lạc',
			'description' => 'Cấu hình đầy đủ thông tin liên hệ giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
			'value' => array(
				'representative' => array('type' => 'text', 'label' => 'Người đại diện'),
				'address' => array('type' => 'text', 'label' => 'Địa chỉ'),
				'phone' => array('type' => 'text', 'label' => 'Điện thoại'),
				'hotline' => array('type' => 'text', 'label' => 'Hotline'),
				'email' => array('type' => 'text', 'label' => 'Email'),
				'website' => array('type' => 'text', 'label' => 'Website'),
				'map' => array('type' => 'textarea', 'label' => 'Bản đồ','title' => 'Hướng dẫn thiết lập bản đồ','link' => 'https://webchuanseoht.com/huong-dan-thiet-lap-ban-do-google-map.html'),
				'bct' => array('type' => 'text', 'label' => 'Link Bộ công thương'),
			),
		);
		$data['another'] =  array(
			'label' => 'Các mục khác',
			'description' => 'Cập nhật đầy đủ thông tin giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
			'value' => array(
				'intro_excerpt' => array('type' => 'editor', 'label' => 'Giới thiệu ngắn'),
				'standard' => array('type' => 'text', 'label' => 'Tiêu chuẩn sản xuất', 'attention' => '* ( Mỗi 1 loại viết cách nhau dấu " | ")'),
				'procedure' => array('type' => 'text', 'label' => 'Quy trình sản xuất' , 'attention' => '* ( Mỗi 1 loại viết cách nhau dấu " | ")'),
			),
		);
		$data['seo'] =  array(
			'label' => 'Cấu hình thẻ tiêu đề',
			'description' => 'Cài đặt đầy đủ Thẻ tiêu đề và thẻ mô tả giúp xác định cửa hàng của bạn xuất hiện trên công cụ tìm kiếm.',
			'value' => array(
				'meta_title' => array('type' => 'text', 'label' => 'Tiêu đề trang','extend' => ' trên 70 kí tự', 'class' => 'meta-title', 'id' => 'titleCount'),
				'meta_description' => array('type' => 'textarea', 'label' => 'Mô tả trang','extend' => ' trên 320 kí tự', 'class' => 'meta-description', 'id' => 'descriptionCount'),
			),
		);
		$data['analytic'] =  array(
			'label' => 'Google Analytics',
			'description' => 'Dán đoạn mã hoặc mã tài khoản GA được cung cấp bởi Google.',
			'value' => array(
				'google_analytic' => array('type' => 'textarea', 'label' => 'Mã Google Analytics','title' => 'Hướng dẫn thiết lập Google Analytic','link' => 'https://webchuanseoht.com/huong-dan-thiet-lap-google-analytics.html'),
			),
		);
		$data['facebook'] =  array(
			'label' => 'Facebook Pixel',
			'description' => 'Facebook Pixel giúp bạn tạo chiến dịch quảng cáo trên facebook để tìm kiếm khách hàng mới mua hàng trên website của bạn.',
			'value' => array(
				'facebook_pixel' => array('type' => 'text', 'label' => 'Facebook Pixel','title' => 'Hướng dẫn thiết lập Facebook Pixel','link' => 'https://webchuanseoht.com/huong-dan-su-dung-pixel-quang-cao-facebook-moi-cap-nhat.html'),
			),
		);
		$data['script'] =  array(
			'label' => 'Mã Nhúng Mở rộng',
			'description' => 'Mã nhúng mở rộng giúp bạn dễ dàng tích hợp các tính năng của nhà cung cấp thứ 3 phát triển vào website.',
			'value' => array(
				'facebook_pixel' => array('type' => 'textarea', 'label' => 'Script'),
			),
		);
		$data['script2'] =  array(
			'label' => 'Mã Nhúng Mở rộng_2',
			'description' => 'Mã nhúng mở rộng giúp bạn dễ dàng tích hợp các tính năng của nhà cung cấp thứ 3 phát triển vào website.',
			'value' => array(
				'facebook_pixel2' => array('type' => 'textarea', 'label' => 'Script'),
			),
		);
		$data['social'] =  array(
			'label' => 'Mạng xã hội',
			'description' => 'Cập nhật đầy đủ thông tin mạng xã hội giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
			'value' => array(
				'facebook' => array('type' => 'text', 'label' => 'Fanpage Facebook'),
				'google' => array('type' => 'text', 'label' => 'Google Plus'),
				'youtube' => array('type' => 'text', 'label' => 'Youtube'),
				'twitter' => array('type' => 'text', 'label' => 'Twitter'),
				'linkedin' => array('type' => 'text', 'label' => 'Linkedin'),
				'pinterest' => array('type' => 'text', 'label' => 'Pinterest'),
				'email' => array('type' => 'text', 'label' => 'Email'),
			),
		);
		$data['website'] =  array(
			'label' => 'Cấu hình website',
			'description' => 'Cài đặt đầy đủ Cấu hình của website. Trạng thái website, index google, ...',
			'value' => array(
				'status' => array('type' => 'select2', 'label' => 'Trạng thái website','select' => array(0 => 'Mở cửa Website', 1 => 'Đóng cửa website')),
				'index' => array('type' => 'select2', 'label' => 'Index Google','select' => array(1 => 'Có', 0 => 'Không')),
				'canonical' => array('type' => 'select2', 'label' => 'Đường dẫn','select' => array('normal' => 'Normal', 'silo' => 'Silo')),
			),
		);

		return $data;
	}
}
