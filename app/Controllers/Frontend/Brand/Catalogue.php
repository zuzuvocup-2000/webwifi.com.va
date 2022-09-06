<?php
namespace App\Controllers\Frontend\Brand;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'brand_catalogue';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description',
            'table' => $this->data['module'].' as tb1',
            'join' => [
                [   
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ]
        ]);
        // if(isset($this->data['detailCatalogue']) && is_array($this->data['detailCatalogue']) && count($this->data['detailCatalogue'])){
        //     $session->setFlashdata('message-danger', 'Danh mục không tồn tại!');
        //     return redirect()->to(BASE_URL);
        // }
        $this->data['breadcrumb'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical',
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

        if (is_array($this->data['breadcrumb']) && count($this->data['breadcrumb'])) {

            // get all cat as recursive
            $cat_aside = $this->AutoloadModel->_get_where(array(
                'select' => 'tb1.id, tb1.parentid, tb1.level, tb2.title, tb2.canonical, ',
                'table' => 'brand_catalogue as tb1',
                'where' => array(
                    'tb1.publish' => 1,
                    'tb1.deleted_at' => 0,
                    'tb1.lft >' => $this->data['breadcrumb'][0]['lft'],
                    'tb1.rgt <' => $this->data['breadcrumb'][0]['rgt'],
                ),
                'join' => [
                    [
                        'brand_translate as tb2','tb2.module = \'brand_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                    ]
                ],
                'limit' => 200,
                'order_by' => 'tb1.order desc, tb1.parentid asc, tb2.title asc'
            ),TRUE);
            $catalogue_brand = [];
            if(isset($cat_aside) && is_array($cat_aside) && count($cat_aside)){
                foreach ($cat_aside as $value) {
                    $catalogue_brand[] = $value['id'];
                }
            }

            $this->data['cat_aside'] = $this->AutoloadModel->_get_where(array(
                'select' => 'tb1.id,  tb2.title, tb2.canonical, ',
                'table' => 'brand as tb1',
                'where' => array(
                    'tb1.publish' => 1,
                    'tb1.deleted_at' => 0,
                ),
                'where_in' => $catalogue_brand,
                'where_in_field' => 'tb1.catalogueid',
                'join' => [
                    [
                        'brand_translate as tb2','tb2.module = \'brand\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                    ]
                ],
                'limit' => 200,
                'order_by' => 'tb1.order desc,  tb2.title asc'
            ),TRUE);
        }

        $seoPage = '';
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 10;
        $keyword = $this->condition_keyword();
        $catalogue = $this->condition_catalogue($id);
        $id_brand = [];
        $all_brand = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title',
            'table' => 'brand as tb1',
            'keyword' => $keyword,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'join' => [
                [
                    'brand_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "brand" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
        ], true);
        $id_brand = array_column($all_brand, 'id');

        // $config['total_rows'] = $this->AutoloadModel->_get_where([
        //     'select' => 'id',
        //     'table' => 'product',
        //     'keyword' => $keyword,
        //     'where_in' => $id_brand,
        //     'where_in_field' => 'brandid',
        //     'where' => [
        //         'deleted_at' => 0,
        //         'publish' => 1
        //     ],
        //     'count' => TRUE
        // ]);
        $config['base_url'] = write_url($this->data['detailCatalogue']['canonical'], FALSE, TRUE);
        // if($config['total_rows'] > 0){
        //     $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config);
        //     $this->pagination->initialize($config);
        //     $this->data['pagination'] = $this->pagination->create_links();

        //     $totalPage = ceil($config['total_rows']/$config['per_page']);
        //     $page = ($page <= 0)?1:$page;
        //     $page = ($page > $totalPage)?$totalPage:$page;
        //     if($page >= 2){
        //         $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
        //     }
        //     $page = $page - 1;
        //     $this->data['productList'] = $this->AutoloadModel->_get_where([
        //         'select' => 'tb1.id,tb1.viewed,tb1.productid, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.module, tb2.description, tb2.content',
        //         'table' => 'product as tb1',
        //         'where' => [
        //             'tb1.deleted_at' => 0,
        //             'tb1.publish' => 1,
        //         ],
        //         'where_in' => $id_brand,
        //         'where_in_field' => 'brandid',
        //         'keyword' => $keyword,
        //         'join' => [
        //             [
        //                 'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
        //             ]
        //         ],
        //         // 'limit' => $config['per_page'],
        //         // 'start' => $page * $config['per_page'],
        //         'order_by'=> 'tb1.order desc, tb1.created_at desc',
        //         'group_by' => 'tb1.id'
        //     ], TRUE);
        // }
        $this->data['brandCatalogueList'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.canonical, ',
            'table' => 'brand_catalogue as tb1',
            'join' =>  [
                [
                    'brand_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "brand_catalogue"   AND tb2.language = \''.$this->data['language'].'\' ','inner'
                ],
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'order_by'=> 'tb2.title asc'
        ], TRUE);
        $this->data['brandList'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,  tb1.image,  tb4.title ,  tb4.description , tb4.canonical, tb1.catalogueid,  ',
            'table' => 'brand as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.catalogueid' => $this->data['detailCatalogue']['id'],
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'brand_translate as tb4','tb1.id = tb4.objectid  AND tb4.module = "brand"  AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                ],
            ],
            'limit' => 9,
            'order_by'=> 'tb4.title asc',
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
        $this->data['general'] = $this->general;

        $this->data['template'] = 'frontend/product/catalogue/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(title LIKE \'%'.$keyword.'%\')';
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
                        'brand_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "brand_catalogue"','inner'
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
            'where_in_field' => 'tb1.catalogueid'
        ];

    }
}
