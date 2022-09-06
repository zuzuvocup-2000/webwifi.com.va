<?php 
namespace App\Libraries;
use App\Models\AutoloadModel;

class Authentication{

	public $auth;
	protected $AutoloadModel;

	public function __construct(){
		$this->auth = ((isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '');
		$this->AutoloadModel = new AutoloadModel();
	}

	public function check_auth(){
 		return json_decode($this->auth, TRUE);
	}

	public function check_permission(array $param = []){
		$session = session();
		$this->auth = json_decode($this->auth, TRUE);
		if($this->auth == ''){
 			return false;
		}
		$user = $this->AutoloadModel->_get_where([
			'select' => 'tb2.permission',
			'table' => 'user as tb1',
			'join' => [
				['user_catalogue as tb2', 'tb1.catalogueid = tb2.id', 'inner']
			],
			'where' => ['tb1.id' => $this->auth['id']]
		]);

		$permission = json_decode($user['permission'], TRUE);
		if(in_array($param['routes'], $permission) == false){
			return false;
		}
		return true;

	}

}