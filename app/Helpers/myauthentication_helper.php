<?php 
use App\Models\AutoloadModel;

if (! function_exists('authentication')){
	function authentication(){
		$model = new AutoloadModel();
	 	$auth = (isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '';
	 	$auth = json_decode($auth, TRUE);
	 	$user = $model->_get_where([
	       	'select' => 'tb1.id, tb1.email, tb1.phone, tb1.address,tb1.image,tb1.fullname,tb1.catalogueid,tb2.title as job, tb2.permission',
	       	'table' => 'user as tb1',
	       	'join' => [
	       		[
	       			'user_catalogue as tb2', 'tb1.catalogueid = tb2.id', 'inner'
	       		]
	       	],
	       	'where' => ['email' => $auth['email']]
   		]);
	 	return $user;
	}
}

?>

