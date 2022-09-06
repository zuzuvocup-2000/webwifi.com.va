<?php
namespace App\Controllers\Frontend\Tour;
use App\Controllers\FrontendController;

class ListTour extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'tour';
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
                    'tour_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
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
                'select' => 'tb1.id, tb1.time_end, tb1.catalogueid as cat_id, tb1.price, tb1.price_promotion,   tb3.title as tour_title, tb3.canonical,  tb3.start_at, tb3.end_at, tb3.day_start, tb3.number_days',
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
                        'tour_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "tour" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'tour_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "tour_catalogue" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],

                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=> 'tb1.id desc',
                'group_by' => 'tb1.id'
            ], TRUE);

            if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
                $this->data['canonical'] = $config['base_url'].HTSUFFIX;
            }
            $this->data['end'] = $this->location('end');
            $this->data['start'] = $this->location('start');

            $this->data['listLocation'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb2.title',
                'table' => 'location_catalogue as tb1',
                'join' => [
                    [
                        'location_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "location_catalogue" AND tb2.language = \''.$this->currentLanguage().'\' AND tb2.attribute = "end"', 'inner'
                    ]
                ],
                'order_by' => 'tb2.id asc'
            ],TRUE);

             $cat = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb2.title',
                'table' => 'tour_catalogue as tb1',
                'join' => [
                    [
                        'tour_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "tour_catalogue" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                    ]
                ],
                'order_by' => 'tb1.id asc'
            ],TRUE);
             if(isset($cat) && is_array($cat) && count($cat)){
                $this->data['cat'] = convert_array([
                    'data' => $cat,
                    'field' => 'id',
                    'value' => 'title',
                    'text' => 'Loại Tour',
                ]);
            }
            if(isset($end) && is_array($end) && count($end)){
                $this->data['end'] = convert_array([
                    'data' => $end,
                    'field' => 'id',
                    'value' => 'title',
                    'text' => 'điểm đến',
                ]);
            }
            $this->data['meta_title'] = 'Tổng hợp tất cả các Tour của KIM LIEN TRAVEL';
            $this->data['meta_description'] = 'Tổng hợp tất cả các Tour của KIM LIEN TRAVEL';
            $this->data['og_type'] = 'website';
        }
        $this->data['general'] = $this->general;
        if(in_array($this->detect_type, array('tablet', 'mobile'))){
            $this->data['template'] = 'mobile/tour/list/index';
            return view('mobile/homepage/layout/home', $this->data);
        }else{
            $this->data['template'] = 'frontend/tour/list/index';
            return view('frontend/homepage/layout/home', $this->data);
        }
    }

    public function condition_catalogue(){
        $catalogueid = $this->request->getGet('catalogueid');
        $id = [];
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $this->data['module'].'_catalogue as tb1',
                'join' =>  [
                    [
                        'tour_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                                    ],
                'where' => ['tb1.id' => $catalogueid],
            ]);

            $catalogueChildren = $this->AutoloadModel->_get_where([
                'select' => 'id',
                'table' => $this->data['module'].'_catalogue',
                'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
            ], TRUE);

            $id = array_column($catalogueChildren, 'id');
        }
        return [
            'where_in' => $id,
            'where_in_field' => 'tb2.catalogueid'
        ];

    }

    private function condition_where(){
        $where = [];

        $publish = $this->request->getGet('publish');
        if(isset($publish)){
            $where['tb1.publish'] = $publish;
        }

        $deleted_at = $this->request->getGet('deleted_at');
        if(isset($deleted_at)){
            $where['tb1.deleted_at'] = $deleted_at;
        }else{
            $where['tb1.deleted_at'] = 0;
        }

        return $where;
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }

    private function location($keyword = ''){
        $data = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title',
            'table' => 'location as tb1',
            'join' => [
                [
                    'location_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "location" AND tb2.language = \''.$this->currentLanguage().'\' AND tb2.attribute = \''.$keyword.'\'', 'inner'
                ]
            ],
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);
        if(isset($data) && is_array($data) && count($data)){
            $flag = convert_array([
                'data' => $data,
                'field' => 'id',
                'value' => 'title',
                'text' => 'điểm đến',
            ]);
        }
        return $flag;
    }

}
