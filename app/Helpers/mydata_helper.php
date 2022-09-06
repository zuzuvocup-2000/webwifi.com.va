<?php
use App\Models\AutoloadModel;
use App\Controllers\FrontendController;
use App\Controllers\BaseController;



if (! function_exists('currentLanguage')){
	function currentLanguage(){
		$FrontendController = new FrontendController();
		return $FrontendController->currentLanguage();
	}
}

if (! function_exists('be_currentLanguage')){
    function be_currentLanguage(){
        $BaseController = new BaseController();
        return $BaseController->currentLanguage();
    }
}

if (! function_exists('get_price')){
	function get_price($param = []){
		$price = 0;
		if(isset($param['price_promotion']) && $param['price_promotion'] != 0){
			$price = $param['price_promotion'];
		}else{
			$price = $param['price'];
		}

		$price = number_format($price, 0, '', ',');
		return $price;
	}
}

if (! function_exists('get_tag')){
	function get_tag($param = []){
		$model = new AutoloadModel();
		$tags = $model->_get_where([
			'select' => '*',
			'table' => 'tag_relationship',
			'where' => [
				'module' => $param['module'],
				'language' => $param['language'],
				'objectid' => $param['objectid'],
			]
		],true);
		$text = '';
		$count = 0;
		foreach ($tags as $key => $value) {
			$text = $text. $value['title'];
			if($count + 1 < count($tags)) $text=$text.', ';
			$count++;
		}
		return $text;
	}
}

if (! function_exists('get_data')){
	function get_data(array $param = []){
		$model = new AutoloadModel();

		$where = [];
		if(isset($param['where'])){
			$where = $param['where'];
		}
	 	$object = $model->_get_where([
            'select' => $param['select'],
            'table' => $param['table'],
            'where' => $where,
            'order_by' => $param['order_by']
        ], TRUE);
	 	return $object;
	}
}


if(!function_exists('cal_percent')){
    function cal_percent($param = []){
		if($param['sum'] > 0){
			$result_present = $param['present']/$param['sum'] * 100;
	       	$result_ago = $param['ago']/$param['sum'] * 100;
	       	$result = $result_present - $result_ago;
	        return round($result,2);
		}else{
			return 0;
		}

    }
}

if (! function_exists('delete_router')){
	function delete_router($id = '', $module = '', $language = ''){
		$model = new AutoloadModel();
	 	$object = $model->_delete([
            'table' => 'router',
            'where' => [
            	'language' => $language,
            	'objectid' => $id,
            	'module' => $module,
            ],
        ]);
	 	return $object;
	}
}

if (! function_exists('delete_catalogue')){
	function delete_catalogue(array $param = []){
		$model = new AutoloadModel();
		$module = explode('_',  $param['module']);
		$flag = 0;
		$catid = $model->_get_where([
			'select' => 'id',
			'table' => $param['module'],
           	'where' => [
           		'lft >=' => $param['lft'],
				'rgt <=' => $param['rgt'],
				'deleted_at' => 0
           	]
		], TRUE);
		$router  = $catid;
		if(isset($catid) && is_array($catid) && count($catid)){
			foreach ($catid as $key => $value) {
				$catid[$key]['deleted_at'] = 1;
			}

			$flag = $model->_update_batch([
				'table' => $param['module'],
				'data' => $catid,
				'field' => 'id'
			]);
			foreach ($router as $key => $value) {
				$model->_update([
		            'table' => 'router',
		            'data' => [
		            	'canonical' => ''
		            ],
		            'where' => [
		            	'objectid' => $value['id'],
		            	'language' => $param['language'],
		            	'module' => $param['module']
		            ]
		        ]);
			}
			if($flag > 0){
				$id = [];
				foreach ($catid as $key => $value) {
					$id[] = $value['id'];
				}
				$store = $model->_get_where([
					'select' => 'id',
					'table' => $module[0],
		           	'where_in' => $id,
		           	'where_in_field' => 'catalogueid',
		           	'where' => [
		           		'deleted_at' => 0
		           	]
				],TRUE);
				$router_blog = $store;
				if(isset($store) && is_array($store) && count($store)){
					foreach ($store as $key => $value) {
						$store[$key]['deleted_at'] = 1;
					}
					$result = $model->_update_batch([
						'table' => $module[0],
						'data' => $store,
						'field' => 'id'
					]);
					foreach ($router_blog as $key => $value) {
						$model->_update([
				            'table' => 'router',
				            'data' => [
				            	'canonical' => ''
				            ],
				            'where' => [
				            	'objectid' => $value['id'],
				            	'language' => $param['language'],
				            	'module' => $module[0]
				            ]
				        ]);
					}
				}
			}
		}
		return $flag;
	}
}

