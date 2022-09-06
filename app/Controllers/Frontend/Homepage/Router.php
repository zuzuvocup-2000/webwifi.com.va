<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;

class Router extends FrontendController{

	public $data = [];
    public function silo($segment_1 = '', $segment_2 = ''){
        $canonical = $segment_1.'/'.$segment_2;
        $this->index($canonical);
    }

    public function list($page = 0){
        $page = (int)$page;
        $router = '\App\Controllers\Frontend\Product\ListProduct::index';
        return view_cell($router, 'page='.$page.'');
    }

    public function login(){
        $router = '\App\Controllers\Frontend\Homepage\Auth::login';
        return view_cell($router);
    }
    public function signup(){
        $router = '\App\Controllers\Frontend\Homepage\Auth::signup';
        return view_cell($router);
    }

    public function forgot(){
        $router = '\App\Controllers\Frontend\Homepage\Auth::forgot';
        return view_cell($router);
    }

    public function logout(){
        $router = '\App\Controllers\Frontend\Homepage\Auth::logout';
        return view_cell($router);
    }

    public function search($page = 1, $module = ''){
        $page = (int)$page;
        $router = '\App\Controllers\Frontend\Search\Search::index';
        return view_cell($router, 'page='.$page.', module='.$module.'');
    }


	public function index($canonical = '', $page = 1){
        $count = $this->AutoloadModel->_get_where([
            'select' => '*',
            'table' => 'router',
            'where' => ['canonical' => $canonical],
            'count' => TRUE
        ]);
        if($count > 0){
            $router = $this->AutoloadModel->_get_where([
                'select' => '*',
                'table' => 'router',
                'where' => ['canonical' => $canonical],
            ]);
            if(isset($router) && is_array($router) && count($router)){
                return view_cell($router['view'], 'id='.$router['objectid'].', page='.$page.'');
            }
        }else{
            return redirect()->to('notfound');
        }
	}
}
