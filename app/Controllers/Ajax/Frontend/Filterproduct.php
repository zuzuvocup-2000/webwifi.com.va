<?php 
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Filterproduct extends FrontendController{
    public function __construct(){
        
    }

    public function render_product($page = 1){
        helper(['mypagination']);
        $param['cat'] = $this->request->getPost('cat');
        $param['catalogue'] = $this->request->getPost('catalogue');
        $param['brand'] = $this->request->getPost('brand');
        $param['array'] = $this->request->getPost('array');
        $param['price'] = $this->request->getPost('price');
        $param['page'] = $this->request->getPost('page');
        $param['url'] = $this->request->getPost('url');
        $param['module'] = $this->request->getPost('module');
        $explode = explode('_', $param['module']);
        $importSQL = $this->create_query($param);
        $flag  = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.viewed,tb1.productid, tb1.image,tb1.price, tb1.price_promotion, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content',
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
                'select' => 'tb1.id, tb1.viewed,tb1.productid,tb2.module, tb1.image, tb1.album ,tb1.price, tb1.price_promotion,tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb2.content, tb1.rate',
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
                }
            }

            $html = $html.'<ul class="list-product uk-grid uk-grid-small uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-4 uk-clearfix">';
                if(isset($flag) && is_array($flag) && count($flag)){
                    foreach ($flag as $key => $value) {
                        $html = $html.'<li class="mb15">';
                        $html = $html.'<article class="product">';
                            $html = $html.'<div class="thumb img-zoomin">';
                                  $html = $html.render_a(base_url($value['canonical'].HTSUFFIX), $value['title'], 'class="image img-cover"', '<img src="'.$value['image'].'" alt="'.($value['title'] == '' ? $value['image'] : $value['title']).'">');
                                $html = $html.'<div class="product-action">';
                                    $html = $html.'<a href="#modal-product" data-uk-modal class="product-view-detail" data-id="'.$value['id'].'"   data-module="'.$value['module'].'" title="'.$value['title'].'">';
                                        $html = $html.'<i class="fa fa-search-plus" aria-hidden="true"></i>';
                                    $html = $html.'</a>';
                                    $html = $html.'<a href="'.$value['canonical'].HTSUFFIX.'" title="'.$value['title'].'" class="product-btn-canonical">';
                                        $html = $html.'<i class="fa fa-cog" aria-hidden="true"></i>';
                                    $html = $html.'</a>';
                                $html = $html.'</div>';
                            $html = $html.'</div>';
                            $html = $html.'<div class="product-info">';
                                $html = $html.'<div class="wrap-content-product">';
                                    $html = $html.'<h3 class="title mb10"><a href="'.$value['canonical'].HTSUFFIX.'" title="'.$value['title'].'"> '.$value['title'].'</a></h3>';
                                    $html = $html.'<div class="wrap-price mb10">';
                                        $html = $html.'<span class="old '.((isset($value['price_promotion']) && $value['price_promotion'] != 0) ? 'line-price' : '').'">'.number_format(check_isset($value['price']),0,',','.').' đ</span>';
                                        $html = $html.'<span class="new" style="'.((isset($value['price_promotion']) && $value['price_promotion'] != 0) ? '' : 'display: none;').'">';
                                            $html = $html.number_format(check_isset($value['price_promotion']),0,',','.').' đ';
                                        $html = $html.'</span>';
                                   $html = $html.' </div>';
                                    $html = $html.'<div class="five-star mr20 text-left">';
                                        $html = $html.'<span class="rating order-1" data-stars="'.$value['rate'].'"  style="display: inline-block;">';
                                        for ($i=1; $i <= $value['rate'] ; $i++) { 
                                            $html = $html.'<i class="star-rating fa fa-star" aria-hidden="true"></i>';
                                        }
                                        for ($i=1; $i <= 5-$value['rate'] ; $i++) { 
                                            $html = $html.'<i class="star-rating fa fa-star-o" aria-hidden="true"></i>';
                                        }
                                        $html = $html.'</span>';
                                    $html = $html.'</div>';
                                $html = $html.'</div>  ';
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
        if(isset($param['catalogue']) && is_array($param['catalogue']) && count($param['catalogue'])){
            $find['catalogue'] = $this->find_by_catalogue($param);
        }
        if(isset($param['brand']) && is_array($param['brand']) && count($param['brand'])){
            $find['brand'] = $this->find_by_brand($param);
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

    // Tìm kiếm vị trí
    // 
    private function find_by_location($param = []){
        $explode = explode('_', $param['module']);
        $query = '( ';
        foreach ($param['cat'] as $key => $value) {
            $query = $query.(($key == 0) ? '' : 'OR').' location_relationship.catalogueid = \''.$value.'\' ';
        }
        $query = $query.' )';
        return $query;
    }

    private function find_by_brand($param = []){
        $explode = explode('_', $param['module']);
        $query = '( ';
        foreach ($param['brand'] as $key => $value) {
            $query = $query.(($key == 0) ? '' : 'OR ').'tb1.brandid = \''.$value.'\' ';
        }
        $query = $query.' )';
        return $query;
    }
    private function find_by_catalogue($param = []){
        $explode = explode('_', $param['module']);
        $query = '( ';
        foreach ($param['catalogue'] as $key => $value) {
            $query = $query.(($key == 0) ? '' : 'OR ').'tb1.catalogueid = \''.$value.'\' ';
        }
        $query = $query.' )';
        return $query;
    }

    // Tìm kiếm giá

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

    // Tìm kiếm theo thuộc tính

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
