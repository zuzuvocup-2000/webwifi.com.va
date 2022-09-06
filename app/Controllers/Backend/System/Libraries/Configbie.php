<?php

namespace App\Controllers\Backend\System\Libraries;
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
				'banner_hd' => array('type' => 'images', 'label' => 'Banner Header'),
				'logo' => array('type' => 'images', 'label' => 'Logo'),
				'logo_ft' => array('type' => 'images', 'label' => 'Logo Chân trang'),
				// 'pickup' => array('type' => 'textarea', 'label' => 'Nội dung pickup'),
				'ft' => array('type' => 'textarea', 'label' => 'Text chân trang'),
				// 'copyright' => array('type' => 'text', 'label' => 'copyright'),
				// 'copyright_link' => array('type' => 'text', 'label' => 'copyright_link'),
				'favicon' => array('type' => 'images', 'label' => 'Favicon','title' => 'Favicon là gì?','link' => 'https://webchuanseoht.com/favicon-la-gi-tac-dung-cua-favicon-nhu-the-nao.html'),
				// 'time' => array('type' => 'editor', 'label' => 'Open time'),
				// 'book' => array('type' => 'text', 'label' => 'Tiêu đề nút book'),
				// 'book_link' => array('type' => 'text', 'label' => 'Link nút book'),
			),
		);
		$data['contact'] =  array(
			'label' => 'Thông tin liên lạc',
			'description' => 'Cấu hình đầy đủ thông tin liên hệ giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
			'value' => array(
				// 'address_detail' => array('type' => 'text', 'label' => 'Địa chỉ chi tiết'),
				'address' => array('type' => 'text', 'label' => 'Địa chỉ '),
				'hotline' => array('type' => 'text', 'label' => 'Hotline'),
				'phone_mb' => array('type' => 'text', 'label' => 'Hotline Miền Bắc'),
				'phone_mn' => array('type' => 'text', 'label' => 'Hotline Miền Nam'),
				'bct' => array('type' => 'text', 'label' => 'Link bộ công thương'),
				// 'phone' => array('type' => 'text', 'label' => 'Sale'),
				'email' => array('type' => 'text', 'label' => 'Email'),
				'website' => array('type' => 'text', 'label' => 'Website'),
				'map' => array('type' => 'textarea', 'label' => 'Bản đồ','title' => 'Hướng dẫn thiết lập bản đồ','link' => 'https://webchuanseoht.com/huong-dan-thiet-lap-ban-do-google-map.html'),
				'map_link' => array('type' => 'text', 'label' => 'Link Bản đồ'),
				// 'image' => array('type' => 'images', 'label' => 'Ảnh liên hệ trang chủ'),
			),
		);
		// $data['banner'] =  array(
		// 	'label' => 'Cấu hình khác',
		// 	'description' => 'Một số cấu hình được thêm vào tại đây',
		// 	'value' => array(
		// 		'header' => array('type' => 'images', 'label' => 'Banner đầu Header'),
		// 		'footer' => array('type' => 'images', 'label' => 'Banner chân trang'),
		// 		'news' => array('type' => 'images', 'label' => 'Banner tin tức'),
		// 	),
		// );
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
		$data['social'] =  array(
			'label' => 'Mạng xã hội',
			'description' => 'Cập nhật đầy đủ thông tin mạng xã hội giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
			'value' => array(
				'facebook' => array('type' => 'text', 'label' => 'Fanpage Facebook'),
				'google' => array('type' => 'text', 'label' => 'Google Plus'),
				'youtube' => array('type' => 'text', 'label' => 'Youtube'),
				'twitter' => array('type' => 'text', 'label' => 'Twitter'),
				'link' => array('type' => 'text', 'label' => 'Linkedin'),
				'insta' => array('type' => 'text', 'label' => 'Instagram'),
				'skype' => array('type' => 'text', 'label' => 'Skype'),
				'telegram' => array('type' => 'text', 'label' => 'Telegram ( Username - not Phone )'),
				// 'zalo' => array('type' => 'text', 'label' => 'Zalo'),
				'whatsapp' => array('type' => 'text', 'label' => 'Whatsapp'),
				'pinterest' => array('type' => 'text', 'label' => 'Pinterest'),
				'tiktok' => array('type' => 'text', 'label' => 'Tiktok'),
			),
		);
		// $data['payment'] =  array(
		// 	'label' => 'Cấu hình Thanh Toán Qua Apotapay',
		// 	'description' => 'Cập nhật đầy đủ thông tin mạng xã hội giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
		// 	'value' => array(
		// 		'partner_code' => array('type' => 'text', 'label' => 'Partner Id'),
		// 		'api_key' => array('type' => 'text', 'label' => 'Api key'),
		// 		'secret_key' => array('type' => 'text', 'label' => 'Secret key'),
		// 		'url_payment' => array('type' => 'text', 'label' => 'Đường dẫn thanh toán'),
		// 	),
		// );
		$data['website'] =  array(
			'label' => 'Cấu hình website',
			'description' => 'Cài đặt đầy đủ Cấu hình của website. Trạng thái website, index google, ...',
			'value' => array(
				'status' => array('type' => 'select2', 'label' => 'Trạng thái website','select' => array(0 => 'Mở cửa Website', 1 => 'Đóng cửa website')),
				'index' => array('type' => 'select2', 'label' => 'Index Google','select' => array(1 => 'Có', 0 => 'Không')),
				'canonical' => array('type' => 'select2', 'label' => 'Đường dẫn','select' => array('normal' => 'Normal', 'silo' => 'Silo')),
				'language' => array('type' => 'select', 'label' => 'Ngôn ngữ mặc định','select' => array('vi' => 'Tiếng Việt', 'en' => 'Tiếng Anh')),
			),
		);

		return $data;
	}

	public function canonical_system(){
		$data['general'] =  array(
			'label' => 'Đường dẫn hệ thống',
			'description' => 'Đường dẫn mặc định của tất cả trang trên website',
			'value' => array(
				'css' => array('type' => 'textarea', 'label' => 'CSS mặc định'),
				'script_top' => array('type' => 'textarea', 'label' => 'JS mặc định - phần Header'),
				'script_bottom' => array('type' => 'textarea', 'label' => 'JS mặc định - phần cuối Body'),
			),
		);
		$data['normal'] =  array(
			'label' => 'File mặc định nếu không tồn tại module',
			'description' => 'Cấu hình đầy đủ thông tin đường dẫn giúp lập trình viên dễ dàng kiểm soát file css và file script một cách hiệu quả. Để cho trang web có thể chạy mượt mà nhất có thể :D',
			'value' => array(
				'css' => array('type' => 'textarea', 'label' => 'CSS'),
				'script' => array('type' => 'textarea', 'label' => 'Javascript'),
			),
		);
		
		$data['article'] =  array(
			'label' => 'Đường dẫn cho Bài viết',
			'description' => 'Cấu hình đầy đủ thông tin đường dẫn giúp lập trình viên dễ dàng kiểm soát file css và file script một cách hiệu quả. Để cho trang web có thể chạy mượt mà nhất có thể :D',
			'value' => array(
				'css' => array('type' => 'textarea', 'label' => 'CSS'),
				'script' => array('type' => 'textarea', 'label' => 'Javascript'),
			),
		);
		$data['product'] =  array(
			'label' => 'Đường dẫn cho Sản phẩm',
			'description' => 'Cấu hình đầy đủ thông tin đường dẫn giúp lập trình viên dễ dàng kiểm soát file css và file script một cách hiệu quả. Để cho trang web có thể chạy mượt mà nhất có thể :D',
			'value' => array(
				'css' => array('type' => 'textarea', 'label' => 'CSS'),
				'script' => array('type' => 'textarea', 'label' => 'Javascript'),
			),
		);

		return $data;
	}
}
