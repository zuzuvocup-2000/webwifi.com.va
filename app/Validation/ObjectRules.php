<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class ObjectRules {

	protected $AutoloadModel;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	public function check_canonical(string $canonical = '', string $module = ''): bool{
		$originalCanonical = $this->request->getPost('original_canonical');
		$modulExtract = explode('_', $module);
		$dem = 0;
		if($originalCanonical != $canonical){
			$dem = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => 'router',
				'where' => ['canonical' => $canonical],
				'count' => TRUE
			]);
		}
		if( $dem > 0){
			return false;
		}
		return true;
 	}

 	public function check_voucherid(string $voucherid = '', string $module = ''): bool{
		
		$originalId = $this->request->getPost('voucherid_original');
		$modulExtract = explode('_', $module);
		$count = 0;
		if($originalId != $voucherid){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $modulExtract[0],
				'where' => ['voucherid' => $voucherid],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}

 	public function check_promotionid(string $promotionid = '', string $module = ''): bool{
		
		$originalId = $this->request->getPost('promotionid_original');
		$modulExtract = explode('_', $module);
		$count = 0;
		if($originalId != $promotionid){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $modulExtract[0],
				'where' => ['promotionid' => $promotionid],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}

 	public function check_router(string $canonical = ''): bool{
		$originalCanonical = $this->request->getPost('original_canonical');
		$count = 0;
		$dem = 0;
		if($originalCanonical != $canonical){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => 'router',
				'where' => [
					'canonical' => $canonical
				],
				'count' => TRUE
			]);
			if($count == 0){
				$dem = $this->AutoloadModel->_get_where([
					'select' => 'objectid',
					'table' => 'router',
					'where' => ['canonical' => $canonical],
					'count' => TRUE
				]);
			}
		}
		if($count > 0 || $dem > 0){
			return false;
		}
		return true;
 	}

 	public function check_id(string $productid = '', string $module = ''): bool{
		if($module == 'tour'){
			$originalId = $this->request->getPost('tourid');
		}else{
			$originalId = $this->request->getPost('productid');
		}
		$modulExtract = explode('_', $module);
		$count = 0;
		if($originalId != $productid){
			if($module == 'tour'){
				$count = $this->AutoloadModel->_get_where([
					'select' => 'objectid',
					'table' => $modulExtract[0],
					'where' => ['tourid' => $productid],
					'count' => TRUE
				]);
			}else{
				$count = $this->AutoloadModel->_get_where([
					'select' => 'objectid',
					'table' => $modulExtract[0].'_translate',
					'where' => ['productid' => $productid],
					'count' => TRUE
				]);

			}
		}
		if($count > 0){
			return false;
		}
		return true;
 	}

 	public function check_widget(string $keyword = ''): bool{
		
		$originalId = $this->request->getPost('keyword');
		$count = 0;
		if($originalId != $keyword){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => 'website_widget' ,
				'where' => ['keyword' => $keyword],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}

 	public function is_no_0(string $keyword = ''): bool{
		if($keyword == '0'){
			return false;
		}
		return true;
 	}

 	public function check_keyword_translate(string $keyword = '', $module = ''): bool{
		$modulExtract = explode('_', $module);
		$originalId = $this->request->getPost('keyword_original');
		$count = 0;
		if($originalId != $keyword){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $modulExtract[0].'_translate' ,
				'where' => ['keyword' => $keyword,'module' => $module],
				'count' => TRUE
			]);
		}
		if($count > 0 ){
			return false;
		}
		return true;
 	}

 	public function check_keyword(string $keyword = '', $module = ''): bool{
		
		$originalId = $this->request->getPost('keyword_original');
		$count = 0;
		if($originalId != $keyword){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $module ,
				'where' => ['keyword' => $keyword],
				'count' => TRUE
			]);
		}
		if($count > 0){
			return false;
		}
		return true;
 	}


}