if (! function_exists('check_type_canonical')){
	function check_type_canonical($language = ''){
		$model = new AutoloadModel();

	 	$object = $model->_get_where([
            'select' => 'content',
            'table' => 'system_translate',
            'where' => [
            	'language' => $language,
            	'keyword' => 'website_canonical'
            ],
        ]);
	 	return $object;
	}
}

if (! function_exists('get_attribute_catalogue')){
	function get_attribute_catalogue($language, $module){
		$model = new AutoloadModel();

	 	$catalogue = $model->_get_where([
            'select' => ' title, canonical, objectid',
            'table' => 'attribute_translate',
            'where' => [
            	'language' => $language,
            	'module' => 'attribute_catalogue',
            	'module_primary' => $module
            ],
        ], TRUE);
        // pre($catalogue);
	 	return $catalogue;
	}
}

if (! function_exists('get_attribute')){
	function get_attribute($language){
		$model = new AutoloadModel();
	 	$data = $model->_get_where([
            'select' => 'tb1.id, tb1.catalogueid, tb2.title, tb2.canonical',
            'table' => 'attribute as tb1',
           	'join' => [
           		[
           			'attribute_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$language.'\' AND tb2.module = "attribute"','inner'
           		]
           	]
        ], TRUE);
	 	return $data;
	}
}

if (! function_exists('separateArray')){
	function separateArray($param= [], $target=[]){
		$data=[];
		for ($i = 0; $i < count($param);$i++){
			if (isset($param[$i]))
				for ($j = 0; $j < count($target);$j++){
					$data[$i][$target[$j]] = $param[$i][$target[$j]];
				}
			}
		return $data;
	}
}
if(!function_exists('get_id_create_batch')){
	function get_id_create_batch(int $firstid = 0, int $length = 0){
		$data[] = $firstid;
		for($i = 1 ; $i < $length; $i++){
			$data[] = $firstid + $i;
		}

		return $data;
	}
}

if (! function_exists('count_object')){
	function count_object(array $param = []){
		$model = new AutoloadModel();

		$catalogueid = $param['catalogueid'];

		$id = [];
		if($catalogueid > 0){
			$catalogue = $model->_get_where([
				'select' => 'id, lft, rgt, title',
				'table' => $param['module'].'',
				'where' => ['id' => $catalogueid],
			]);

			$catalogueChildren = $model->_get_where([
				'select' => 'id',
				'table' => $param['module'].'',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}

		$count = 0;
		$module = explode('_',  $param['module']);
		if(isset($id) && is_array($id)  && count($id)){
			$count = $model->_get_where([
				'select' => 'tb1.id',
				'table' => current($module).' as tb1',
				'where' => [
					'tb1.deleted_at' => 0,
					'tb1.publish' => 1,
				],
				'where_in' => $id,
				'where_in_field' => 'tb2.catalogueid',
				'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.current($module).'\' ', 'inner'
					],
					[
						'user as tb3','tb1.userid_created = tb3.id','inner'
					]
				],
				'group_by' => 'tb1.id',
				'count' => TRUE
			]);
		}


		return $count;

	}
}

if (! function_exists('convert_code')){
	function convert_code($code = '', $module =''){
		$model = new AutoloadModel();

		$code_Explode = explode('-',  $code );
		$code = (int)'1'.$code_Explode[1];
		$id = $model->_get_where([
			'select' => 'objectid',
			'table' => 'id_general',
			'where' => ['module' => $module]
		]);
		$code  = $code + $id['objectid'];
		$code = substr($code, 1);
		$code = $code_Explode[0].'-'.$code.'-'.$code_Explode[2];
		return $code;
	}
}

