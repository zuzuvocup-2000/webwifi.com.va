<?php
namespace App\Controllers\Frontend\Media;
use App\Controllers\FrontendController;

class Media extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'media';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;

        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $keyword = $this->condition_keyword();
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical, tb2.meta_title, tb2.meta_description,  tb2.description, tb2.content, tb2.sub_title, tb2.sub_content, tb1.created_at, tb1.iframe, tb5.fullname, tb2.area, tb2.customer, tb2.phongcach, tb2.brand ,tb1.tinhtrang',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'media_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "media" AND tb2.language = \''.$this->data['language'].'\' ','inner'
                ],
                [   
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
        ]);

        $this->data['object']['sub_title'] = json_decode(base64_decode($this->data['object']['sub_title']));
        $this->data['object']['sub_content'] = json_decode(base64_decode($this->data['object']['sub_content']));

        $panel = get_panel([
            'locate' => 'media',
            'language' => $this->currentLanguage()
        ]);

        foreach ($panel as $key => $value) {
            $this->data['panel'][$value['keyword']] = $value;
        }

        $this->data['object']['album'] = json_decode($this->data['object']['album']);
        $this->data['object']['description'] = validate_input(base64_decode($this->data['object']['description']));
        $this->data['object']['content'] = validate_input(base64_decode($this->data['object']['content']));

        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb1.login',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->data['language'].'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $this->data['object']['catalogueid']
            ]
        ]);

        $this->data['breadcrumb'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical, tb2.template',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->data['language'].'\'', 'inner'
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

        $cookie = $this->set_cookie($id, $this->data['object']);

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
            'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at, tb5.fullname, tb3.customer, tb3.area, tb3.phongcach',
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
                    'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    $module_extract[0].'_translate as tb4','tb4.module = \''.$module_extract[0].'_catalogue\' AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'user as tb5','tb1.userid_created = tb5.id', 'inner'
                ]
            ],
            'limit' => 9,
            'order_by'=> 'tb1.created_at desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        $this->data['articlePrev'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.image, tb3.title , tb3.canonical',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id <' => $this->data['object']['id']
            ],
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 1,
            'order_by'=> 'tb1.id desc',
        ]);
        $this->data['articleNext'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.image, tb3.title , tb3.canonical',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id >' => $this->data['object']['id']
            ],
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'media_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "media" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 1,
            'order_by'=> 'tb1.id asc',
        ]);
        if(isset($this->data['breadcrumb'][0]['template']) && $this->data['breadcrumb'][0]['template'] != ''){
            $this->data['template'] = 'frontend/media/media/'.$this->data['breadcrumb'][0]['template'];
        }else{
            $this->data['template'] = 'frontend/media/media/index';
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
                    'viewed' => $param['viewed'] + 1
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
                        'viewed' => $param['viewed'] + 1
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
                        'media_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->data['language'].'\' AND tb3.module = "media"','inner'
                    ],
                ],
                'where' => ['tb1.id' => $catalogueid],
            ]);
            if(isset($catalogue) &&is_array($catalogue) && count($catalogue)){
                $catalogueChildren = $this->AutoloadModel->_get_where([
                    'select' => 'id',
                    'table' => $module_extract[0].'_catalogue',
                    'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
                ], TRUE);

                $id = array_column($catalogueChildren, 'id');
                
            }
        }
        return [
            'where_in' => $id,
            'where_in_field' => 'tb2.catalogueid'
        ];

    }
}
