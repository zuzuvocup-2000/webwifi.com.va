<?php
namespace App\Controllers\Frontend\Media;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{

	protected $data;

	public function __construct(){
        $this->data = [];
        $this->data['module'] = 'media_catalogue';
        $this->data['language'] = $this->currentLanguage();
	}

	public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;

        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb1.login, tb2.template',
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

        if(!isset($this->data['detailCatalogue']) || is_array($this->data['detailCatalogue']) == false && count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            return redirect()->to(BASE_URL);
        }

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
                'select' => 'tb1.id, tb1.parentid, tb1.level, tb2.title, tb2.canonical, tb1.image',
                'table' => 'media_catalogue as tb1',
                'where' => array(
                    'tb1.publish' => 1,
                    'tb1.deleted_at' => 0,
                    'tb1.lft >=' => $this->data['breadcrumb'][0]['lft'],
                    'tb1.rgt <=' => $this->data['breadcrumb'][0]['rgt'],
                ),
                'join' => [
                    [
                        'media_translate as tb2','tb2.module = \'media_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                    ]
                ],
                'limit' => 200,
                'order_by' => 'tb1.order desc, tb1.parentid asc, tb2.title asc'
            ),TRUE);
            $cat_aside = recursive($cat_aside, $this->data['breadcrumb'][0]['id']);
            $this->data['cat_aside'] = $cat_aside;
        }
        $seoPage = '';
        $page = (int)$page;
        if(isset($this->data['breadcrumb'][0]['template']) && $this->data['breadcrumb'][0]['template'] == 'duan'){
            $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 12;
        }else{
            $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 13;
        }
        
        $keyword = $this->condition_keyword();
        $catalogue = $this->condition_catalogue($id);

        // $config['total_rows'] = $this->AutoloadModel->_get_where([
        //     'select' => 'tb1.id',
        //     'table' => $module_extract[0].' as tb1',
        //     'keyword' => $keyword,
        //     'where_in' => $catalogue['where_in'],
        //     'where_in_field' => $catalogue['where_in_field'],
        //     'where' => [
        //         'tb1.deleted_at' => 0,
        //         'tb1.publish' => 1
        //     ],
        //     'join' => [
        //         [
        //             'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
        //         ],
        //         [
        //             'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
        //         ],
        //         [
        //             'media_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "media_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
        //         ]
        //     ],
        //     'count' => TRUE
        // ]);


        $config['base_url'] = write_url($this->data['detailCatalogue']['canonical'], FALSE, TRUE);
        // if($config['total_rows'] > 0){
        //     $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
        //     $this->pagination->initialize($config);
        //     $this->data['pagination'] = $this->pagination->create_links();
        //     $totalPage = ceil($config['total_rows']/$config['per_page']);
        //     $page = ($page <= 0)?1:$page;
        //     $page = ($page > $totalPage)?$totalPage:$page;
        //     $seoPage = ($page >= 2)?(' - Trang '.$page):'';
        //     if($page >= 2){
        //         $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
        //     }
        //     $page = $page - 1;
            $this->data['articleList'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id,tb1.created_at,tb1.viewed, tb1.image, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.viewed, tb3.description, tb3.content, tb4.title as cat_title, tb1.catalogueid, tb1.iframe, tb4.title as cat_title, tb4.canonical as cat_canonical,tb4.description as cat_description, tb1.tinhtrang, tb3.customer, tb3.phongcach, tb3.area, tb3.brand, tb4.template as cat_template',
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
                        'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'media_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "media_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                    ]
                ],
                // 'limit' => $config['per_page'],
                // 'start' => $page * $config['per_page'],
                'order_by'=> 'tb1.order desc, tb1.id desc',
                'group_by' => 'tb1.id'
            ], TRUE);
            
        // }
        $this->data['meta_title'] = (!empty( $this->data['detailCatalogue']['meta_title'])? $this->data['detailCatalogue']['meta_title']: $this->data['detailCatalogue']['title']).$seoPage;
        $this->data['meta_description'] = (!empty( $this->data['detailCatalogue']['meta_description'])? $this->data['detailCatalogue']['meta_description']:cutnchar(strip_tags( $this->data['detailCatalogue']['description']), 300)).$seoPage;
        $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }
        $this->data['perpage'] = $perpage;
        $this->data['general'] = $this->general;
        if(isset($this->data['detailCatalogue']['template']) && $this->data['detailCatalogue']['template'] != ''){
            $this->data['template'] = 'frontend/media/catalogue/'.$this->data['detailCatalogue']['template'];
        }else{
            $this->data['template'] = 'frontend/media/catalogue/index';
        }
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
                        'media_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "media_catalogue"','inner'
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
        $module_extract = explode("_", $this->data['module']);
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
        $listObject = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb5.fullname',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
            'limit' => 13,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'start' => $start - 1,
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.order desc, tb1.id desc'
        ], TRUE);
        $html = '';
        if(isset($listObject) && is_array($listObject) && count($listObject)){
            $html = $html .'<div class="posts grid post-grid row" data-grid-options="{
                \'layoutMode\': \'fitRows\'}">';
            foreach ($listObject as $key => $value) {
                if(count($listObject) == 13 && count($listObject) - 1 == $key) {break;}
                $html = $html.'<div class="grid-item col-sm-6 col-lg-4 lifestyle shopping winter-sale">';
                    $html = $html.'<article class="post">';
                        $html = $html.'<figure class="post-media designs-media">';
                            $html = $html.'<a href="'.$value['canonical'].HTSUFFIX.'">';
                                $html = $html.'<img src="'.$value['image'].'" width="380" height="280" alt="'.$value['title'].'">';
                            $html = $html.'</a>';
                        $html = $html.'</figure>';
                        $html = $html.'<div class="post-details">';
                            $html = $html.'<div class="post-meta">';
                                $html = $html.'đăng ngày';
                                $html = $html.'<a class="post-date">';
                                    $html = $html.date('d', strtotime($value['created_at']));
                                    $html = $html.'tháng';
                                    $html = $html.date('m', strtotime($value['created_at']));
                                    $html = $html.'năm';
                                    $html = $html.date('Y', strtotime($value['created_at']));
                                $html = $html.'</a>';
                            $html = $html.'</div>';
                            $html = $html.'<h4 class="post-title designs-title">';
                            $html = $html.'<a href="'.$value['canonical'].HTSUFFIX.'">'.$value['title'].'</a>';
                            $html = $html.'</h4>';
                            $html = $html.'<p class="post-content">';
                                $html = $html.strip_tags(base64_decode($value['description']));
                            $html = $html.'</p>';
                            $html = $html.'<a href="'.$value['canonical'].HTSUFFIX.'" class="btn btn-link btn-underline btn-primary">';
                                $html = $html.'Đọc thêm';
                                $html = $html.'<i class="d-icon-arrow-right"></i>';
                            $html = $html.'</a>';
                        $html = $html.'</div>';
                    $html = $html.'</article>';
                $html = $html.'</div>';
            }
            $html = $html .'</div>';
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

    public function load_website_gallery(){
        $nextPage = $this->request->getPost('nextPage');
        $start = $this->request->getPost('start');
        $id = $this->request->getPost('id');
        $module_extract = explode("_", $this->data['module']);
        $get = json_decode(base64_decode($this->request->getPost('get')),true);
        $actual_link = $this->request->getPost('canonical').'?';
        $get['perpage'] = $start + 10;
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
        $listObject = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb5.fullname',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
            'limit' => 11,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'start' => $start - 1,
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.order desc, tb1.id desc'
        ], TRUE);
        $html = '';
        if(isset($listObject) && is_array($listObject) && count($listObject)){
            $html = $html .'<div class="post-grid gallery-xuong mb20 uk-grid uk-grid-collapse uk-grid-width-medium-1-2 uk-grid-width-large-1-4" data-uk-grid="">';
                foreach ($listObject as $key => $value) {
                    if($key == 10) break;
                    $html = $html .'<div class="item">';
                        $html = $html .'<div class="va-thumb-1-1">';
                            $html = $html .'<a href="'.$value['canonical'].HTSUFFIX.'" data-fancybox="xuong" class="img-cover image">';
                                $html = $html .'<img class="lazy" alt="'.$value['image'].'" src="'. $value['image'].'" width="180" height="180" />';
                            $html = $html .'</a>';
                        $html = $html .'</div>';
                        $html = $html .'<a href="'.$value['canonical'].HTSUFFIX.'" class="title-xuong">'.$value['title'].'</a>';
                    $html = $html .'</div>';
                }
            $html = $html .'</div>';
        }

        $json = [
            'html' => $html,
            'viewmore' => false,
            'canonical' => $actual_link,
        ];
        if(count($listObject) == 11){
            $json['viewmore'] = true;
        }
        echo json_encode($json);die();
    }
}
