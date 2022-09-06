<?php
use App\Models\AutoloadModel;

if (! function_exists('get_panel')){
    function get_panel( $param = []){
        $model = new AutoloadModel();
        $object = $model->_get_where([
            'select' => 'tb1.keyword, tb2.title, tb2.description, tb1.module, tb1.catalogue, tb1.locate,tb1.id, tb1.type_data, tb2.canonical, tb1.image, tb1.time_end',
            'table' =>' panel as tb1',
            'join' => [
                [
                    'panel_translate as tb2', 'tb1.id = tb2.objectid AND tb2.language = \''.$param['language'].'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.locate' => $param['locate'],
                'tb1.deleted_at' => 0
            ],
            'order_by' => 'tb1.id asc'
        ],TRUE);
        if(isset($object) &&  is_array($object)  && count($object)){
            foreach ($object as $key => $value) {
                $module_explode = explode("_", $value['module']);
                $select_post  = '';
                $select_cat='';
                if($module_explode[0] == 'tour' || $module_explode[0] == 'product'){
                    $select_post = 'tb1.price, tb1.price_promotion';
                    // $select_cat = 'tb1.price, tb1.price_promotion';
                }
                if($module_explode[0] == 'tour'){
                    $select_post = $select_post . ', tb1.time_end, tb2.start_at, tb2.end_at,';
                    $select_cat = $select_cat.',tb3.time_end, tb2.start_at, tb2.end_at';
                }
                if(isset($module_explode[1]) && $module_explode[1] != ''){
                    $object[$key]['data'] = panel_catalogue([
                        'panel' => $object,
                        'object' => $value,
                        'select_cat' => $select_cat,
                        'module' => $module_explode,
                        'param' => $param,
                        'number' => $key
                    ]);
                }else if($value['module'] == '0'){
                    $object[$key]['data'] = [];
                }else{
                	$object[$key]['data'] = panel_post([
                        'panel' => $object,
                        'object' => $value,
                        'select_post' => $select_post,
                        'module' => $module_explode,
                        'param' => $param,
                        'number' => $key
                    ]);
                }
            }
        }

        return $object;
    }
}

if (! function_exists('panel_post')){
    function panel_post($param = []){
        $model = new AutoloadModel();
        $iframe = '';
        if($param['module'][0] == 'media'){
            $iframe = 'tb2.iframe, tb2.sub_title, tb2.sub_content';
        }
        if($param['module'][0] == 'product'){
            $param['select_post'] = $param['select_post'].',tb1.rate, tb2.type,tb2.info, tb1.bar_code, tb1.length, tb1. width';
        }
        if($param['module'][0] == 'article'){
            $param['select_post'] = $param['select_post'].',tb2.icon, tb1.video , tb2.sub_title, tb2.sub_content';
        }
        $param['object']['catalogue'] = json_decode($param['object']['catalogue']);
        $data = $model->_get_where([
            'select' => 'tb1.id, tb2.title,tb2.module, tb1.image, tb1.catalogueid,tb2.description,tb2.content,tb1.userid_created, tb1.album,'.$param['select_post'].$iframe.',  tb2.title, tb2.meta_description, tb1.created_at, tb2.canonical, tb4.title as cat_title, tb4.canonical as cat_canonical',
            'table' => $param['module'][0].' as tb1',
            'join' => [
                [
                    $param['module'][0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$param['param']['language'].'\' AND tb2.module = \''.$param['module'][0].'\'','inner'
                ],
                [
                    $param['module'][0].'_translate as tb4','tb4.module = \''.$param['module'][0].'_catalogue\' AND tb1.catalogueid = tb4.objectid AND tb4.language = \''.$param['param']['language'].'\'','inner'
                ],

            ],
            'where' => ['tb1.deleted_at' => 0, 'tb1.publish' => 1],
            'where_in_field' => 'tb1.id',
            'where_in' => $param['object']['catalogue'],
            // 'limit' => 8,
            'order_by' => 'tb1.order desc, tb1.created_at desc'
        ],TRuE);
         if(isset($data) &&  is_array($data)  && count($data)){
            foreach ($data as $keyData => $valData) {
                $data[$keyData]['album'] = json_decode($valData['album']);
                if(isset($data[$keyData]['image']) && $data[$keyData]['image'] != ''){
                    $data[$keyData]['avatar'] = $data[$keyData]['image'];
                }else{
                    $data[$keyData]['avatar'] = (isset( $data[$keyData]['album'][0]) ?  $data[$keyData]['album'][0] : '');
                }
            }
        }
        return $data;
    }
}

if (! function_exists('panel_catalogue')){
    function panel_catalogue($param = []){
        $model = new AutoloadModel();
        $type = json_decode($param['object']['type_data']);
        $data = [];
        if(isset($type[1]) && $type[1] != ''){
        	$data = post_and_cat($param);
        }
        if(!isset($type[1]) && $type[0] == 'only_cat'){
        	$data = only_cat($param);
        }
        if(!isset($type[1]) && $type[0] == 'only_post'){
        	$data = only_post($param);
        }
        if(!isset($type[1]) && $type[0] == 'normal'){
            $data = only_select_cat($param);
        }

        return $data;
    }
}


if (! function_exists('recursive')){
    function recursive($array = '', $parentid = 0){
        $temp = [];
        if(isset($array) && is_array($array) && count($array)){
            foreach($array as $key => $val){
                if($val['parentid'] == $parentid){
                    $temp[] = $val;
                    if(isset($temp) && is_array($temp) && count($temp)){
                        foreach($temp as $keyTemp => $valTemp){
                            $temp[$keyTemp]['children'] = recursive($array, $valTemp['id']);
                        }
                    }
                }
            }
        }

        return $temp;
    }
}

if (! function_exists('post_and_cat')){
    function post_and_cat($param = []){
        $model = new AutoloadModel();
        $data = only_cat($param);
        $id = [];
        foreach ($data as $key => $value) {
        	$id[$key] = $value['id'];
        	$data[$key]['post'] = [];
        }
        if($param['module'][0] == 'product'){
            $param['select_cat'] = $param['select_cat'].',tb3.rate, tb3.price, tb3.price_promotion, tb3.hot, tb2.info, tb3.bar_code, tb3.length, tb3. width, tb3.landing_link';
        }
        if($param['module'][0] == 'article'){
            $param['select_cat'] = $param['select_cat'].',tb2.sub_title, tb2.sub_content,';
        }

        $id_list = [];
        if(isset($data) && is_array($data) && count($data)){
            foreach($data as $key => $val){
                $id_list[] = $val['id'];
            }
        }
        $mang = $model->_get_where([
            'select' => 'tb1.catalogueid, tb3.id, tb2.module, '.$param['select_cat'].', tb2.title,tb2.description,  tb2.content, tb2.canonical, tb3.created_at, tb3.album, tb3.image, tb4.title as cat_title, tb4.canonical as cat_canonical, tb3.created_at',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    $param['module'][0].'_translate as tb2','tb2.module = \''.$param['module'][0].'\' AND tb2.objectid = tb1.objectid AND tb2.language = \''.$param['param']['language'].'\'','inner'
                ],
                [
                    $param['module'][0].' as tb3', 'tb1.objectid = tb3.id','inner'
                ],
                [
                    $param['module'][0].'_translate as tb4','tb4.module = \''.$param['module'][0].'_catalogue\' AND tb3.catalogueid = tb4.objectid AND tb4.language = \''.$param['param']['language'].'\'','inner'
                ],
            ],
            'where' => ['tb1.module' => $param['module'][0], 'tb3.deleted_at' => 0, 'tb3.publish' => 1],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'query' => '
                (
                    SELECT COUNT(*)
                    FROM '.$param['module'][0].' as t
                    WHERE tb3.catalogueid = t.catalogueid
                    AND tb3.id <= t.id AND tb3.deleted_at = 0
                ) <= 12
            ',
            'group_by' => 'tb3.id',
            'limit' => 100,
            'order_by' => 'tb3.order desc, tb3.created_at desc'
        ],TRuE);
        if(isset($mang) &&  is_array($mang)  && count($mang)){
            foreach ($mang as $keymang => $valmang) {
                $mang[$keymang]['album'] = json_decode($valmang['album']);
                if(isset($mang[$keymang]['image']) && $mang[$keymang]['image'] != ''){
                    $mang[$keymang]['avatar'] = $mang[$keymang]['image'];
                }else{
                    $mang[$keymang]['avatar'] = (isset($mang[$keymang]['album'][0]) ? $mang[$keymang]['album'][0] : '');
                }
            }
        }

        if(isset($data) && is_array($data) && count($data)){
            foreach ($data as $key => $value) {
                foreach ($mang as $keyMang => $valueMang) {
                    if($value['id'] == $valueMang['catalogueid']){
                        $data[$key]['post'][] = $valueMang;
                    }
                }
            }
        }
        
        return $data;
    }
}

