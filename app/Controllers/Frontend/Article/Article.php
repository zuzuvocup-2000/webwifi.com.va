<?php
namespace App\Controllers\Frontend\Article;
use App\Controllers\FrontendController;

class Article extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'article';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;

        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $keyword = $this->condition_keyword();
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed,tb1.album,tb3.template,tb3.sub_title,tb3.sub_content, tb1.catalogueid, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb5.fullname, tb1.video, tb1.productid',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
        ]);
        $cookie = $this->set_cookie($id, $this->data['object']);
        


        if(!isset($this->data['object']) || is_array($this->data['object']) == false && count($this->data['object']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            header('location:'.BASE_URL);
        }
        $this->data['object']['album'] = json_decode($this->data['object']['album']);
        $this->data['object']['description'] = validate_input(base64_decode($this->data['object']['description']));
        $this->data['object']['content'] = validate_input(base64_decode($this->data['object']['content']));
        $this->data['object']['sub_title'] = json_decode(base64_decode($this->data['object']['sub_title']));
        $this->data['object']['sub_content'] = json_decode(base64_decode($this->data['object']['sub_content']));
        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level,tb3.title as cat_title, tb3.canonical as cat_canonical, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb1.login, tb1.album',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    $module_extract[0].'_translate as tb3','tb3.module = \''.$this->data['module'].'_catalogue\' AND tb3.objectid = tb1.id AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $this->data['object']['catalogueid']
            ]
        ]);

        if(!isset($this->data['detailCatalogue']) || is_array($this->data['detailCatalogue']) == false && count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            header('location:'.BASE_URL);
        }

        if(isset($this->data['detailCatalogue']) && is_array($this->data['detailCatalogue']) && count($this->data['detailCatalogue'])){
            $this->data['detailCatalogue']['album'] = json_decode($this->data['detailCatalogue']['album'], true);
        }
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

        // $this->data['child_cat'] = [];
        // if(isset($this->data['breadcrumb']) && is_array($this->data['breadcrumb']) && count($this->data['breadcrumb'])){
        //     $this->data['child_cat'] = $this->AutoloadModel->_get_where([
        //         'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical',
        //         'table' => 'article_catalogue as tb1',
        //         'join' => [
        //             [
        //                 $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
        //             ]
        //         ],
        //         'where' => [
        //             'tb1.deleted_at' => 0,
        //             'tb1.publish' => 1,
        //             'tb1.lft >' => $this->data['breadcrumb'][0]['lft'],
        //             'tb1.rgt <' => $this->data['breadcrumb'][0]['rgt'],
        //         ],
        //         'limit' => 4,
        //         'order_by' => 'tb1.order desc, tb1.lft asc'
        //     ], TRUE);
        // }

        $this->data['meta_title'] = (!empty( $this->data['object']['meta_title'])? $this->data['object']['meta_title']: $this->data['object']['title']);
        $this->data['meta_description'] = (!empty( $this->data['object']['meta_description'])? $this->data['object']['meta_description']:cutnchar(strip_tags( $this->data['object']['description']), 300));
        $this->data['meta_image'] = !empty( $this->data['object']['image'])?base_url( $this->data['object']['image']):((isset($this->data['object']['album'][0])) ? $this->data['object']['album'][0] : '');

        $config['base_url'] = write_url($this->data['object']['canonical'], FALSE, TRUE);
        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }

        $this->data['general'] = $this->general;

        $catalogue = $this->condition_catalogue($this->data['detailCatalogue']['id']);

        $this->data['articleRelate'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title,tb1.info, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.id != ' => $this->data['object']['id'],
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.created_at desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        // $this->data['articleNew'] = $this->AutoloadModel->_get_where([
        //     'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title,tb1.info, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb1.viewed',
        //     'table' => $module_extract[0].' as tb1',
        //     'where' => [
        //         'tb1.id != ' => $this->data['object']['id'],
        //         'tb1.deleted_at' => 0,
        //         'tb1.publish' => 1
        //     ],
        //     'where_in' => $catalogue['where_in'],
        //     'where_in_field' => $catalogue['where_in_field'],
        //     'join' => [
        //         [
        //             'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
        //         ],
        //         [
        //             'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
        //         ],
        //         [
        //             $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
        //         ]
        //     ],
        //     'limit' => 10,
        //     'order_by'=> 'tb1.viewed desc',
        //     'group_by' => 'tb1.id'
        // ], TRUE);

        $this->data['articleHot'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title,tb1.info, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb1.viewed',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.id != ' => $this->data['object']['id'],
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.hot' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.viewed desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        // $this->data['articlePrev'] = $this->AutoloadModel->_get_where([
        //     'select' => 'tb1.id, tb1.image, tb3.title , tb3.canonical',
        //     'table' => $module_extract[0].' as tb1',
        //     'where' => [
        //         'tb1.deleted_at' => 0,
        //         'tb1.publish' => 1,
        //         'tb1.id <' => $this->data['object']['id']
        //     ],
        //     'where_in' => $catalogue['where_in'],
        //     'where_in_field' => $catalogue['where_in_field'],
        //     'join' => [
        //         [
        //             'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
        //         ],
        //         [
        //             'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
        //         ]
        //     ],
        //     'limit' => 1,
        //     'order_by'=> 'tb1.id desc',
        // ]);
        // $this->data['articleNext'] = $this->AutoloadModel->_get_where([
        //     'select' => 'tb1.id, tb1.image, tb3.title , tb3.canonical',
        //     'table' => $module_extract[0].' as tb1',
        //     'where' => [
        //         'tb1.deleted_at' => 0,
        //         'tb1.publish' => 1,
        //         'tb1.id >' => $this->data['object']['id']
        //     ],
        //     'where_in' => $catalogue['where_in'],
        //     'where_in_field' => $catalogue['where_in_field'],
        //     'join' => [
        //         [
        //             'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
        //         ],
        //         [
        //             'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
        //         ]
        //     ],
        //     'limit' => 1,
        //     'order_by'=> 'tb1.id asc',
        // ]);

        // $this->data['rate'] = $this->data_rate([
        //     'canonical' => $this->data['object']['canonical'],
        //     'module' => $this->data['module']
        // ]);
        // $this->data['product_best'] = $this->AutoloadModel->_get_where([
        //     'select' => 'tb1.id, tb2.title, tb1.price, tb1.hot, tb1.created_at, tb1.price_promotion, tb2.canonical, tb1.image, tb3.title as brand',
        //     'table' => 'product as tb1',
        //     'join' => [
        //         ['product_translate as tb2','tb2.objectid = tb1.id AND tb2.module="product" AND tb2.language = \''.$this->currentLanguage().'\'','inner'],
        //         ['brand_translate as tb3','tb3.objectid = tb1.brandid AND tb3.module = "brand"','left']
        //     ],
        //     'where' => [
        //         'tb1.publish' => 1,
        //         'tb1.deleted_at' => 0,
        //         'tb1.hot' => 1,
        //     ],
        //     'limit' => 5
        // ], TRUE);
    if(isset($this->data['object']['template']) && !empty($this->data['object']['template'])){
            $this->data['template'] = $this->data['object']['template'];
        }else{
            $this->data['template'] = 'frontend/article/article/index';
        }
        return view('frontend/homepage/layout/home', $this->data);
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
            // setcookie('COUNT_'.$this->data['module'], json_encode($idList), time() + 1*24*3600, "/");
            $cookie = $this->AutoloadModel->_update([
                'table' => $this->data['module'],
                'where' => [
                    'id' => $id,
                    'deleted_at' => 0,
                    'publish' => 1,
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

    public function condition_catalogue($catalogueid = 0){
        $id = [];
        $module_extract = explode("_", $this->data['module']);
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $module_extract[0].'_catalogue as tb1',
                'join' =>  [
                    [
                        'article_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "article_catalogue"','inner'
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
