<?php 
namespace App\Controllers\Frontend\Ajax;
use App\Controllers\BaseController;

class Dashboard extends BaseController{
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

    public function render_tour($page = 1){
        helper(['mypagination']);
        $param['cat'] = $this->request->getPost('cat');
        $param['vehicle'] = $this->request->getPost('vehicle');
        $param['time'] = $this->request->getPost('time');
        $param['price'] = $this->request->getPost('price');
        $param['perpage'] = $this->request->getPost('perpage');
        $param['catalogueid'] = $this->request->getPost('catalogueid');
        $param['module'] = $this->request->getPost('module');
        pre($param);
        $page = (int)$page;
        $catalogue = $this->condition_catalogue($param['catalogueid'],  $param['module']);
        $module_extract = explode("_", $param['module']);
        $config['total_rows'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id',
            'table' => $module_extract[0].' as tb1',
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'where' => [
                'deleted_at' => 0,
                'publish' => 1
            ],
            'join' => [
                    [
                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                    ]
                ],
            'count' => TRUE
        ]);
        pre($config['total_rows']);

        $this->data['tourList'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.viewed,tb1.tourid, tb1.image,tb1.price, tb1.price_promotion, tb3.number_days, tb1.album, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.description, tb3.content, tb3.day_start',
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
                    'tour_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "tour" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => $config['per_page'],
            'start' => $page * $config['per_page'],
            'order_by'=> 'tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);
    }

    public function condition_catalogue($catalogueid = 0, $module=''){
        $id = [];   
        $module_extract = explode("_", $module);
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $module_extract[0].'_catalogue as tb1',
                'join' =>  [
                    [
                        'tour_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "tour_catalogue"','inner'
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