if (! function_exists('get_catalogue_object')){
	function get_catalogue_object(array $param = []){
		$model = new AutoloadModel();
		$object = $model->_get_where([
		  	'select' => 'tb1.id, tb4.title',
            'table' => $param['module'].'_catalogue as tb1',
            'join' => [
        		[
					$param['module'].'_translate as tb4','tb1.id = tb4.objectid AND tb4.module = \''.$param['module'].'_catalogue'.'\'  AND tb4.language = \''.be_currentLanguage().'\'','inner'
				]
			],
            'where' => ['tb1.deleted_at' => 0],
            'where_in' => $param['catalogue'],
            'where_in_field' => 'tb1.id',
            'order_by' => 'tb4.title asc'
		], TRUE);
		return $object;

	}
}


if (! function_exists('get_list_language')){
	function get_list_language(array $param = []){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1,'canonical !=' => $param['currentLanguage']]
		], TRUE);

		return $language;
	}
}
if (! function_exists('get_all_language')){
	function get_all_language(){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1]
		], TRUE);

		return $language;
	}
}


if (! function_exists('get_full_language')){
	function get_full_language(array $param = []){
		$model = new AutoloadModel();

		$language = $model->_get_where([
			'select' => 'id, canonical, image',
			'table' => 'language',
			'where' => ['publish' => 1]
		], TRUE);

		return $language;
	}
}


if (! function_exists('check_id_exist')){
	function check_id_exist($module = ''){
		$model = new AutoloadModel();

		$count = $model->_get_where([
			'table' => 'id_general',
			'where' => ['module' => $module],
			'count' => TRUE
		], TRUE);

		return $count;
	}
}


if (! function_exists('check_attribute')){
	function check_attribute($canonical = '', $module = ''){
		$model = new AutoloadModel();
		$moduleExplode = explode('_',  $module);
		$count = $model->_get_where([
			'table' => 'attribute_translate',
			'where' => ['module' => $module, 'canonical' => $canonical],
			'count' => TRUE
		], TRUE);

		return $count;
	}
}

if (! function_exists('object_menu')){
	function object_menu($module = '',$translate = 0, $language = ''){
		$model = new AutoloadModel();
		$moduleExplode = explode('_',  $module);
		if(isset($params['translate']) && $params['translate'] == 0){
			$ObjectList = $model->_get_where([
				'select' => 'title, canonical, id',
				'table' => $module,
				'order_by' => 'created_at desc',
				'limit' => 5
			],TRUE);
		}else{
			if(isset($moduleExplode[1])){
				$ObjectList = $model->_get_where([
					'select' => 'tb1.title, tb1.id, tb1.canonical, tb1.module, tb2.parentid as catalogueid, tb1.objectid as objectid',
					'table' => $moduleExplode[0].'_translate as tb1',
					'join' => [
						[
							$module.' as tb2', 'tb2.id = tb1.objectid', 'inner'
						],
					],
					'where' => [
						'tb1.module' => $module,
						'tb1.language' => $language,
						'tb2.deleted_at' => 0
					],
					'order_by' => 'tb1.created_at desc',
					'limit' => 5
				],TRUE);
			}else{
				$ObjectList = $model->_get_where([
					'select' => 'tb1.title, tb1.objectid as objectid, tb1.canonical, tb1.module, tb2.catalogueid as catalogueid',
					'table' => $moduleExplode[0].'_translate as tb1',
					'join' => [
						[
							$module.' as tb2', 'tb2.id = tb1.objectid', 'inner'
						],
					],
					'where' => [
						'tb1.module' => $module,
						'tb1.language' => $language,
						'tb2.deleted_at' => 0
					],
					'order_by' => 'tb1.created_at desc',
					'limit' => 5
				],TRUE);
			}
		}
		return $ObjectList;
	}
}


