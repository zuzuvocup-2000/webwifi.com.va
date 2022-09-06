<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AutoloadModel;

class Login implements FilterInterface
{
	protected $auth;
	protected $user;
	protected $AutoloadModel;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
        $this->auth = (isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '';
        helper(['mystring']);
	}

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->auth = json_decode($this->auth, TRUE);
        if(isset($this->auth) && is_array($this->auth) && count($this->auth)){
            return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}