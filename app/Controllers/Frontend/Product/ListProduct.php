<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class ListProduct extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'product';
    }

    public function index($page = 1){
        helper(['mypagination']);
        $session = session();
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 50;
        $where = $this->condition_where();
        $keyword = $this->condition_keyword();
        $config['total_rows'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id',
            'table' => $this->data['module'].' as tb1',
            'join' =>  [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = \''.$this->data['module'].'\'   AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
            ],
            'keyword' => $keyword,
            'where' => $where,
            'count' => TRUE
        ]);
        if($config['total_rows'] > 0){
            $config['base_url'] = write_url('lich-tong-hop', FALSE, TRUE);
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
            $catalogue = $this->condition_catalogue();
            $this->data['object'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.time_end, tb1.catalogueid as cat_id,tb1.image, tb1.album, tb1.price,tb3.description, tb1.price_promotion, tb3.title,tb3.module, tb3.canonical,tb1.rate  ',
                'table' => $this->data['module'].' as tb1',
                'where' => $where,
                'where_in' => $catalogue['where_in'],
                'where_in_field' => $catalogue['where_in_field'],
                'keyword' => $keyword,
                'join' => [
                    [
                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
                    ],
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "product_catalogue" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],

                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=> 'tb1.id desc',
                'group_by' => 'tb1.id'
            ], TRUE);

           


            // $cat = $this->AutoloadModel->_get_where([
            //     'select' => 'tb1.id, tb2.title',
            //     'table' => 'product_catalogue as tb1',
            //     'join' => [
            //         [
            //             'product_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "product_catalogue" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
            //         ]
            //     ],
            //     'order_by' => 'tb1.id asc'
            // ],TRUE);

            //  if(isset($cat) && is_array($cat) && count($cat)){
            //     $this->data['cat'] = convert_array([
            //         'data' => $cat,
            //         'field' => 'id',
            //         'value' => 'title',
            //         'text' => 'Loại product',
            //     ]);
            // }
        }
        // get all cat as recursive
        $cat_aside = $this->AutoloadModel->_get_where(array(
            'select' => 'tb1.id, tb1.parentid, tb1.level, tb2.title, tb2.canonical, ',
            'table' => 'product_catalogue as tb1',
            'where' => array(
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
            ),
            'join' => [
                [
                    'product_translate as tb2','tb2.module = \'product_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                ]
            ],
            'limit' => 200,
            'order_by' => 'tb1.order desc, tb1.parentid asc, tb2.title asc'
        ),TRUE);
        $cat_aside = recursive($cat_aside);
        // print_r($cat_aside); exit;
        $this->data['cat_aside'] = $cat_aside;
        $detailCatalogue = [
            'title' => 'Tìm kiếm',
        ];
        $this->data['meta_title'] = 'Tìm kiếm';
        $this->data['meta_description'] = 'Kết quả tìm kiếm từ khoá: '.$_GET['keyword'];
        $this->data['og_type'] = 'website';

        $this->data['detailCatalogue'] = $detailCatalogue;

        $this->data['general'] = $this->general;
        $this->data['template'] = 'frontend/search/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    public function condition_catalogue(){
        $id = [];
        $catalogue = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' =>  [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                                ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.deleted_at' => 0,
            ],
        ], true);

        // print_r($catalogue); exit;
        if (isset($catalogue) && is_array($catalogue) && count($catalogue)) {
            $id = array_column($catalogue, 'id');
            return [
                'where_in' => $id,
                'where_in_field' => 'tb2.catalogueid'
            ];
        }
    }

    private function condition_where(){
        $where = [];

        $publish = $this->request->getGet('publish');
        if(isset($publish)){
            $where['tb1.publish'] = $publish;
        }else{
            $where['tb1.publish'] = 1;
        }

        $deleted_at = $this->request->getGet('deleted_at');
        if(isset($deleted_at)){
            $where['tb1.deleted_at'] = $deleted_at;
        }else{
            $where['tb1.deleted_at'] = 0;
        }
        // print_r($where); exit;

        return $where;
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }
}
