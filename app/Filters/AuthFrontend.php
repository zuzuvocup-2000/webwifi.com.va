<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AutoloadModel;

class AuthFrontend implements FilterInterface
{
	protected $AutoloadModel;
    protected $auth;
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
        $this->auth = (isset($_COOKIE[AUTH.'member'])) ? $_COOKIE[AUTH.'member'] : '';
        helper(['mystring']);
	}
    public function before(RequestInterface $request, $arguments = null)
    {   

        if(!isset($this->auth) || empty($this->auth)) {
            return redirect()->to(BASE_URL);
        }
        $this->auth = json_decode($this->auth, TRUE);
        $where = [
            'email' => $this->auth['email']
        ];
        if(isset($this->auth['id_social']) && !empty($this->auth['id_social'])){
            $where = [
                'id_social' => $this->auth['id_social'],
                'social' => $this->auth['social'],
            ];
        }
        $user = $this->AutoloadModel->_get_where([
            'select' =>'id, email, phone, address',
            'table' => 'member',
            'where' => $where
        ]);
        if(!isset($user) || is_array($user) == false || count($user) == 0){
            unset($_COOKIE[AUTH.'member']); 
            setcookie(AUTH.'member', null, -1, '/'); 
            return redirect()->to(BASE_URL);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}