if (! function_exists('only_post')){
    function only_post($param = []){
        $model = new AutoloadModel();
        $data = only_cat($param);
        foreach ($data as $key => $value) {
            $id[$key] = $value['id'];
            $data[$key]['post'] = [];
        }
        if($param['module'][0] == 'product'){
            $param['select_cat'] = $param['select_cat'].',tb3.rate ,tb3.hot ,tb3.price ,tb3.price_promotion, tb2.type, tb3.model, tb3.bar_code';
        }
        if($param['module'][0] == 'media'){
            $param['select_cat'] = $param['select_cat'].',tb2.iframe';
        }
        if($param['module'][0] == 'article'){
            $param['select_cat'] = $param['select_cat'].',tb2.icon, tb3.video, tb3.info, tb3.viewed';
        }
        $data = $model->_get_where([
            'select' => 'tb1.catalogueid, tb3.id, tb2.module, '.$param['select_cat'].', tb2.title,tb2.description, tb2.content, tb2.canonical, tb3.created_at, tb3.album, tb3.image, tb4.title as cat_title, tb4.canonical as cat_canonical, tb3.created_at',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    $param['module'][0].'_translate as tb2','tb2.module = \''.$param['module'][0].'\' AND tb2.objectid = tb1.objectid AND tb2.language = \''.$param['param']['language'].'\'','inner'
                ],
                [
                    $param['module'][0].' as tb3', 'tb1.objectid = tb3.id','inner'
                ],
                [
                    $param['module'][0].'_translate as tb4','tb4.module = \''.$param['module'][0].'_catalogue\' AND tb3.catalogueid = tb4.objectid AND tb4.language = \''.$param['param']['language'].'\'','inner'
                ],
            ],
            'where' => ['tb1.module' => $param['module'][0], 'tb3.deleted_at' => 0, 'tb3.publish' => 1],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'group_by' => 'tb3.id',
            'limit' => 12,
            'order_by' => 'tb3.order desc, tb3.created_at desc'
        ],TRuE);
        if(isset($data) &&  is_array($data)  && count($data)){
            foreach ($data as $keyData => $valData) {
                $data[$keyData]['album'] = json_decode($valData['album']);
                if(isset($data[$keyData]['image']) && $data[$keyData]['image'] != ''){
                    $data[$keyData]['avatar'] = $data[$keyData]['image'];
                }else{
                    $data[$keyData]['avatar'] = (isset($data[$keyData]['album'][0]) ? $data[$keyData]['album'][0] : '');
                }
            }
        }

        return $data;
    }
}

