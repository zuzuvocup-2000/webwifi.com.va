<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Product extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'product';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
  //       $panel = get_panel([
		// 	'locate' => 'home',
		// 	'language' => $this->currentLanguage()
		// ]);
  //       foreach ($panel as $key => $value) {
		// 	$this->data['panel'][$value['keyword']] = $value;
		// }
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $keyword = $this->condition_keyword();
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title,tb2.made_in, tb2.meta_title, tb2.sub_title,tb2.video, tb2.shock, tb2.sub_content, tb1.productid, tb2.meta_description,  tb2.description, tb2.content, tb1.bar_code, tb1.model, tb1.brandid, tb1.articleid, tb1.icon, tb1.rate, tb3.title as brand_title , tb2.type, tb2.info, tb1.created_at, tb2.huong, tb1.length, tb1.width, tb2.brand',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    'brand_translate as tb3','tb1.brandid = tb3.objectid AND tb3.module = "brand" AND tb3.language = \''.$this->currentLanguage().'\' ','left'
                ]
            ],
        ]);
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
        $cookie = $this->set_cookie($id, $this->data['object']);

        // $this->data['tags'] = $this->AutoloadModel->_get_where([
        //     'select' => '*',
        //     'table' => 'tag_relationship',
        //     'where' => [
        //         'module' => $this->data['module'],
        //         'language' => $this->currentLanguage(),
        //         'objectid' => $this->data['object']['id'],
        //     ]
        // ],true);

        if(!isset($this->data['detailCatalogue']) || is_array($this->data['detailCatalogue']) == false && count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            header('location:'.BASE_URL);
        }

        $this->data['child'] = $this->AutoloadModel->_get_where([
           'select' => 'tb1.id,  tb2.title, tb2.canonical',
           'table' => $module_extract[0].'_catalogue as tb1',
           'join' =>[
               [
                   $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'','inner'
               ]
           ],
           'where' => [
               'tb1.deleted_at' => 0,
               'tb1.publish' => 1,
               'tb1.lft >=' => $this->data['detailCatalogue']['lft'],
               'tb1.rgt <=' => $this->data['detailCatalogue']['rgt'],
           ],
           'group_by' => 'tb1.id',
           'order_by' => 'tb1.order desc, tb1.id desc'
        ],TRuE);


        $id = [];
        if(isset($this->data['child']) &&  is_array($this->data['child'])  && count($this->data['child'])){
            foreach ($this->data['child'] as $keyData => $valData) {
                array_push($id,$valData['id']);
            }
        }
        $this->data['product_general'] = $this->product_general($module_extract, $id);
        $this->data['product_random'] = $this->random_product($this->data['product_general'], $this->data['object']['id']);
        // $this->data['product_brand'] = $this->product_brand($this->data['object']);
        $breadcrumb = $this->breadcrumb($module_extract);
        // $this->data['cat_same_level'] = $this->cat_same($this->data['detailCatalogue'], $breadcrumb);
        // $this->data['connect_post'] = $this->connect_post($this->data['object']);
        $this->data['breadcrumb'] = $breadcrumb;
         // $this->data['category'] = $this->category();
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


        $this->data['general'] = $this->general;
        $this->data['template'] = 'frontend/product/product/index';
        return view('frontend/homepage/layout/home', $this->data);
    }
    private function connect_post($object = []){
        $id = explode(',', $object['articleid']);
        $listPost = [];
        if(isset($id) && is_array($id) && count($id) && $id[0] != ''){
            $listPost = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb2.title, tb2.description, tb2.content',
                'table' => 'article as tb1',
                'join' => [
                    ['article_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "article"','inner']
                ],
                'where' => [
                    'tb1.publish' => 1,
                    'tb1.deleted_at' => 0
                ],
                'where_in' => $id,
                'where_in_field' => 'tb1.id',
                'order_by' => 'order desc, id desc'
            ], TRUE);
        }
        return $listPost;
    }
    private function cat_same($detailCatalogue = [], $breadcrumb = []){
        $cat = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.canonical, tb1.icon, tb1.image, tb2.title',
            'table' => 'product_catalogue as tb1',
            'join' => [
                ['product_translate as tb2','tb2.objectid = tb1.id AND tb2.module = "product_catalogue"','inner']
            ],
            'where' => [
                'tb1.lft >' => $breadcrumb[0]['lft'],
                'tb1.rgt <' => $breadcrumb[0]['rgt'],
                'tb1.level' => $detailCatalogue['level']
            ]
        ], TRUE);
        return $cat;
    }
    private function product_brand($object){
        $product = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.canonical, tb2.title, tb1.price, tb1.price_promotion, tb1.image, tb1.rate',
            'table' => 'product as tb1',
            'join' => [
                ['product_translate as tb2','tb2.objectid = tb1.id AND tb2.module = "product"','inner']
            ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
                'tb1.brandid' => $object['brandid']
            ],
            'order_by' => "RAND()"
        ], TRUE);
        return $product;
    }
    private function random_product($product_general = [], $id = 0){
        $id_list = [];
        array_push($id_list, $id);
        if(isset($product_general) && is_array($product_general) && count($product_general)){
            foreach($product_general as $key => $val){
                $id_list[] = $val['id'];
            }
        }
        $id_list = array_unique($id_list);
        $product = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title, tb1.price, tb1.hot, tb1.created_at, tb1.price_promotion, tb2.canonical, tb1.image, tb3.title as brand',
            'table' => 'product as tb1',
            'join' => [
                ['product_translate as tb2','tb2.objectid = tb1.id AND tb2.module="product" AND tb2.language = \''.$this->currentLanguage().'\'','inner'],
                ['brand_translate as tb3','tb3.objectid = tb1.brandid AND tb3.module = "brand"','left']
            ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
                'tb1.deleted_at' => 0,
            ],
            'where_not_in' => $id_list,
            'where_in_field' => 'tb1.id',
            'limit' => 12,
            'order_by' => "RAND()"
        ], TRUE);
        return $product;
    }
    private function product_general($module_extract = [], $id = []){
        $product_general = $this->AutoloadModel->_get_where([
            'select' => 'tb1.catalogueid, tb3.id, tb3.price, tb3.hot, tb3.created_at,  tb3.price_promotion, tb3.image, tb2.module, tb3.rate, tb3.album,       tb2.title,tb2.description, tb2.content, tb2.canonical,  tb2.meta_title, tb2.meta_description, tb3.model, tb3.bar_code, tb2.info, tb3.width, tb3.length',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'\' AND tb2.objectid = tb1.objectid AND tb2.language = \''.$this->currentLanguage().'\'','inner'
                ],
                [
                    $module_extract[0].' as tb3', 'tb1.objectid = tb3.id AND tb3.deleted_at = 0','inner'
                ]
            ],
            'where' => [
                'tb1.module' => $module_extract[0],
            ],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'group_by' => 'tb3.id',
            'order_by' => 'tb3.order desc, tb3.id desc',
            'limit' => 12
         ],TRuE);
         return $product_general;
    }
    private function category(){
        $category = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.canonical, tb2.title',
            'table' => 'product_catalogue as tb1',
            'join' => [
                ['product_translate as tb2', 'tb2.objectid = tb1.id', 'inner']
            ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.level' => 2,
                'tb2.module' => 'product_catalogue'
            ]
        ], TRUE);
        return $category;
    }
    private function breadcrumb($module_extract = []){
        $breadcrumb = $this->AutoloadModel->_get_where([
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
        return $breadcrumb;
    }

    private function get_list_wholesale($id = 0){
        $check = $this->AutoloadModel->_get_where([
            'select' => 'number_start, number_end, price',
            'table' => 'product_wholesale',
            'where' => ['objectid' => $id, 'module' => $this->data['module']]
        ]);
        if(isset($check) && is_array($check) && count($check)){
            $array = [
                'number_start' => json_decode($check['number_start']),
                'number_end' => json_decode($check['number_end']),
                'price_wholesale' => json_decode($check['price']),
            ];
            $data = [];
            foreach ($array as $key => $value) {
                foreach ($value as $keyChild => $valChild) {
                    $data[$keyChild][$key] = $valChild;
                }
            }
            return $data;
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
                    'viewed' => $param['viewed'] + 1,
                    'created_at' => $this->currentTime
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
                        'viewed' => $param['viewed'] + 1,
                        'created_at' => $this->currentTime
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
        if(isset($param['brand']) && $param['brand'] != ''){
            $param['brand'] = json_decode($param['brand'], TRUE);
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
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "product"','inner'
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
