<?php
namespace App\Controllers\Frontend\Tour;
use App\Controllers\FrontendController;

class Tour extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'tour';
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $keyword = $this->condition_keyword();
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title, tb2.meta_title, tb2.sub_title,tb2.video, tb2.sub_content, tb1.tourid, tb2.meta_description, tb2.day_start,tb2.number_days,tb2.info, tb2.description, tb2.content, tb3.title as start, tb4.title as end',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'tour_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "tour" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    'location_translate as tb3','tb2.start_at = tb3.objectid AND tb3.module="location" AND tb3.language=\''.$this->currentLanguage().'\' AND tb3.attribute = "start"','inner'
                ],
                [
                    'location_translate as tb4','tb2.end_at = tb4.objectid AND tb4.module="location" AND tb4.language=\''.$this->currentLanguage().'\'AND tb4.attribute = "end"','inner'
                ]
            ],
        ]);
        // if(isset($this->data['object']) && is_array($this->data['object']) && count($this->data['object'])){
        //     $session->setFlashdata('message-danger', 'Bài viết không tồn tại!');
        //     return redirect()->to(BASE_URL);
        // }
        $this->data['sub_album'] = $this->rewrite_album($this->data['object']);
        $this->data['object'] = $this->convert_data($this->data['object']);

        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [   
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $this->data['object']['catalogueid']
            ]
        ]);

        // if(isset($this->data['detailCatalogue']) && is_array($this->data['detailCatalogue']) && count($this->data['detailCatalogue'])){
        //     $session->setFlashdata('message-danger', 'Bài viết không tồn tại!');
        //     return redirect()->to(BASE_URL);
        // }
        $this->data['breadcrumb'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [   
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.lft <=' => $this->data['detailCatalogue']['lft'], 
                'tb1.rgt >=' => $this->data['detailCatalogue']['rgt'], 
            ],
            'order_by' => 'tb1.lft asc'
        ], TRUE);

        $cookie = $this->set_cookie($id, $this->data['object']);

        $this->data['meta_title'] = (!empty( $this->data['object']['meta_title']) ? $this->data['object']['meta_title']: $this->data['object']['title']);
        $this->data['meta_description'] = (!empty( $this->data['object']['meta_description'])? $this->data['object']['meta_description']:cutnchar(strip_tags( $this->data['object']['description']), 300));
        $this->data['meta_image'] = !empty( $this->data['object']['image'])?base_url( $this->data['object']['image']):((isset($this->data['object']['album'][0])) ? $this->data['object']['album'][0] : '');

        $config['base_url'] = write_url($this->data['object']['canonical'], FALSE, TRUE);
        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }

        $this->data['rate'] = $this->data_rate([
            'canonical' => $this->data['object']['canonical'],
            'module' => $this->data['module']
        ]);
        // prE($this->data['rate']);

        $this->data['general'] = $this->general;
        if(in_array($this->detect_type, array('tablet', 'mobile'))){
            $this->data['template'] = 'mobile/tour/tour/index';
            return view('mobile/homepage/layout/home', $this->data);
        }else{
            $this->data['template'] = 'frontend/tour/tour/index';
            return view('frontend/homepage/layout/home', $this->data);
        }
    }

    private function data_rate($param = []){
        $full = $this->AutoloadModel->_get_where([
            'select' => 'fullname, comment, rate, created_at, phone, email, id, created_at, publish, url, module, image, album',
            'table' => 'comment',
            'where' => [
                'deleted_at' => 0,
                'module' => $param['module'],
                'url' => $param['canonical'],
                'parentid' => 0
            ],
            'order_by' => 'created_at asc'
        ], TRUE);
        $calculator = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        ];
        $rate = [];
        if(isset($full) && is_array($full) && count($full)){
            foreach ($full as $key => $value) {
                $full[$key]['comment'] = base64_decode($value['comment']);
                foreach ($calculator as $keyCal => $valueCal) {
                    if($value['rate'] == $keyCal && $value['publish'] == 1){
                        $calculator[$keyCal] = $calculator[$keyCal] + 1;
                    }
                }
            }
            foreach ($full as $key => $value) {
               if($value['publish'] == 1){
                    array_push($rate, $value);
                }
            }
        }
        $sum_star = 0;
        $sum_comment = 0;
        foreach ($calculator as $key => $value) {
            $sum_star = $sum_star + ($key * $value);
            $sum_comment = $sum_comment + $value;
        }
        if($sum_comment == 0){
        	$result['total'] = 0;
        }else{
        	$result['total'] = round($sum_star/$sum_comment,1);
        }
        $result['sum'] = $sum_comment;
        $result['all_comment'] = $full;
        $result['comment_publish_1'] = $rate;
        $result['calculator'] = $calculator;
        return $result;
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }

    private function set_cookie($id = 0, $param = []){
        $idList = [];
        if(!isset($_COOKIE['COUNT_'.$this->data['module']]) || empty($_COOKIE['COUNT_'.$this->data['module']])){
            array_push($idList, $id);
            setcookie('COUNT_'.$this->data['module'], json_encode($idList), time() + 1*24*3600, "/");
            $cookie = $this->AutoloadModel->_update([
                'table' => $this->data['module'],
                'where' => [
                    'id' => $id,
                    'deleted_at' => 0,
                    'publish' => 1
                ],
                'data' => [
                    'viewed' => $param['viewed'] + 1 
                ]
            ]);
        }else{
            $getCookie = $this->request->getCookie('COUNT_'.$this->data['module']);
            $getCookie = json_decode($getCookie);
            $count = 0;
            foreach ($getCookie as $key => $value) {
                if($id == $value){
                    $count++;
                }
            }
            if($count == 0){
                array_push($getCookie, $id);
                setcookie('COUNT_'.$this->data['module'], json_encode($getCookie), time() + 1*24*3600, "/");
                $cookie = $this->AutoloadModel->_update([
                    'table' => $this->data['module'],
                    'where' => [
                        'id' => $id,
                        'deleted_at' => 0,
                        'publish' => 1
                    ],
                    'data' => [
                        'viewed' => $param['viewed'] + 1 
                    ]
                ]);
            }
        }
        return true;
    }

    private function rewrite_album($param = []){
        $sub_album = json_decode($param['sub_album'],TRUE);
        $sub_album_title = json_decode($param['sub_album_title'],TRUE);
        $album = [];
        if(isset($sub_album) && is_array($sub_album) && count($sub_album)){
            foreach ($sub_album as $key => $value) {
                foreach ($sub_album_title as $keyTitle => $valTitle) {
                    if($key == $keyTitle){
                        $album[$key]['title'] = $valTitle;
                        $album[$key]['album'] = $value;
                    }
                }
            }
            
        }
        return $album;
    }

    private function convert_data($param = []){
        if(isset($param['album']) && $param['album'] != ''){
            $param['album'] = json_decode($param['album']);
        }
        if(isset($param['info']) && $param['info'] != ''){
            $param['info'] = json_decode($param['info'], TRUE);
        }
        if(isset($param['description']) && $param['description'] != ''){
            $param['description'] = validate_input(base64_decode($param['description']));
        }
        if(isset($param['content']) && $param['content'] != ''){
            $param['content'] = validate_input(base64_decode($param['content']));
        }
        if(isset($param['sub_content']) && $param['sub_content'] != ''){
            $param['sub_content'] = json_decode(base64_decode($param['sub_content']));
        }
        if(isset($param['sub_title']) && $param['sub_title'] != ''){
            $param['sub_title'] = json_decode(base64_decode($param['sub_title']));
        }
        if(isset($param['price']) && $param['price'] != ''){
            $param['price'] = number_format($param['price'],0,',','.');
        }
        if(isset($param['price_promotion']) && $param['price_promotion'] != ''){
            $param['price_promotion'] = number_format($param['price_promotion'],0,',','.');
        }
        
        return $param;
    }

    public function condition_catalogue($catalogueid = 0){
        $id = [];   
        $module_extract = explode("_", $this->data['module']);
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $module_extract[0].'_catalogue as tb1',
                'join' =>  [
                    [
                        'tour_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "tour"','inner'
                    ],
                ],
                'where' => ['tb1.id' => $catalogueid],
            ]);

            $catalogueChildren = $this->AutoloadModel->_get_where([
                'select' => 'id',
                'table' => $module_extract[0].'_catalogue',
                'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
            ], TRUE);

            $id = array_column($catalogueChildren, 'id');
        }
        return [
            'where_in' => $id,
            'where_in_field' => 'tb2.catalogueid'
        ];

    }
}
