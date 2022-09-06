<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;
use App\Libraries\Mailbie;

class Member extends BaseController{
	
	public function __construct(){
		helper(['mymail','mystring','mydata','text']);
	}

	public function get_discount(){
		$response = [];
		try {
			$param['id'] = $this->request->getPost('id');
			$param['module'] = $this->request->getPost('module');
			$promotion = $this->AutoloadModel->_get_where([
				'select' => 'tb2.title, tb2.image, tb2.promotionid, tb2.type, tb2.discount_value, tb1.used, tb1.used_at',
				'table' => 'promotion_relationship as tb1',
				'join' => [
					[
						'promotion as tb2', 'tb2.id = tb1.promotionid', 'inner'
					],
					[
						'member as tb3', 'tb3.id = tb1.memberid', 'inner'
					],
				],
				'where' => [
					'tb3.publish' => 1,
					'tb3.deleted_at' => 0,
					'tb2.publish' => 1,
					'tb2.deleted_at' => 0,
					'tb1.memberid' => $param['id']
				]
			], true);

	 		if(isset($promotion) && is_array($promotion) && count($promotion)){
	 			$html = '';
	 			foreach ($promotion as $key => $value) {
	 			    $html = $html .'<tr>';
                        $html = $html .'<td class="text-center">'.($key+1).'</td>';
                        $html = $html .'<td>'.$value['title'].'</td>';
                        $html = $html .'<td class="text-center">'.$value['promotionid'].'</td>';
                        $html = $html .'<td class="text-center">'.$value['type'].'</td>';
                        $html = $html .'<td class="text-center">'.$value['discount_value'].'</td>';
                        $html = $html .'<td class="text-center">'.($value['used'] == 0 ? 'Chưa sử dụng' : 'Đã sử dụng').'</td>';
                    $html = $html .'</tr>';
	 			}
		 		$response['message'] = 'Mật khẩu mới đã được gửi vào Email của bạn!';
				$response['code'] = '10';
				$response['html'] = $html;
	 		}elsE{
	 			$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
				$response['code'] = '99';
	 		}

	 	}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();	
	}


	public function reset_pass(){
		$response = [];
		try {
			$id = $this->request->getPost('id');
			$user = $this->AutoloadModel->_get_where([
		 		'select' => 'id, fullname, email, otp, otp_live',
		 		'table' => 'member',
		 		'where' => [
		 			'id' => $id,
		 			'deleted_at' => 0
		 		],
		 	]);

		 	if(!isset($user) || !is_array($user) || count($user) == 0){
		 		$response['message'] = 'Tài khoản không tồn tại!';
				$response['code'] = '99';
		 	}else{
				$salt = random_string('alnum', 168);
		 		$password = random_string('numeric', 6);
		 		$password_encode = password_encode($password, $salt);
		 		$update = [
		 			'password' => $password_encode,
		 			'salt' => $salt,
		 		];

		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'data' => $update,
		 			'where' => ['id' => $user['id']]
		 		]);
		 		if($flag > 0){
		 			$mailbie = new Mailbie();
				 	$mailFlag = $mailbie->send([
			 			'to' => $user['email'],
			 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
			 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url('login.html').'">Click vào đây để tiến hành đăng nhập</a></div>',
			 		]);
			 		$response['message'] = 'Mật khẩu mới đã được gửi vào Email của bạn!';
					$response['code'] = '10';
		 		}elsE{
		 			$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
					$response['code'] = '99';
		 		}
		 	}

	 	}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();	
	}
}
