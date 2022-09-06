<?php
namespace App\Controllers\Frontend\Tag;
use App\Controllers\FrontendController;

class Tag extends FrontendController{

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
       
        // if(isset($this->data['detailCatalogue']) && is_array($this->data['detailCatalogue']) && count($this->data['detailCatalogue'])){
        //     $session->setFlashdata('message-danger', 'Danh mục không tồn tại!');
        //     return redirect()->to(BASE_URL);
        // }
        

        $seoPage = '';
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
        $keyword = $this->request->getGet('keyword');
        $catalogue = $this->condition_catalogue($id);
        $tags = $this->AutoloadModel->_get_where([
            'select' => 'objectid, title',
            'table' => 'tag_relationship',
            'where' => [
                'keyword' => $keyword
            ]
        ],true);

        $this->data['tag_info'] = $this->AutoloadModel->_get_where([
            'select' => 'objectid, title',
            'table' => 'tag_relationship',
            'where' => [
                'keyword' => $keyword
            ]
        ]);

        $this->data['tag_title'] = '';
        $config['total_rows'] = 0;
        $object = [];
        if(isset($tags) && is_array($tags) && count($tags)){
            foreach ($tags as $key =>  $value) {
                $object[] = $value['objectid'];
                $this->data['tag_title'] = $value['title'];
            }
            $config['total_rows'] = count($object);
        }
        $this->data['tags'] = json_encode($object);
        $config['base_url'] = write_url('tag', FALSE, TRUE);
        if($config['total_rows'] > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config);
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;
            $this->data['productList'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id,tb1.viewed,tb1.productid, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.module, tb2.description, tb2.content',
                'table' => 'product as tb1',
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1
                ],
                'where_in' => $object,
                'where_in_field' => 'tb1.id',
                'join' => [
                    [
                        'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                    ]
                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=> 'tb1.order desc, tb1.id desc',
                'group_by' => 'tb1.id'
            ], TRUE);
        }
        $this->data['meta_title'] = 'Tìm kiếm theo Tags';
        $this->data['meta_description'] = 'Tìm kiếm theo Tags';
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
        $this->data['general'] = $this->general;

        $this->data['template'] = 'frontend/tag/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(tb1.keyword LIKE \'%'.$keyword.'%\')';
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
        $tags = json_decode(base64_decode($this->request->getPost('tags')), true);
        $listObject = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed,tb1.productid, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.module, tb3.description, tb3.content',
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
            'limit' => 8,
            'where_in' => $tags,
            'where_in_field' => 'tb1.id',
            'start' => $start,
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.order desc, tb1.id desc'
        ], TRUE);
        $html = '';
        if(isset($listObject) && is_array($listObject) && count($listObject)){
            foreach ($listObject as $key => $value) {
                $titleS = $value['title'];
                $canonicalS = write_url($value['canonical']);
                $percent = percent($value['price'], $value['price_promotion']);
                $brand = (!empty($value['brand_title'])) ? $value['brand_title'] : 'Đang cập nhật';
                $price_show = ($value['price_promotion'] > 0) ? number_format($value['price_promotion'],'0',',','.').'đ' : ($value['price'] > 0 ?  number_format($value['price'], 0, ',', '.') : 0).'đ';
                if($price_show == 0){
                    $price_show = 'Liên Hệ';
                }
                $html = $html .'<div class="uk-width-1-2 uk-width-medium-1-2 uk-width-large-1-4 mb10">';
                    $html = $html .'<div class="product-item mb10">';
                        $html = $html .'<div class="percent">-'. $percent.'%</div>';
                        $html = $html .'<a href="'.$canonicalS.'" class="image img-scaledown">';
                              $html = $html .'<img  src="'.$value['image'].'" alt="'.$value['title'].'">'; 
                        $html = $html .'</a>';
                        $html = $html .'<h4 class="title limit-line-2"><a href="'.$canonicalS.'" title="<?php echo $titleS; ?>">'.$titleS.'</a></h4>';
                        $html = $html .'<div class="brand">Thương hiệu: '.$brand.'</div>';
                        $html = $html .'<div class="promotion-box uk-flex uk-flex-middle uk-flex-space-between">';
                            $html = $html .'<div class="price-box">';
                                $html = $html .'<div class="fs-price">'.$price_show.'</div>';
                                if($value['price_promotion'] > 0){ 
                                    $html = $html .'<div class="s-price">Giá gốc: '.number_format($value['price'], 0, ',','.').'đ</div>';
                                } 
                            $html = $html .'</div>';
                            $html = $html .'<div class="rate-box">';
                                $html = $html .'<span class="rating-box" title="4,8 sao">';
                                   $html = $html .' <span class="fa fa-star rated"></span>';
                                    $html = $html .'<span class="fa fa-star rated"></span>';
                                    $html = $html .'<span class="fa fa-star rated"></span>';
                                    $html = $html .'<span class="fa fa-star rated"></span>';
                                    $html = $html .'<span class="fa fa-star rated"></span>';
                                $html = $html .'</span>';
                                $html = $html .'<span class="rate-count">('.$value['rate'].')</span>';
                            $html = $html .'</div>';
                        $html = $html .'</div>';
                    $html = $html .'</div>';
               $html = $html .' </div>';
            }
        }
        echo json_encode([
            'html' => $html,
        ]);die();
    }
}
