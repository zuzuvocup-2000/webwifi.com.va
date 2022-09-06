<?php
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Dashboard extends FrontendController{
	public function __construct(){

	}

    
    public function get_canonical(){
        $language = $this->request->getPost('lang');
        $canonical = $this->request->getPost('canonical');
        $get = str_replace($canonical, '',$_SERVER['HTTP_REFERER']);
        $canonical = str_replace(BASE_URL, '',str_replace(HTSUFFIX, '', $canonical));
        $router = $this->AutoloadModel->_get_where([
            'select' => '*', 
            'table' => 'router',
            'where' =>[
                'canonical' => $canonical
            ]
        ]);
        $redirect = [];
        if(isset($router) && is_array($router) && count($router)){
            if($language != $router['language']){
                $redirect = $this->AutoloadModel->_get_where([
                    'select' => 'canonical', 
                    'table' => 'router',
                    'where' =>[
                        'objectid' => $router['objectid'],
                        'language' => $language,
                        'module' => $router['module'],
                        'view' => $router['view'],
                    ]
                ]);
            }
        }
        $canonical = '';
        if(isset($redirect['canonical']) && $redirect['canonical'] != ''){
            $canonical = BASE_URL.$redirect['canonical'].HTSUFFIX.$get;
        }
        echo $canonical; die();
    }


    public function search_huongnha(){
        $catalogueid = $this->request->getPost('catalogueid');
        $huong = $this->request->getPost('huong');
        $namsinh = $this->request->getPost('namsinh');
        $gender = $this->request->getPost('gender');

        $article = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb4.title, tb4.canonical, tb1.created_at, tb4.description, tb4.content,  tb1.huong, tb1.namsinh, tb1.namxaydung, tb1.gender',
            'table' => 'article as tb1',
            'join' => [
                [
                    'article_translate as tb4','tb1.id = tb4.objectid AND tb4.module = "article" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'where' => [
                'tb1.catalogueid' => $catalogueid,
                'tb1.huong' => $huong,
                'tb1.namsinh' => $namsinh,
                'tb1.gender' => $gender,
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
            ]
        ]);

        if(isset($article) && is_array($article) && count($article)){
            echo json_encode([
                'code' => 'success',
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
            ]);die();
        }else{
             echo json_encode([
                'code' => 'error',
            ]);die();
        }
    }

    public function search_tuoixaydung(){
        $catalogueid = $this->request->getPost('catalogueid');
        $namsinh = $this->request->getPost('namsinh');
        $namxaydung = $this->request->getPost('namxaydung');

        $article = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb4.title, tb4.canonical, tb1.created_at, tb4.description, tb4.content,  tb1.huong, tb1.namsinh, tb1.namxaydung, tb1.gender',
            'table' => 'article as tb1',
            'join' => [
                [
                    'article_translate as tb4','tb1.id = tb4.objectid AND tb4.module = "article" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'where' => [
                'tb1.catalogueid' => $catalogueid,
                'tb1.namxaydung' => $namxaydung,
                'tb1.namsinh' => $namsinh,
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
            ]
        ]);

        if(isset($article) && is_array($article) && count($article)){
            echo json_encode([
                'code' => 'success',
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
            ]);die();
        }else{
             echo json_encode([
                'code' => 'error',
            ]);die();
        }
    }

    public function change_language(){
        $language = $this->request->getPost('language');
        setcookie('language', $language, time() + (86400 * 30), "/"); // 86400 = 1 day

        print_r($language); exit;
    }

    public function search_ajax(){
        $val = $this->request->getPost('val');
        $keyword = '(tb3.title LIKE \'%'.$val.'%\')';
        $productList = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb1.price,tb1.price_promotion, tb1.hot, tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb1.viewed, tb3.description, tb3.content, tb1.created_at, tb5.fullname',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'keyword' => $keyword,
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "product" ', 'inner'
                ],
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    'product_translate as tb4','tb4.module = "product_catalogue" AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.order desc, tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);
        $html = '';
        if(isset($productList) && is_array($productList) && count($productList)){
            foreach ($productList as $value) {
                $html=$html.'<div class="wrap-product-search mb15">';
                    $html=$html.'<div class="uk-flex">';
                        $html=$html.'<div class="prd-image-search mr15">';
                            $html=$html.'<div class="va-thumb-1-1">';
                                $html=$html.'<a href="'.$value['canonical'].HTSUFFIX.'" class="image img-cover">';
                                    $html=$html.'<img src="'.$value['image'].'" alt="">';
                                $html=$html.'</a>';
                            $html=$html.'</div>';
                        $html=$html.'</div>';
                        $html=$html.'<div class="prd-info-search">';
                            $html=$html.'<a class="prd-title-search uk-display-block limit-line-1" href="'.$value['canonical'].HTSUFFIX.'">';
                                $html=$html.$value['title'];
                            $html=$html.'</a>';
                            $html=$html.'<div class="product-price">';
                                $html=$html.'<span class="price" style="color:#fd3003">'.(isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price_promotion'], 0, ',', '.').'đ' : (isset($value['price']) && $value['price'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : 'Liên hệ')).'</span>';
                                $html=$html.'<label class="price">'.(isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : '').'</label>';
                            $html=$html.'</div>';
                        $html=$html.'</div>';
                    $html=$html.'</div>';
                $html=$html.'</div>';
            }

            $html = $html.'<a href="tim-kiem'.HTSUFFIX.'?keyword='.$val.'" class="view-all-search uk-display-block uk-text-center">Xem tất cả</a>';
        }

        return json_encode(['html' => $html]);die();
    }

    public function view_product(){
        $id = $this->request->getPost('id');
        $object = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title, tb2.meta_title, tb2.sub_title,tb2.video, tb2.sub_content, tb1.productid, tb2.meta_description,  tb2.description, tb2.content, tb1.bar_code, tb1.model, tb1.brandid, tb1.articleid, tb1.icon, tb1.rate, tb3.title as brand_title',
            'table' => 'product as tb1',
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
        $html = '';
        if(isset($object) && is_array($object) && count($object)){
            $html = $html.'<div class="product product-single row product-popup">';
                $html = $html.'<div class="col-md-6">';
                    $html = $html.'<div class="product-gallery">';
                        $html = $html.'<div class="va-thumb-1-1 w100">';
                            $html = $html.'<div class="image img-cover">';
                                $html = $html.'<img src="'.$object['image'].'" alt="">';
                            $html = $html.'</div>';
                        $html = $html.'</div>';
                    $html = $html.'</div>';
                $html = $html.'</div>';
                $html = $html.'<div class="col-md-6">';
                    $html = $html.'<div class="product-details scrollable pr-0 pr-md-3">';
                        $html = $html.'<h1 class="product-name product-namedetail">'.$object['title'].'</h1>';
                        $html = $html.'<div class="product-meta">';
                            $html = $html.'SKU: <span class="product-sku">SKU_'.$object['id'].'</span>';
                            $html = $html.'BRAND: <span class="product-brand">'.$object['brand_title'].'</span>';
                        $html = $html.'</div>';
                        $html = $html.'<div class="product-price">';
                            $html = $html.'<span class="price">'.(isset($object['price_promotion']) && $object['price_promotion'] != 0 ? number_format($object['price_promotion'], 0, ',', '.').'đ' : (isset($object['price']) && $object['price'] != 0 ? number_format($object['price'], 0, ',', '.').'đ' : 'Liên hệ')).'</span>';
                            $html = $html.'<label class="price">'.(isset($object['price_promotion']) && $object['price_promotion'] != 0 ? number_format($object['price'], 0, ',', '.').'đ' : '').'</label>';
                        $html = $html.'</div>';
                        $html = $html.'<div class="ratings-container">';
                            $html = $html.'<div class="ratings-full">';
                                $html = $html.'<span class="ratings" style="width:100%"></span>';
                                $html = $html.'<span class="tooltiptext tooltip-top"></span>';
                            $html = $html.'</div>';
                            $html = $html.'<a href="#product-tab-reviews" class="link-to-tab rating-reviews">( 3 nhận xét )</a>';
                        $html = $html.'</div>';
                        $html = $html.'<p class="product-short-desc"></p>';
                        $html = $html.'<hr class="product-divider">';
                        $html = $html.'<div class="product-form product-qty">';
                            $html = $html.'<div class="product-form-group">';
                                $html = $html.'<div class="input-group mr-2">';
                                    $html = $html.'<button class="quantity-minus d-icon-minus button-minus"></button>';
                                    $html = $html.'<input class="quantity form-control input_qty" type="number" min="1" max="1000000" value="1">';
                                    $html = $html.'<button id="test_1" class="quantity-plus buy_now d-icon-plus button-plus"></button>';
                                $html = $html.'</div>';
                                $html = $html.'<button data-id="'.$object['id'].'" data-sku="SKU_'.$object['id'].'" class="buy_now btn-product btn-cart text-normal ls-normal font-weight-semi-bold">';
                                $html = $html.'<i class="d-icon-bag"></i> Thêm vào giỏ hàng';
                                $html = $html.'</button>';
                            $html = $html.'</div>';
                        $html = $html.'</div>';
                        $html = $html.'<hr class="product-divider mb-3">';
                        $html = $html.'<div class="product-footer">';
                           $html = $html.' <a data-id="'.$object['id'].'" class="btn-product btn-wishlist mr-6"><i class="d-icon-heart"></i><spa>Thêm vào danh sách yêu thích</spa></a>';
                        $html = $html.'</div>';
                    $html = $html.'</div>';
                $html = $html.'</div>';
            $html = $html.'</div>';
        }

        echo json_encode(['html' => $html]);
    }

	public function get_select2(){
		$id = $this->request->getPost('id');
		$end = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title',
            'table' => 'location as tb1',
            'join' => [
                [
                    'location_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "location" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
            	'catalogueid' => $id,
            	'deleted_at' => 0
            ],
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);
        if(isset($end) && is_array($end) && count($end)){
            $data = convert_array([
                'data' => $end,
                'field' => 'id',
                'value' => 'title',
                'text' => 'điểm đến',
            ]);
        }
        $html = '';
        foreach ($data as $key => $value) {
        	$html = $html.'<option value="'.$key.'">'.$value.'</option>';
        }
		echo json_encode([
			'html' => $html
		]); die();
	}

    public function get_modal_product(){
        $param['id'] = $this->request->getPost('id');
        $param['module'] = $this->request->getPost('module');

        $flag = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title, tb2.meta_title, tb2.sub_title,tb2.video, tb2.sub_content, tb1.productid, tb2.meta_description,  tb2.description, tb2.content, tb1.bar_code, tb1.model',
            'table' => $param['module'].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $param['id']
            ],
            'join' => [
                [
                    'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
        ]);
        if(isset($flag['album']) && $flag['album'] != ''){
            $flag['album'] = json_decode($flag['album']);
        }
        if(isset($flag['info']) && $flag['info'] != ''){
            $flag['info'] = json_decode($flag['info'], TRUE);
        }
        if(isset($flag['description']) && $flag['description'] != ''){
            $flag['description'] = validate_input(base64_decode($flag['description']));
        }
        if(isset($flag['content']) && $flag['content'] != ''){
            $flag['content'] = validate_input(base64_decode($flag['content']));
        }
        if(isset($flag['sub_content']) && $flag['sub_content'] != ''){
            $flag['sub_content'] = json_decode(base64_decode($flag['sub_content']));
        }
        if(isset($flag['sub_title']) && $flag['sub_title'] != ''){
            $flag['sub_title'] = json_decode(base64_decode($flag['sub_title']));
        }
        if(isset($flag['price']) && $flag['price'] != ''){
            $flag['price'] = number_format($flag['price'],0,',','.');
        }
        if(isset($flag['price_promotion']) && $flag['price_promotion'] != ''){
            $flag['price_promotion'] = number_format($flag['price_promotion'],0,',','.');
        }
        echo json_encode($flag);die();
    }

    public function send_comment(){
        $param['fullname'] = $this->request->getPost('fullname');
        $param['email'] = $this->request->getPost('email');
        $param['comment'] = $this->request->getPost('comment');
        $param['module'] = $this->request->getPost('module');
        $param['url'] = $this->request->getPost('canonical');
        $param['rate'] = $this->request->getPost('rate');
        $param['language'] = $this->currentLanguage();
        $param['comment'] = base64_encode($param['comment']);
        $param['created_at'] = $this->currentTime;
        $flag = $this->AutoloadModel->_insert([
            'table' => 'comment',
            'data' => $param
        ]);
        echo $flag;die();
    }

     public function view_sub_comment(){
        $value = json_decode(base64_decode($this->request->getPost('val')),TRUE);

        $flag = $this->AutoloadModel->_get_where([
            'select' => 'fullname, id, parentid, comment, created_at, image, album',
            'table' => 'comment',
            'where' => [
                'parentid' => $value['id'],
                'module' => $value['module'],
                'language' => $this->currentLanguage(),
                'deleted_at' => 0
            ],
            'order_by' => 'created_at asc'
        ],TRUE);
        if(isset($flag) && is_array($flag) && count($flag)){
            foreach ($flag as $key => $value) {
                $flag[$key]['comment'] = base64_decode($value['comment']);
                $flag[$key]['data_info'] = base64_encode(json_encode($flag[$key]));
                $flag[$key]['album'] = json_decode($value['album']);
            }
        }

        echo json_encode($flag);die();
    }

    public function reply_comment(){
        $param['user'] = json_decode(base64_decode($this->request->getPost('user')),true);
        $param['value'] = json_decode(base64_decode($this->request->getPost('value')),true);
        $param['reply'] = $this->request->getPost('reply');
        $param['album'] = $this->request->getPost('album');
        $store = [
            'language' => $this->currentLanguage(),
            'module' => $param['value']['module'],
            'parentid' => $param['value']['id'],
            'url' => $param['value']['url'],
            'image' => 'public/avatar.png',
            'fullname' => $param['user']['fullname'],
            'comment' => base64_encode($param['reply']),
            'created_at' => $this->currentTime,
            'album' => json_encode($param['album'])
        ];
        $flag = 0;
        $flag = $this->AutoloadModel->_insert([
            'table' => 'comment',
            'data' => $store
        ]);
        $store['comment'] = base64_decode($store['comment']);
        $store['album'] = json_decode($store['album']);
        $store['data_info'] = base64_encode(json_encode($store));
        if($flag > 0){
            echo json_encode($store);die();
        }
        else{
            echo '';die();
        }
    }

    public function update_comment(){
        $param['param'] = $this->request->getPost('param');
        $param['comment'] = $this->request->getPost('comment');
        $store = [
            'comment' => base64_encode($param['comment']),
            'updated_at' => $this->currentTime,
            'album' => json_encode($param['param']['album'])
        ];
        $flag = $this->AutoloadModel->_update([
            'table' => 'comment',
            'data' => $store,
            'where' => [
                'id' => $param['param']['id']
            ]
        ]);
        if($flag > 0){
            echo 0;die();
        }else{
            echo 1;die();
        }
    }

    public function ajax_delete(){
        $param['table'] = $this->request->getPost('table');
        $param['id'] = $this->request->getPost('id');
        $flag = $this->AutoloadModel->_update([
            'table' => $param['table'],
            'data' => [
                'deleted_at' => 1
            ],
            'where' => [
                'id' => $param['id']
            ]
        ]);
        if($flag > 0){
            echo 0;die();
        }else{
            echo 1;die();
        }
    }

    public function language(){
        $keyword = $this->request->getPost('keyword');
        setcookie('language', $keyword , time() + 1*24*3600, "/");
        pre($keyword);
    }

    public function view_combo(){
        $param['id'] = $this->request->getPost('id');
        $param['module'] = $this->request->getPost('module');
        $catalogueid = $this->AutoloadModel->_get_where([
            'select' => 'comboid',
            'table' => 'combo_relationship',
            'where' => [
                'module' => $param['module'],
                'objectid' => $param['id']
            ],
            'group_by' => 'comboid'
        ], true);
        $catalogue = [];
        $object = [];
        if(isset($catalogueid) && is_array($catalogueid) && count($catalogueid)){
            foreach ($catalogueid as $key => $value) {
                $catalogue[] = $value['comboid'];
            }
        }
        if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
            $object = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.type, tb1.value, tb1.time_end,tb3.canonical, tb2.objectid, tb3.title, tb4.image, tb4.price, tb4.price_promotion',
                'table' => 'combo as tb1',
                'join' => [
                    [
                        'combo_relationship as tb2', 'tb1.id = tb2.comboid AND tb2.module = \''.$param['module'].'\' ','inner'
                    ],
                    [
                        'product_translate as tb3', 'tb2.objectid = tb3.objectid AND tb3.module = \''.$param['module'].'\' AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product as tb4', 'tb2.objectid = tb4.id AND tb4.publish = 1 AND tb4.deleted_at = 0 ','inner'
                    ],
                ],
                'group_by' => 'tb2.objectid, tb1.id',
                'order_by' => 'tb1.time_end asc',
                'where_in' => $catalogue,
                'where_in_field' => 'tb1.id',
            ], TRUE);
        }
        $arr['data'] = [];
        $arr['count'] = 0;

        if(isset($object) && is_array($object) && count($object)){
            foreach ($object as $key => $value) {
                $arr['data'][$value['id']][] = $value;
            }
        }
        $arr['count'] = count($arr['data']);
        echo json_encode($arr);die();
    }
}
