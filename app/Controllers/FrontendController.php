<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AutoloadModel;
use App\Libraries\Pagination;
use App\Libraries\Mobile_Detect;

class FrontendController extends Controller
{

	protected $helpers = ['mystring','mydatafrontend','renderdata','myurl','form','mypanel','mydata','url','myauthentication','mypagination'];
	public $currentTime;
	public $AutoloadModel;
	public $client;
	protected $pagination;
	public $general;
	public $detect_type;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->AutoloadModel = new AutoloadModel();
		$this->pagination = new Pagination();
		$this->currentTime =  gmdate('Y-m-d H:i:s', time() + 7*3600);

		helper($this->helpers);
		$this->request = \Config\Services::request();
		$this->general = get_general($this->currentLanguage());

		// $detect = $this->request->getGet('detect');
		
		// if(isset($detect) && !empty($detect)){
		// 	if(in_array($detect, array('tablet', 'mobile', 'desktop'))){
		// 		setcookie('fc_device', $detect, time() + 30*24*3600, '/');
		// 		$this->detect_type = $detect;
		// 	}
		// 	else{
		// 		setcookie('fc_device', 'desktop', time() + 30*24*3600, '/');
		// 		$this->detect_type = 'desktop';
		// 	}
		// }
		// else{
		// 	if(!isset($_COOKIE['fc_device']) || empty($_COOKIE['fc_device'])){
		// 		$detect = new Mobile_Detect;
		// 		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
		// 		setcookie('fc_device', $deviceType, time() + 30*24*3600, '/');
		// 		$this->detect_type = $deviceType;
		// 	}
		// 	else{
		// 		setcookie('fc_device', $_COOKIE['fc_device'], time() + 30*24*3600, '/');
		// 		$this->detect_type = $_COOKIE['fc_device'];
		// 	}
		// }
	}

	public function currentLanguage(){
		$language = (isset($this->general['website_language']) ? $this->general['website_language'] : 'vi');
		if(!isset($_COOKIE['language']) || $_COOKIE['language'] == ''){
			setcookie('language', $language , time() + 1*24*3600, "/");
		}else{
			$language = $_COOKIE['language'];
		}
		return $language;
	}
}
