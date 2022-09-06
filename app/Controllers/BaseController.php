<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\AutoloadModel;
use App\Libraries\Authentication;
use App\Libraries\Pagination;
use App\Libraries\Mobile_Detect;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form','url','myauthentication','mystring','mydata','nestedtset', 'myurl', 'myinsert','mypagination'];
	public $currentTime;
	public $AutoloadModel;
	public $request;
	protected $pagination;
	public $authentication;
	public $defaulLanguage;
	public $currentLanguage;
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->AutoloadModel = new AutoloadModel();
		$this->authentication = new Authentication();
		$this->pagination = new Pagination();
		// E.g.:
		// $this->session = \Config\Services::session();
		// $this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();

		//
		$this->currentTime =  gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->auth = $this->authentication->check_auth();
		$this->currentLanguage = $this->AutoloadModel->_get_where([
			'select' => 'canonical',
			'table' => 'language',
			'where' => ['default' => 1]
		]);

		helper($this->helpers);
	}

	public function currentLanguage(){
		$language = 'vi';
		if(!isset($_COOKIE['BACKEND_language']) || $_COOKIE['BACKEND_language'] == ''){
			setcookie('BACKEND_language', $language , time() + 1*24*3600, "/");
		}else{
			$language = $_COOKIE['BACKEND_language'];
		}
		return $language;
	}


}
