<?php 
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Filter extends FrontendController{
    public function __construct(){
        
    }
    public function listtour($page = 1){
        helper(['mypagination']);
        $param['cat'] = $this->request->getPost('cat');
        $param['cat_tour'] = $this->request->getPost('cat_tour');
        $param['start'] = $this->request->getPost('start');
        $param['end'] = $this->request->getPost('end');
        $param['module'] = $this->request->getPost('module');
        $param['page'] = $this->request->getPost('page');
        $param['url'] = $this->request->getPost('url');
        $explode = explode('_', $param['module']);
        $importSQL = $this->listtour_create_query($param);
        $where = [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
        ];
        if(isset($param['cat_tour']) && $param['cat_tour'] != 0){
            $abc = [
                'tb1.catalogueid' => $param['cat_tour']
            ];
            $where = $where+$abc;
        }
        $flag  = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
            'table' => $explode[0].' as tb1',
            'join' => $importSQL['join'],
            'where' => $where,
            'query' => $importSQL['query'],
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);

        $html = '';
        $page = (int)$param['page'];
        $config['base_url'] = $param['url'];
        $config['base_url'] = str_replace('.html', '', $config['base_url']);
        $config['per_page'] = 10;
        $config['total_rows'] = count($flag);
        if(count($flag) > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $config['per_page']], $config, $page);
            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;
            $flag  = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image, tb1.album ,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
                'table' => $explode[0].' as tb1',
                'join' => $importSQL['join'],
                'where' => $where,
                'query' => $importSQL['query'],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'group_by' => 'tb1.id',
                'order_by' => 'tb1.catalogueid asc'
            ],TRUE);
            if(isset($flag) && is_array($flag) && count($flag)){
                foreach ($flag as $key => $value) {
                    $flag[$key]['description'] = base64_decode($value['description']);
                    $flag[$key]['content'] = base64_decode($value['content']);
                }
            }
            $count = 1;
           if(isset($flag) && is_array($flag) && count($flag)){
                foreach ($flag as $key => $value) {
                    $html =$html.'<tr>';
                        $html =$html.'<td>';
                            $html =$html.'<div class="text-center">'.$count.'</div>';
                        $html =$html.'</td>';
                        $html =$html.'<td><strong class="fs14"><a href="'.BASE_URL.$value['canonical'].HTSUFFIX.'" target="_blank" title="'.$value['title'].'">'.$value['title'].'</a></strong><span class="i-hot"><img src="https://luhanhvietnam.com.vn/tour-du-lich/modules/tour/images/hot-icon.gif" alt="Hot" class="i-hot"></span></td>';
                        $html =$html.'<td nowrap="">'.$value['number_days'].'</td>';
                        $html =$html.'<td nowrap="">'.number_format(check_isset($value['price']),0,',','.').'  đ</td>';
                        $html =$html.'<td>'.$value['day_start'].'</td>';
                    $html =$html.'</tr>';
                    $count++;
                }
            }else{
                $html = $html.'<tr>';
                    $html = $html.'<td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>';
                $html = $html.'</tr>';
            }
            $html = $html.'<div id="pagination_ajax" class="va-num-page pagination_ajax">';
            $html = $html.'</div>';
            return json_encode([
                'html' => base64_encode($html),
                'pagination' => (isset($pagination) ? $pagination : '')
            ]);die();
        }
       
    }
    public function listtourmobile($page = 1){
        helper(['mypagination']);
        $param['cat'] = $this->request->getPost('cat');
        $param['cat_tour'] = $this->request->getPost('cat_tour');
        $param['start'] = $this->request->getPost('start');
        $param['end'] = $this->request->getPost('end');
        $param['module'] = $this->request->getPost('module');
        $param['page'] = $this->request->getPost('page');
        $param['url'] = $this->request->getPost('url');
        $explode = explode('_', $param['module']);
        $importSQL = $this->listtour_create_query($param);
        $where = [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
        ];
        if(isset($param['cat_tour']) && $param['cat_tour'] != 0){
            $abc = [
                'tb1.catalogueid' => $param['cat_tour']
            ];
            $where = $where+$abc;
        }
        $flag  = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
            'table' => $explode[0].' as tb1',
            'join' => $importSQL['join'],
            'where' => $where,
            'query' => $importSQL['query'],
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);

        $html = '';
        $page = (int)$param['page'];
        $config['base_url'] = $param['url'];
        $config['base_url'] = str_replace('.html', '', $config['base_url']);
        $config['per_page'] = 10;
        $config['total_rows'] = count($flag);
        if(count($flag) > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $config['per_page']], $config, $page);
            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;
            $flag  = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image, tb1.album ,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
                'table' => $explode[0].' as tb1',
                'join' => $importSQL['join'],
                'where' => $where,
                'query' => $importSQL['query'],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'group_by' => 'tb1.id',
                'order_by' => 'tb1.catalogueid asc'
            ],TRUE);
            if(isset($flag) && is_array($flag) && count($flag)){
                foreach ($flag as $key => $value) {
                    $flag[$key]['description'] = base64_decode($value['description']);
                    $flag[$key]['content'] = base64_decode($value['content']);
                }
            }
            $count = 1;
           if(isset($flag) && is_array($flag) && count($flag)){
                foreach ($flag as $key => $value) {
                    $html =$html.'<tr>';
                        $html =$html.'<td>';
                            $html =$html.'<div class="text-center">'.$count.'</div>';
                        $html =$html.'</td>';
                        $html =$html.'<td><strong class="fs14"><a href="'.BASE_URL.$value['canonical'].HTSUFFIX.'" target="_blank" title="'.$value['title'].'">'.$value['title'].'</a></strong><span class="i-hot"><img src="https://luhanhvietnam.com.vn/tour-du-lich/modules/tour/images/hot-icon.gif" alt="Hot" class="i-hot"></span><div class="list_item">Thời gian: '.$value['number_days'].'</div><div class="list_item"> Ngày đi: '.$value['day_start'].'</div><div class="list_item">Giá tour: '.number_format(check_isset($value['price']),0,',','.').'  đ</div></td>';
                    $html =$html.'</tr>';
                    $count++;
                }
            }else{
                $html = $html.'<tr>';
                    $html = $html.'<td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>';
                $html = $html.'</tr>';
            }
            $html = $html.'<div id="pagination_ajax" class="va-num-page pagination_ajax">';
            $html = $html.'</div>';
            return json_encode([
                'html' => base64_encode($html),
                'pagination' => (isset($pagination) ? $pagination : '')
            ]);die();
        }
       
    }
    
    private function listtour_create_query($param = []){
        $find = [];
        $explode = explode('_', $param['module']);
        $querySQL = $this->listtour_find_by_location($param);
        $join = $this->listtour_query_join($querySQL, $explode[0]);

        return [
            'query' => $querySQL,
            'join' => $join
        ];
    }
    private function listtour_find_by_location($param = []){
        $explode = explode('_', $param['module']);
        $query_1 = '';
        $query_2 = '';
        $query_3 = '';
        if($param['cat'] != 0){
            $query_1 = '(location_relationship.catalogueid = \''.$param['cat'].'\' AND location_relationship.attribute = "end" AND location_relationship.module ="location_catalogue")';
        }
        if($param['start'] != 0){
            $query_2 = '(tb2.start_at = \''.$param['start'].'\' )';
        }
        if($param['end'] != 0){
            $query_3 = '(tb2.end_at = \''.$param['end'].'\')';
        }
        $query = $query_1.(($query_1 != '') ? (($query_2 == '' && $query_3 == '') ? '' : 'AND') : '').$query_2.(($query_3 != '') ? (($query_2 == '' && $query_1 == '') ? '' : 'AND') : '').$query_3;
        return $query;
    }
    private function listtour_query_join($query = '', $module = ''){
        $join = [
            [
                $module.'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
            ]
        ];
        $param_join = [];
        if(isset($query) && $query != ''){
            $param_join = [
                'location_relationship', 'tb1.id = location_relationship.objectid ', 'inner'
            ];
            array_push($join,$param_join );
        }
        return $join;
    }

    public function render_tour($page = 1){
        helper(['mypagination']);
        $param['cat'] = $this->request->getPost('cat');
        $param['array'] = $this->request->getPost('array');
        $param['price'] = $this->request->getPost('price');
        $param['page'] = $this->request->getPost('page');
        $param['url'] = $this->request->getPost('url');
        $param['module'] = $this->request->getPost('module');
        $explode = explode('_', $param['module']);
        $importSQL = $this->create_query($param);
        $flag  = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
            'table' => $explode[0].' as tb1',
            'join' => $importSQL['join'],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
            ],
            'query' => $importSQL['query'],
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);

        $html = '';
        $page = (int)$param['page'];
        $config['base_url'] = $param['url'];
        $config['base_url'] = str_replace('.html', '', $config['base_url']);
        $config['per_page'] = 10;
        $config['total_rows'] = count($flag);
        if(count($flag) > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $config['per_page']], $config, $page);
            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;
            $flag  = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.viewed,tb1.tourid, tb1.image, tb1.album ,tb1.price, tb1.price_promotion,tb2.number_days, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb2.day_start',
                'table' => $explode[0].' as tb1',
                'join' => $importSQL['join'],
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1,
                ],
                'query' => $importSQL['query'],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'group_by' => 'tb1.id',
                'order_by' => 'tb1.catalogueid asc'
            ],TRUE);
            if(isset($flag) && is_array($flag) && count($flag)){
                foreach ($flag as $key => $value) {
                    $flag[$key]['description'] = base64_decode($value['description']);
                    $flag[$key]['content'] = base64_decode($value['content']);
                    if($flag[$key]['image'] == ''){
                        $flag[$key]['image'] = 'public/not-found.png';
                    }
                }
            }
            $html = $html.'<ul class="list-tour" >';
                if(isset($flag) && is_array($flag) && count($flag)){
                    foreach ($flag as $key => $value) {
                    $html = $html.'<li class="mb15">';
                        $html = $html.'<article class="uk-flex tour">';
                            $html = $html.'<div class="thumb img-zoomin mr20">';
                                $html = $html.'<a class="image img-cover" href="  '.check_isset($value['canonical']).HTSUFFIX.' " title="  '.check_isset($value['title']).' "><img src="  '.check_isset($value['image']).' " alt="  '.check_isset($value['title']).' "></a>';
                            $html = $html.'</div>';
                            $html = $html.'<div class="infor uk-flex">';
                                $html = $html.'<div class="wrap-content-tour mr50">';
                                    $html = $html.'<h3 class="title mb10"><a href="  '.check_isset($value['canonical']).HTSUFFIX.' " title="  '.check_isset($value['title']).' ">  '.check_isset($value['title']).'  </a></h3>';
                                    $html = $html.'<div class="star">';
                                        $html = $html.'<i class="fa fa-star"></i>';
                                        $html = $html.'<i class="fa fa-star"></i>';
                                        $html = $html.'<i class="fa fa-star"></i>';
                                        $html = $html.'<i class="fa fa-star"></i>';
                                        $html = $html.'<i class="fa fa-star"></i>';
                                    $html = $html.'</div>';
                                    
                                    $html = $html.'<div class="wrap-price isprice">';
                                        $html = $html.'<span class="old '.((isset($value['price_promotion']) && $value['price_promotion'] != 0) ? 'line-price' : '').'">  '.number_format(check_isset($value['price']),0,',','.').'  đ</span>';
                                        $html = $html.'<span class="new" style="'.((isset($value['price_promotion']) && $value['price_promotion'] != 0) ? '' : 'display: none;').'">  '.number_format(check_isset($value['price_promotion']),0,',','.').'  đ</span>';
                                    $html = $html.'</div>';
                                $html = $html.'</div>  ';
                                $html = $html.'<div class="order">';
                                    $html = $html.'<ul class="uk-list excerpt mb20">';
                                        $html = $html.'<li>Mã tour:   '.check_isset($value['tourid']).'  </li>';
                                        $html = $html.'<li><i class="fa fa-clock-o"></i> Thời gian :  '.check_isset($value['number_days']).' </li>';
                                        $html = $html.'<li><i class="fa fa-calendar"></i>   '.check_isset($value['day_start']).' </li>';
                                        $html = $html.'<li><i class="fa fa-user"></i> Số chỗ: 20</li>';
                                    $html = $html.'</ul>';
                                    $html = $html.'<div class="viewmore">';
                                        $html = $html.'<a href="  '.check_isset($value['canonical']).HTSUFFIX.' " title="  '.check_isset($value['title']).' ">Chi tiết <i class="fa fa-angle-right"></i></a>';
                                    $html = $html.'</div>';
                               $html = $html.' </div>';
                            $html = $html.'</div>';
                        $html = $html.'</article>';
                    $html = $html.'</li>';
                 }}else{ 
                    $html = $html.'<span class="text-danger mt30">Không có dữ liệu để hiển thị...</span>';
                 } 
            $html = $html.'</ul>';
            $html = $html.'<div id="pagination_ajax" class="va-num-page pagination_ajax">';
            $html = $html.'</div>';
            return json_encode([
                'html' => base64_encode($html),
                'pagination' => (isset($pagination) ? $pagination : '')
            ]);die();
        }
    }

    private function create_query($param = []){
        $find = [];
        $querySQL = '';
        $explode = explode('_', $param['module']);
        if(isset($param['cat']) && is_array($param['cat']) && count($param['cat'])){
            $find['location'] = $this->find_by_location($param);
        }
        if(isset($param['price']) && is_array($param['price']) && count($param['price'])){
            $find['price'] = $this->find_by_price($param);
        }
        if(isset($param['array']) && is_array($param['array']) && count($param['array'])){
            $find['attribute'] = $this->find_by_attribute($param);
        }
        if(isset($find) && is_array($find) && count($find)){
            $count = 1;
            foreach ($find as $key => $value) {
                $querySQL = $querySQL.$value.(($count == count($find) ? '' : ' AND '));
                $count++;
            }
        }
        $join = $this->query_join($find, $explode[0], $param);

        return [
            'query' => $querySQL,
            'join' => $join
        ];
    }
    private function find_by_location($param = []){
        $explode = explode('_', $param['module']);
        $query = '( ';
        foreach ($param['cat'] as $key => $value) {
            $query = $query.(($key == 0) ? '' : 'OR').' location_relationship.catalogueid = \''.$value.'\' ';
        }
        $query = $query.' )';
        return $query;
    }
    private function find_by_price($param = []){
        $explode = explode('_', $param['module']);
        $query = '( ';
        foreach ($param['price'] as $key => $value) {
            $price_explode = explode('-', $value);
            $query = $query.(($key == 0) ? '' : ' OR ').(($price_explode[0] == 'min') ? '( ' : '( tb1.price >= '.$price_explode[0]).(($price_explode[1] == 'max') ? ' )' : (($price_explode[0] == 'min') ? '' : ' AND ').' tb1.price <= '.$price_explode[1].' )');
        }
        $query = $query.' )';
        return $query;
    }
    private function find_by_attribute($param = []){
        $query = '';
        if(isset($param['array']) && is_array($param['array']) && count($param['array'])){
            foreach ($param['array'] as $key => $value) {
                foreach ($value as $keyChild => $valChild) {
                    $flag[$valChild['name']][] = $valChild['value'];
                }
                // $query = $query.(($key == 0) ? '' : 'OR').' attribute_relationship.attributeid = \''.$value.'\' ';
            }
            $index = 100;
            $count = 0;
            foreach ($flag as $key => $value) {
                $query = $query.(($count != 0) ? ' AND ' : '').' ( ';

                foreach ($value as $keyChild => $valChild) {
                    $query = $query.' tb'.$index.'.attributeid =  '.$valChild.' OR ';
                }
                $query = substr( $query,  0, strlen($query) -3 );
                $query = $query.' ) ';
                $count++;
                $index ++;
            }
        }
        return $query;
    }
    private function query_join($param = [], $module = '', $data = []){
        $join = [
            [
                $module.'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$module.'\' AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
            ]
        ];
        $param_join = [];
        if(isset($param) && is_array($param) && count($param)){
            foreach ($param as $key => $value) {
                if($key == 'location'){
                    $param_join = [
                        'location_relationship', 'tb1.id = location_relationship.objectid AND location_relationship.module ="location_catalogue" AND location_relationship.attribute = "end"', 'inner'
                    ];
                    array_push($join,$param_join );
                }
                
            }
        }
        $query = '';
        $json = [];
        if(isset($data['array']) && is_array($data['array']) && count($data['array'])){
            foreach ($data['array'] as $key => $value) {
                foreach ($value as $keyChild => $valChild) {
                    $flag[$valChild['name']][] = $valChild['value'];
                }
            }
            $index = 100;
            foreach ($flag as $key => $value) {
                foreach ($value as $keyChild => $valChild) {
                    $json = ['attribute_relationship as tb'.$index, 'tb1.id = tb'.$index.'.objectid ', 'inner'];
                    array_push($join,$json );
                }
                $index++;
            }
            $join = array_unique($join, SORT_REGULAR);
            $array = [];
            $dem = 0;
            foreach ($join as $key => $value) {
                $array[$dem] = $value;
                $dem++;
            }
            return $array;
        }
        return $join;
    }
}
