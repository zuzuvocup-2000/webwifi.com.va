<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'product_catalogue';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $detailCatalogue = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb1.album, tb1.file',
            'table' => $this->data['module'].' as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ]
        ]);
        $this->data['detailCatalogue'] = $detailCatalogue;



        if(!isset($this->data['detailCatalogue']) || !is_array($this->data['detailCatalogue']) || count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Danh mục không tồn tại!');
            header('location:'.BASE_URL);
        }
        $breadcrumb = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical, tb1.parentid',
            'table' => $this->data['module'].' as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
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

        $this->data['breadcrumb'] = $breadcrumb;

        if (is_array($breadcrumb) && count($breadcrumb)) {

            // get all cat as recursive
            $cat_aside = $this->AutoloadModel->_get_where(array(
                'select' => 'tb1.id, tb1.parentid, tb1.level, tb2.title, tb2.canonical, tb1.image, tb1.icon',
                'table' => 'product_catalogue as tb1',
                'where' => array(
                    'tb1.publish' => 1,
                    'tb1.deleted_at' => 0,
                    'tb1.lft >' => $breadcrumb[0]['lft'],
                    'tb1.rgt <' => $breadcrumb[0]['rgt'],
                ),
                'join' => [
                    [
                        'product_translate as tb2','tb2.module = \'product_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                    ]
                ],
                'limit' => 200,
                'order_by' => 'tb1.order desc, tb1.parentid asc, tb2.title asc'
            ),TRUE);
            $cat_aside = recursive($cat_aside, $breadcrumb[0]['id']);
            $this->data['cat_aside'] = $cat_aside;
        }
        $seoPage = '';
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
        $keyword = $this->condition_keyword();
        $catalogue = $this->condition_catalogue($id);
        $config['total_rows'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id',
            'table' => $module_extract[0].' as tb1',
            'keyword' => $keyword,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'count' => TRUE
        ]);
        $this->data['count_product'] = $config['total_rows'];

        $config['base_url'] = write_url($this->data['detailCatalogue']['canonical'], FALSE, TRUE);
        if($config['total_rows'] > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();

            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;

            $order_by = 'tb1.order desc, tb1.id desc';
            if(isset($_GET['order_by']) && $_GET['order_by'] != ''){
                $order_by = $_GET['order_by'];
            }
            $this->data['productList'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id,tb1.viewed,tb1.hot, tb1.created_at ,tb1.productid, tb1.bar_code,tb1.model, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.module, tb3.description, tb3.content, tb1.model, tb1.bar_code, tb3.info, tb1.length, tb1.width, tb4.title as cat_title,tb4.canonical as cat_canonical,',
                'table' => $module_extract[0].' as tb1',
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1
                ],
                'where_in' => $catalogue['where_in'],
                'where_in_field' => $catalogue['where_in_field'],
                'keyword' => $keyword,
                'join' => [
                    [
                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                    ],
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "product_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                    ]
                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=>  $order_by,
                'group_by' => 'tb1.id'
            ], TRUE);
        }



        $this->data['thirdCat'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.canonical, tb1.image',
            'table' => 'product_catalogue as tb1',
            'join' => [
                ['product_translate as tb2','tb2.objectid = tb1.id','inner']
            ],
            'where' => [
                'tb1.lft >' => $breadcrumb[0]['lft'],
                'tb1.rgt <' => $breadcrumb[0]['rgt'],
                'tb1.level' => 3,
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
                'tb2.module' => 'product_catalogue'
            ],
            'order_by' => 'order desc, id desc'
        ], TRUE);
        $this->data['meta_title'] = (!empty( $this->data['detailCatalogue']['meta_title'])? $this->data['detailCatalogue']['meta_title']: $this->data['detailCatalogue']['title']).$seoPage;
        $this->data['meta_description'] = (!empty( $this->data['detailCatalogue']['meta_description'])? $this->data['detailCatalogue']['meta_description']:cutnchar(strip_tags( $this->data['detailCatalogue']['description']), 300)).$seoPage;
        $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }

        $this->data['slide_banner'] = get_slide([
            'keyword' => 'slide-banner',
            'language' => $this->currentLanguage(),
            'output' => 'html',
            'type' => 'uikit',
            'limit' => 1
        ]);

        $this->data['best_seller'] = $this->AutoloadModel->_get_where([
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
                'tb1.hot' => 1,
            ],
            'limit' => 5
        ], TRUE);
        $this->data['general'] = $this->general;
        $panel = get_panel([
            'locate' => 'product',
            'language' => $this->data['language']
        ]);
        foreach ($panel as $key => $value) {
            $this->data['panel'][$value['keyword']] = $value;
        }
        $this->data['perpage'] = $perpage;
        $this->data['template'] = 'frontend/product/catalogue/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
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
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "product_catalogue"','inner'
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

    public function load_website(){
        $nextPage = $this->request->getPost('nextPage');
        $start = $this->request->getPost('start');
        $id = $this->request->getPost('id');
        $get = json_decode(base64_decode($this->request->getPost('get')),true);
        $actual_link = $this->request->getPost('canonical').'?';
        $get['perpage'] = $start + 12;
        if(isset($get) && is_array($get) && count($get)){
            $dem = 0;
            foreach ($get as $key => $value) {
                $actual_link = $actual_link.$key.'='.$value;
                if($dem + 1 != count($get)) $actual_link = $actual_link.'&';
                $dem++;
            }
        }
        $catid_func = (isset($get['catalogueid']) && $get['catalogueid'] != 0 ? $get['catalogueid'] : $id);
        $catalogue = $this->condition_catalogue($catid_func);
        $order_by = 'tb1.order desc, tb1.id desc';
        if(isset($get['order_by']) && $get['order_by'] != ''){
            $order_by = $get['order_by'];
        }
        $query = '';
        if((isset($get['price_from']) && !empty($get['price_from'])) || (isset($get['price_to']) && !empty($get['price_to']))){
            $query = $query.'( '.((empty($get['price_from'])) ? '' : 'tb1.price >= '.str_replace('.', '', $get['price_from'])).' '.(empty($get['price_from']) || empty($get['price_to']) ? '' : 'AND').((empty($get['price_to'])) ? '' : ' tb1.price <= '.str_replace('.', '', $get['price_to'])).' )';
        }
        $keyword = '';
        if(isset($get['keyword']) && !empty($get['keyword'])){
            $keyword = '(tb3.title LIKE \'%'.$get['keyword'].'%\')';
        }
        $listObject = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.created_at, tb1.hot ,tb1.viewed,tb1.productid, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.module, tb3.description, tb3.content',
            'table' => 'product as tb1',
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "product" ', 'inner'
                ],
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
            ],
            'limit' => 13,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'keyword' => $keyword,
            'query' => $query,
            'start' => $start -1,
            'group_by' => 'tb1.id',
            'order_by' => $order_by
        ], TRUE);
        $html = '';
        $cookie = (isset($_COOKIE['product_wishlist']) ? explode(',', $_COOKIE['product_wishlist']) : []);
        if(isset($listObject) && is_array($listObject) && count($listObject)){
            foreach ($listObject as $key => $value) {
                if(count($listObject) == 13 && count($listObject) - 1 == $key) {break;}
                $html = $html .'<div class="product text-center">';
                    $html = $html .'<figure class="product-media" style="background-color: #f7f8fa;">';
                        $html = $html .'<a href="'.$value['canonical'].HTSUFFIX.'">';
                            $html = $html .'<img src="'.$value['image'].'" alt="'.$value['title'].'" width="280" height="280">';
                        $html = $html .'</a>';
                        $html = $html .'<div class="product-label-group">';
                            $percent = percent($value['price'], $value['price_promotion']);
                            if($percent != 0){
                                $html = $html .'<label style="color: #f2f2f2;background: red" class="product-label label-new">-'.$percent.'%</label>';
                            } 
                            if(strtotime($this->currentTime) < strtotime('+10 days', strtotime($value['created_at']))){ 
                                $html = $html .'<label style="color: #f2f2f2;background: #4CAF50" class="product-label label-new">New</label>';
                            }
                            if($value['hot'] == 1){
                                $html = $html .'<label style="color: #f2f2f2;background: #FF6900" class="product-label label-new">Hot</label>';
                            }
                        $html = $html .'</div>';
                        $html = $html .'<div class="product-action-vertical">';
                            $html = $html .'<a data-id="'.$value['id'].'" data-sku="SKU_'.$value['id'].'" class="buy_now btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>';
                            $html = $html .'<a data-id="'.$value['id'].'" class="btn-product-icon btn-wishlist '.(in_array($value['id'], $cookie) ? 'added' : '').'" title="'.(in_array($value['id'], $cookie) ? 'Remove from wishlist' : 'Add to wishlist').'"><i class="'.(in_array($value['id'], $cookie) ? 'd-icon-heart-full' : 'd-icon-heart').'"></i></a>';
                        $html = $html .'</div>';
                        $html = $html .'<div class="product-action">';
                            $html = $html .'<a data-link="'.$value['canonical'].HTSUFFIX.'" class="view-product btn-product" title="Quick View">Xem nhanh</a>';
                        $html = $html .'</div>';
                    $html = $html .'</figure>';
                    $html = $html .'<div class="product-details">';
                        $html = $html .'<h3 class="product-name">';
                        $html = $html .'<a href="'.$value['canonical'].HTSUFFIX.'">'.$value['title'].'</a>';
                        $html = $html .'</h3>';
                        $html = $html .'<div class="product-price">';
                            $html = $html .'<span class="price">'.(isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price_promotion'], 0, ',', '.').'đ' : (isset($value['price']) && $value['price'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : 'Liên hệ')).'</span>';
                            $html = $html .'<label class="price">'.(isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : '').'</label>';
                        $html = $html.'</div>';
                        $html = $html.'<div class="ratings-container">';
                            $html = $html.'<div class="ratings-full">';
                                $html = $html.'<span class="ratings" style="width:90%"></span>';
                                $html = $html.'<span class="tooltiptext tooltip-top"></span>';
                            $html = $html.'</div>';
                            $html = $html.'<a href="'.$value['canonical'].HTSUFFIX.'" class="rating-reviews">( 4 đánh giá )</a>';
                        $html = $html.'</div>';
                    $html = $html.'</div>';
                $html = $html.'</div>';
            }
        }

        $json = [
            'html' => $html,
            'viewmore' => false,
            'canonical' => $actual_link,
        ];
        if(count($listObject) == 13){
            $json['viewmore'] = true;
        }
        echo json_encode($json);die();
    }
}