if (! function_exists('only_cat')){
    function only_cat($param = []){
        $model = new AutoloadModel();
        $param['object']['catalogue'] = json_decode($param['object']['catalogue']);
        $data = $model->_get_where([
            'select' => 'id, lft, rgt',
            'table' => $param['module'][0].'_catalogue',
            'where' => [
                'deleted_at' => 0
            ],
            'where_in_field' => 'id',
            'where_in' => $param['object']['catalogue'],
            'group_by' => 'id'
        ],TRuE);
        $query  =  query_get_cat($data);
        if(isset($param['module'][1]) && $param['module'][0] == 'product' && $param['module'][1] == 'catalogue'){
            $param['select_cat'].= 'tb1.landing_link';
        }
        $child = $model->_get_where([
            'select' => 'tb1.id,  tb2.title, tb2.canonical, tb1.image, tb2.description, tb2.icon, tb1.parentid, '.$param['select_cat'],
            'table' => $param['module'][0].'_catalogue as tb1',
            'join' =>[
                [
                    $param['module'][0].'_translate as tb2','tb2.module = \''.$param['module'][0].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$param['param']['language'].'\'','inner'
                ]
            ],
            'where' => [
            	'tb1.deleted_at' => 0,
            	'tb1.publish' => 1
            ],
            'query' =>  $query,
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.order desc, tb1.id asc'
        ],TRuE);
        if(isset($child) &&  is_array($child)  && count($child)){
            foreach ($child as $keyData => $valData) {
                if($child[$keyData]['image'] == ''){
                    $child[$keyData]['image'] = 'public/not-found.png';
                }
            }
        }
        return $child;
    }
}

if (! function_exists('only_select_cat')){
    function only_select_cat($param = []){
        $model = new AutoloadModel();
        $param['object']['catalogue'] = json_decode($param['object']['catalogue']);
        $data = $model->_get_where([
            'select' => 'id, lft, rgt',
            'table' => $param['module'][0].'_catalogue',
            'where' => [
                'deleted_at' => 0
            ],
            'where_in_field' => 'id',
            'where_in' => $param['object']['catalogue'],
            'group_by' => 'id'
        ],TRuE);
        $query = '';
        foreach ($data as $key => $value) {
            $query = $query.'( tb1.lft = \''.$value['lft'].'\' AND tb1.rgt = \''.$value['rgt'].'\' AND tb1.deleted_at = 0)';
            if($key < count($data)-1){
                $query = $query.' OR ';
            }
        }

        $child = $model->_get_where([
            'select' => 'tb1.id,  tb2.title, tb2.canonical, tb1.image, tb1.created_at, tb2.description, tb1.parentid, tb2.icon ',
            'table' => $param['module'][0].'_catalogue as tb1',
            'join' =>[
                [
                    $param['module'][0].'_translate as tb2','tb2.module = \''.$param['module'][0].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$param['param']['language'].'\'','inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'query' =>  $query,
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.order desc, tb1.id asc'
        ],TRuE);

        if(isset($child) &&  is_array($child)  && count($child)){
            foreach ($child as $keyData => $valData) {
                if($child[$keyData]['image'] == ''){
                    $child[$keyData]['image'] = 'public/not-found.png';
                }
            }
        }
        return $child;
    }
}


if (! function_exists('query_get_cat')){
    function query_get_cat($param = []){
    	$query = '';
    	foreach ($param as $key => $value) {
    		$query = $query.'( tb1.lft >= \''.$value['lft'].'\' AND tb1.rgt <= \''.$value['rgt'].'\' AND tb1.deleted_at = 0)';
    		if($key < count($param)-1){
    			$query = $query.' OR ';
    		}
    	}
        return $query;
    }
}


?>