if (! function_exists('silo')){
	function silo($id = '', $canonical = '', $module = '', $catid = '', $lang = ''){
	    $model = new AutoloadModel();
		$moduleExplode = explode('_',  $module);
	    if($catid == 0){
	        $category = $model->_get_where([
	            'select' => 'id, lft, rgt',
	            'table' => $moduleExplode[0].'_catalogue',
	            'where' => ['parentid' => $catid, 'id' => $id]
	        ]);
	       	$allCategory = $model->_get_where([
	            'select' => 'objectid, canonical, module',
	            'table' => $moduleExplode[0].'_translate',
	            'where' => [
	            	$moduleExplode[0].'_translate.id' => $category['id'],
	            	'module' => $moduleExplode[0].'_catalogue',
	            	'language' => $lang
	            ],
	            'join' => [
	            	[
	            		$moduleExplode[0].'_catalogue', $moduleExplode[0].'_catalogue.id = '.$category['id'].'','inner'
	            	]
	            ],
	            'order_by' => $moduleExplode[0].'_catalogue.lft asc',
	        ], TRUE);
	        $url = '';
	        foreach($allCategory as $key => $val){
	            $url = $url.$val['canonical'].(($key + 1 < count($allCategory)) ? '/' : '');
	        }

	    }else{
	        $category = $model->_get_where([
	            'select' => 'id, lft, rgt, parentid',
	            'table' => $moduleExplode[0].'_catalogue',
	            'where' => ['id' => $catid]
	        ]);
	        if($category['parentid'] != 0){
	        	$abc = $model->_get_where([
		            'select' => 'id, lft, rgt, parentid',
		            'table' => $moduleExplode[0].'_catalogue',
		            'where' => ['id' => $category['parentid']]
		        ]);
	        }
			$allCategory = $model->_get_where([
	            'select' => 'tb2.objectid, tb2.canonical, tb2.module',
	            'table' => $moduleExplode[0].'_catalogue as tb1',
	            'join' => [
	            	[
	            		$moduleExplode[0].'_translate as tb2', 'tb2.objectid = tb1.id AND tb2.language = \''.$lang.'\' AND tb2.module = \''.$moduleExplode[0].'_catalogue\'','inner'
	            	]
	            ],
	            'where' => [
	                'tb1.lft >=' => $abc['lft'],
	                'tb1.lft <=' => $category['lft'],
	                'tb1.rgt <=' => $abc['rgt'],
	                'tb1.rgt >=' => $category['rgt'],
	            ],
	            'order_by' => 'tb1.lft asc',
	        ], TRUE);
	        $url = '';

	        foreach($allCategory as $key => $val){
	        	if($val['canonical'] == $canonical){
	        		$url = $url.$val['canonical'].(($key + 1 < count($allCategory)) ? '/' : '');
	        		$canonical = '';
	        	}else{
	            	$url = $url.$val['canonical'].'/';
	        	}
	        }

	        $url = $url.$canonical;
	    }
	        // pre($url);
	    return $url;
	}
}


// helper
if (!function_exists('dt_menu_recursive')) {
	function dt_menu_recursive($param = [], $extend = []){
		$html = '';
		$class = isset($extend['class'])? $extend['class'] : 'dt_dropdown_main';
		$level = isset($extend['level'])? $extend['level'] : 0;
		$_class_subs = isset($extend['_class_subs'])? $extend['_class_subs'] : '';

		if(isset($param) && count($param) && is_array($param)){
			$html .= '<ul class="uk-list '.$class.' '.$_class_subs.'">';
				foreach ($param as $key => $val) {
					if (isset($val['level']) && $val['level'] > $level) {
						$_class_subs = 'subs';
					}
					$title = $val['title'];
					$href = write_url($val['canonical'], true, false);

					$flag_child = 0;
					if(isset($val['children']) && count($val['children']) && is_array($val['children'])){
						$flag_child = 1;
					}

					$html .= '<li style="position:relative;">';
						$not_child = ($flag_child == 0)? 'not-child' : '';
						$html .= '<a class="'.$not_child.'" href="'.$href.'" title="'.$title.'">'.$title.'</a>';
						if($flag_child == 1){
							$html .= '<span class="dt_menu_recursive_btn"><i class="fa fa-plus" aria-hidden="true"></i></span>';
							$html .= dt_menu_recursive($val['children'], [
								'class' => $class,
								'_class_subs' => $_class_subs,
							]);
						}
					$html .= '</li>';
				}
			$html .= '</ul>';
		}

		return $html;
	}
}

?>
