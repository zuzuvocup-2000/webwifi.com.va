<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AutoloadModel;

class Auth implements FilterInterface
{
	protected $AutoloadModel;
    protected $auth;
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
        $this->auth = (isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '';
        helper(['mystring']);
	}
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!isset($this->auth) || empty($this->auth)) {
            return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
        }
        $this->auth = json_decode($this->auth, TRUE);

        $user = $this->AutoloadModel->_get_where([
            'select' =>'id, email, phone, address',
            'table' => 'user',
            'where' => ['email' => $this->auth['email']]
        ]);
        if(!isset($user) || is_array($user) == false || count($user) == 0){
            unset($_COOKIE[AUTH.'backend']); 
            setcookie(AUTH.'backend', null, -1, '/'); 
            return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}