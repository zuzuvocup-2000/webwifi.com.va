<?php
use App\Models\AutoloadModel;

if (! function_exists('get_slide')){
	function get_slide($param = []){
		$model = new AutoloadModel();
        $keyword = [];
        $where = [
            'tb1.deleted_at' => 0,
        ];
        if(isset($param['keyword']) && is_array($param['keyword']) && count($param['keyword'])){
            $keyword = $param['keyword'];
        }else if(isset($param['keyword']) && $param['keyword'] != ''){
            $where['tb1.keyword'] = $param['keyword'];
        }
	 	$catalogue = $model->_get_where([
            'select' => 'tb4.id, tb1.keyword, tb2.title as cat_title, tb3.title, tb3.canonical, tb3.alt, tb3.description,tb2.description as cat_description, tb3.content, tb4.image',
            'table'    => 'slide_catalogue as tb1',
            'join' => [
                [
                   'slide_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "slide_catalogue" AND tb2.language = \''.$param['language'].'\' ', 'inner'
                ],
                [
                    'slide_translate as tb3', 'tb1.id = tb3.catalogueid AND tb3.module = "slide" AND tb3.language = \''.$param['language'].'\'', 'inner'
                ],
                [
                    'slide as tb4', 'tb4.id = tb3.objectid', 'inner'
                ]
            ],
            'where'    => $where,
            'where_in' => $keyword,
            'where_in_field' => 'tb1.keyword',
            'group_by' => 'tb4.id'
        ],true);
        $object = [];
        if(isset($catalogue) &&  is_array($catalogue)  && count($catalogue)){
            if(isset($param['keyword']) && is_array($param['keyword']) && count($param['keyword'])){
                foreach ($param['keyword'] as $key => $value) {
                    foreach ($catalogue as $keyChild => $valueChild) {
                        if($valueChild['keyword'] == $value){
                            $object[$value][] = $valueChild;
                        }
                    }
                }
            }else if(isset($param['keyword']) && $param['keyword'] != ''){
                $object = $catalogue;
            }
        }
        // if(isset($catalogue) &&  is_array($catalogue)  && count($catalogue)){
        //     switch ($param['output']){
        //         case 'html':
        //             switch ($param['type']){
        //                 case 'uikit':
        //                     return render_slideshow_uikit($catalogue);
        //             }
        //             break;
        //         case 'json':
        //             return json_encode($catalogue);
        //             break;
        //         case 'array':
        //             return $catalogue;
        //             break;
        //         default:
        //             return $catalogue;
        //             break;
        //     }
        // }
	 	return $object;
	}
}

if (! function_exists('render_quantity_btn')){
    function render_quantity_btn($id = ''){
        $html = '';
        $html = $html.'<div class="soluong soluong_type_1 show">';
            $html = $html.'<label class="section margin-bottom-10">Số lượng:</label>';
            $html = $html.'<div class="custom input_number_product custom-btn-number form-control">';
                $html = $html.'<button class="btn_num num_1 button button_qty" onclick="var result = document.getElementById(\''.$id.'\'); var qtypro = result.value; if( !isNaN( qtypro ) &amp;&amp; qtypro > 1 ) result.value--;return false;" type="button">';
                    $html = $html.'<i class="fa fa-minus-circle"></i>';
                $html = $html.'</button>';
                $html = $html.'<input type="text" id="'.$id.'" name="quantity" value="1" maxlength="3" class="form-control prd_quantity" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" onchange="if(this.value == 0)this.value=1;">';
                $html = $html.'<button class="btn_num num_2 button button_qty" onclick="var result = document.getElementById(\''.$id.'\'); var qtypro = result.value; if( !isNaN( qtypro )) result.value++;return false;" type="button">';
                    $html = $html.'<i class="fa fa-plus-circle"></i>';
                $html = $html.'</button>';
            $html = $html.'</div>';
        $html = $html.'</div>';
        return $html;
    }
}


if (! function_exists('render_cart_btn')){
    function render_cart_btn($id = ''){
        $html = '';
        $html = $html .'<div class="button_actions uk-clearfix">';
            $html = $html .'<button type="submit" class="btn btn_base normal_button add-cart" data-sku="SKU_'.$id.'">';
                $html = $html .'<span class="text_1">
					<i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng <br>
					<span class="uk-text-center">Cam kết giao hàng tận nơi trên toàn quốc</span>
				</span>';

            $html = $html .'</button>';
        $html = $html .'</div>';
        return $html;
    }
}

if (! function_exists('check_voucher')){
    function check_voucher(){
        $price = 0;
        if(isset($_COOKIE['voucher']) && $_COOKIE['voucher'] != ''){
            $voucher = check_login_voucher($_COOKIE['voucher']);
            if(isset($voucher['count_member']) && $voucher['count_member'] > 0){
                $voucher = [];
            }else{
                $price = $voucher['price'];
            }
        }
        return $price;
    }

    function check_login_voucher($voucherid = ''){
        $memberCookie = (isset($_COOKIE['HTVIETNAM_member'])) ? json_decode($_COOKIE['HTVIETNAM_member'], TRUE) : '';
        $model = new AutoloadModel();
        if(isset($memberCookie) && is_array($memberCookie) && count($memberCookie)){
            $voucher = $model->_get_where([
                'select' => 'id, title, price, max, voucherid, publish,(SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill, (SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid AND bill.member_id = \''.$memberCookie['id'].'\') as count_member',
                'table' => 'voucher',
                'where' => ['voucherid' => $voucherid,'deleted_at' => 0,'publish' => 1]
            ]);
        }else{
            $voucher = $model->_get_where([
                'select' => 'id, title, price, max, voucherid, publish,(SELECT COUNT(id) FROM bill WHERE voucher.voucherid = bill.voucherid) as count_bill',
                'table' => 'voucher',
                'where' => ['voucherid' => $voucherid,'deleted_at' => 0,'publish' => 1]
            ]);
        }

        return $voucher;
    }
}

if(!function_exists('logo')){
    function logo(){
        $model = new AutoloadModel();
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $system = get_general();
        if($actual_link == BASE_URL){
            $logo = '<h1 class="hd-logo" ><a href="." title="'.$system['seo_meta_title'].'"><img src="'.$system['homepage_logo'].'" alt="'.$system['seo_meta_title'].'"  class="lazyloading" /></a><span class="uk-hidden">'.$system['seo_meta_title'].'</span></h1>';
        }else{
            $logo = '<div class="hd-logo" ><a  href="." title="'.$system['seo_meta_title'].'"><img src="'.$system['homepage_logo'].'" alt="'.$system['seo_meta_title'].'" class="lazyloading" /></a></div>';
        }
        return $logo;
    }
}



if (! function_exists('get_general')){
    function get_general($lang = 'vi' ){
        $model = new AutoloadModel();
        $object = $model->_get_where([
           'select' => 'keyword, content',
            'table' => 'system_translate',
            'where' => ['language' => $lang]
        ],TRUE);
        $data= [];
        if(isset($object) &&  is_array($object)  && count($object)){
            foreach ($object as $key => $value) {
                $data[$value['keyword']] = $value['content'];
            }
        }

        return $data;
    }
}

if (! function_exists('explode_price')){
    function explode_price($price = ''){
        $explode = explode(',', $price);
        $data = [];
        foreach ($explode as $key => $value) {
            $price_explode = explode('-', $value);
            $data[$key]['start'] = $price_explode[0];
            $data[$key]['end'] = $price_explode[1];
            $data[$key]['value'] = $value;
        }
        return $data;
    }
}

if(!function_exists('convertPrice')){
    function convertPrice($price = ''){
        $price = (int)$price;
        $ty = ($price / 1000000000);
        if($ty >= 1){
            return round($ty, 1).' tỷ';
        }
        $tramtrieu = ($price / 100000000);
        if($tramtrieu >= 1){
            return round($tramtrieu).' trăm triệu';
        }
        $chuctrieu = ($price / 10000000);
        if($chuctrieu >= 1){
            return round($tramtrieu).' mươi triệu';
        }
        $trieu = ($price / 1000000);
        if($trieu >= 1){
            return round($trieu).' triệu';
        }
        $trieu = ($price / 100000);
        if($trieu >= 1){
            return round($trieu).' trăm';
        }
        return $price;
    }
}

if(!function_exists('convertPriceNumber')){
    function convertPriceNumber($price = ''){
        $price = (int)$price;
        $ty = ($price / 1000000000);
        if($ty >= 1){
            return round($ty, 1).'.000.000.000';
        }
        $tramtrieu = ($price / 100000000);
        if($tramtrieu >= 1){
            return round($tramtrieu).'00.000.000';
        }
        $chuctrieu = ($price / 10000000);
        if($chuctrieu >= 1){
            return round($chuctrieu).'0.000.000';
        }
        $trieu = ($price / 1000000);
        if($trieu >= 1){
            return round($trieu).'.000.000';
        }
        $tram = ($price / 100000);
        if($tram >= 1){
            return round($tram).'00.000';
        }
        return $price;
    }
}


if (! function_exists('menu_header')){
    function menu_header($lang = ''){
        $menu_header = get_menu([
            'keyword' => 'header_home',
            'language' => $lang,
            'output' => 'array'
        ]);
        return $menu_header;
    }
}
if (! function_exists('location')){
    function location($lang = '', $keyword = ''){
        $model = new AutoloadModel();
         $flag = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.keyword',
            'table' => 'location_catalogue as tb1',
            'join' => [
                [
                    'location_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "location_catalogue" AND tb2.language = \''.$lang.'\' AND tb2.attribute = \''.$keyword.'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0
            ],
            'order_by' => 'tb2.id asc'
        ],TRUE);
        return $flag;
    }
}
if (! function_exists('get_all_catalogue')){
    function get_all_catalogue($param = []){
        $model = new AutoloadModel();
        $module_extract = explode("_", $param['module']);
        $flag = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.canonical',
            'table' => $param['module'].' as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\' AND tb2.language = \''.$param['language'].'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0
            ],
            'order_by' => 'tb1.parentid asc'
        ],TRUE);
        return $flag;
    }
}

if (! function_exists('brand')){
    function brand($lang = ''){
        $model = new AutoloadModel();
         $flag = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.keyword',
            'table' => 'brand as tb1',
            'join' => [
                [
                    'brand_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "brand" AND tb2.language = \''.$lang.'\' ', 'inner'
                ]
            ],
            'order_by' => 'tb2.title asc'
        ],TRUE);
        return $flag;
    }
}

if (! function_exists('attribute')){
    function attribute($lang = ''){
        $model = new AutoloadModel();
        $module = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb2.canonical',
            'table' => 'attribute_catalogue as tb1',
            'join' => [
                [
                    'attribute_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "attribute_catalogue"  AND tb2.language = \''.$lang.'\'', 'inner'
                ],
            ],
            'order_by' => 'tb2.id asc'
        ],TRUE);
        $flag = [];
        foreach ($module as $key => $value) {
            array_push($flag,$value['id']);
        }

        $data = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb1.catalogueid',
            'table' => 'attribute as tb1',
            'join' => [
                [
                    'attribute_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "attribute" AND tb2.language = \''.$lang.'\'', 'inner'
                ],
            ],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $flag,
            'order_by' => 'tb2.id asc'
        ],TRUE);
        $get = [];
        foreach ($module as $key => $value) {
            $dem = 0;
            foreach ($data as $keyChild => $valChild) {
                if($value['id'] == $valChild['catalogueid']){
                    $module[$key]['child'][$dem]['id'] = $valChild['id'];
                    $module[$key]['child'][$dem]['title'] = $valChild['title'];
                    $dem++;
                }
            }
        }

        return $module;
    }
}


if (! function_exists('slide')){
    function slide($lang = ''){
       $slide_banner = get_slide([
            'keyword' => 'slide-banner',
            'language' => $lang,
            'output' => 'html',
            'type' => 'uikit',
            'limit' => 1
        ]);

        return $slide_banner;
    }
}

if (! function_exists('widget_frontend')){
    function widget_frontend(){
        $model = new AutoloadModel();
        $object = $model->_get_where([
            'select' => 'id, html, css, script, title, keyword',
            'table' => 'website_widget',
        ],TRUE);
        if(isset($object) &&  is_array($object)  && count($object)){
            foreach ($object as $key => $value) {
                $object[$key]['css'] = base64_decode($value['css']);
                $object[$key]['html'] = base64_decode($value['html']);
                $object[$key]['script'] = base64_decode($value['script']);
            }
        }
        return $object;
    }
}

if (! function_exists('get_menu')){
    function get_menu($param = []){
        $model = new AutoloadModel();
        $catalogue = $model->_get_where([
            'select' => ' tb1.id,tb1.value, tb1.title as titleCatalogue',
            'table' => 'menu_catalogue as tb1',
            'where' => [
                'tb1.deleted_at' => 0
            ]
        ],TRUE);
        if(isset($catalogue) && is_array($catalogue)   && count($catalogue)){
            $menu = $model->_get_where([
                'select' => ' tb1.id, tb1.catalogueid, tb1.parentid, tb1.lft, tb1.rgt, tb1.level, tb1.order, tb2.title,tb2.objectid, tb2.canonical, tb2.catalogueid as dataid, tb1.type',
                'table' => 'menu as tb1',
                'join' => [
                    [
                        'menu_translate as tb2','tb1.id = tb2.objectid AND tb2.language = \''.$param['language'].'\' ','inner'
                    ]
                ],
                'order_by' => 'order desc'
            ], TRUE);

            $data = [];

            foreach ($catalogue as $key => $value) {
                $data[$value['id']] = ['title' => $value['titleCatalogue'],'keyword' =>  $value['value']];
            }
            if(isset($data) && is_array($data) && count($data)){
                foreach ($data as $key => $value) {
                    $data[$key]['data'] = [];
                    foreach ($menu as $keyMenu => $valMenu) {
                        if($valMenu['catalogueid'] == $key){
                            $new = array_push($data[$key]['data'], $valMenu);
                        }
                    }
                }

                foreach ($data as $key => $value) {
                    $data[$key]['data'] = menu_recursive($value['data']);
                }
                $select = [];
                foreach ($data as $key => $value) {
                    if($value['keyword'] == $param['keyword']){
                        $select = $value;
                    }
                }
                switch ($param['output']){
                    case 'html':
                        return render_menu_frontend($select['data']);
                        break;
                    case 'json':
                        return json_encode($select);
                        break;
                    case 'array':
                        return $select;
                        break;
                    default:
                        return $select;
                        break;
                }
            }
        }else{
            return $catalogue;
        }
    }
}

if (! function_exists('menu_recursive')){
    function menu_recursive($array = '', $parentid = 0){
        $temp = [];
        if(isset($array) && is_array($array) && count($array)){
            foreach($array as $key => $val){
                if($val['parentid'] == $parentid){
                    $temp[] = $val;
                    if(isset($temp) && is_array($temp) && count($temp)){
                        foreach($temp as $keyTemp => $valTemp){
                            $temp[$keyTemp]['children'] = menu_recursive($array, $valTemp['id']);
                        }
                    }

                }
            }
        }
        return $temp;
    }
}

if (! function_exists('list_tag')){
    function list_tag($array = []){
        $model = new AutoloadModel();
        $temp = [];
        $tags = $model->_get_where([
            'select' => '*',
            'table' => 'tag_relationship',
            'where' => [
                'module' => $array['module'],
                'language' => $array['language'],
                'keyword !=' => '',
            ],
            'limit' => $array['limit'],
            'group_by' => 'keyword'
        ],true);
        return $tags;
    }
}

if (! function_exists('mega_menu')){
    function mega_menu($param = []){
        $model = new AutoloadModel();
        $temp = [];
        $module_extract = explode("_", $param['module']);
        $data = $model->_get_where([
            'select' => 'tb1.id, tb2.title, tb1.parentid, tb1.level, tb1.lft, tb1.rgt, tb2.canonical, tb1.image, tb1.icon',
            'table' => $param['module'].' as tb1',
            'join' =>  [
                [
                    $module_extract[0].'_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$param['module'].'\'   AND tb2.language = \''.$param['language'].'\' ','inner'
                ],
            ],
            'where' => [
                'tb1.deleted_at' => 0,
            ],
            'order_by' => 'tb1.order desc, tb2.title asc'
        ],true);
        $menuList = menu_recursive($data);
        return $menuList;
    }
}

if (! function_exists('render_img')){
    function render_img($param = []){
        return '<img data-src="'.$param['src'].'" src="public/loading.svg" class="lazyloading '.(isset($param['class']) ? $param['class'] : '').'" alt="'.((!isset($param['alt'])) ? $param['src'] : $param['alt']).'" '.(isset($param['attr']) ? $param['attr'] : '').'>';
    }
}


if (! function_exists('render_a')){
    function render_a($url = '', $title='', $attr = '', $child = ''){
        return '<a href="'.$url.'" title="'.(($title =='') ? $url : $title).'" '.$attr.'>'.$child.'</a>';
    }
}

if (! function_exists('cal_quantity')){
    function cal_quantity($price = '', $quantity=''){
        $new_price = $price * $quantity;
        return $new_price ;
    }
}

if (! function_exists('product_data')){
    function product_data($param = []){
        $model = new AutoloadModel();
        $module_extract = explode("_", $param['module']);
        $detailCatalogue = $model->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description',
            'table' => $module_extract[0].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                // 'tb1.id' => $param['id']
            ]
        ]);
        // PRe($detailCatalogue);
        $child = $model->_get_where([
            'select' => 'tb1.id,  tb2.title, tb2.canonical, tb1.lft, tb1.rgt, tb1.level, tb1.parentid',
            'table' => $module_extract[0].'_catalogue as tb1',
            'join' =>[
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'','inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.lft >=' => $detailCatalogue['lft'],
                'tb1.rgt <=' => $detailCatalogue['rgt'],
            ],
            'group_by' => 'tb1.id',
            'order_by' => 'tb1.lft asc'
        ],TRuE);
        $result = $this->recursive_catalogue($child);
        $id = [];
        if(isset($child) &&  is_array($child)  && count($child)){
            foreach ($child as $keyData => $valData) {
                $child[$keyData]['canonical'] = fix_canonical(slug($valData['canonical']));
            }
            foreach ($child as $keyData => $valData) {
                array_push($id,$valData['id']);
                $child[$keyData]['post'] = [];
            }
        }
        $data = $model->_get_where([
            'select' => 'tb1.catalogueid, tb3.id, tb3.price, tb3.price_promotion, tb2.title,tb2.description, tb2.content, tb2.canonical, tb3.album, tb3.image',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'\' AND tb2.objectid = tb1.objectid AND tb2.language = \''.$this->currentLanguage().'\'','inner'
                ],
                [
                    $module_extract[0].' as tb3', 'tb1.objectid = tb3.id','inner'
                ]
            ],
            'where' => ['tb1.module' => $module_extract[0]],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'group_by' => 'tb3.id',
            'order_by' => 'tb3.created_at desc'
        ],TRuE);
        $array = $this->product_recursive($result, $data);
        return $array;
    }
}

if (! function_exists('recursive_catalogue')){

    function recursive_catalogue($param = [], $parentid = 0){
        $data = [];
        // prE($param);
        if(isset($param) && is_array($param) && count($param)){
            foreach ($param as $key => $value) {
                if($value['parentid'] == $parentid){
                    $data[] = $value;
                    if(isset($data) && is_array($data) && count($data)){
                        foreach($data as $keydata => $valdata){
                            $data[$keydata]['child'] = $this->recursive_catalogue($param, $valdata['id']);
                        }
                    }
                }
            }
        }
        // print_r($data);

        return $data;
    }
}
if (! function_exists('product_recursive')){

    function product_recursive($catalogue = [], $product = []){
        $data = [];
        foreach ($catalogue as $key => $value) {
            $catalogue[$key]['data'] =[];
            foreach ($product as $keyProduct => $valueProduct) {
                if($value['id'] == $valueProduct['catalogueid']){
                    array_push( $catalogue[$key]['data'],$valueProduct);
                    $catalogue[$key]['child'] = $this->product_recursive($value['child'],$product);
                }
            }
        }

        return $catalogue;
    }
}

if (! function_exists('get_system')){

    function get_system(){
        $model = new AutoloadModel();
        $system = $model->_get_where([
            'select' => 'keyword, content, module',
            'table' => 'website_system'
        ], TRUE);
        $temp = [];
        if(isset($system) && is_array($system) && count($system)){
            foreach ($system as $key => $value) {
                $system[$key]['content'] = base64_decode($value['content']);
            }
            foreach($system as $key => $val){
                $temp[$val['keyword']] = $system[$key];
            }
        }
        return $temp;
    }
}

function jam_read_num_forvietnamese( $num = false ) {
    $str = '';
    $num  = trim($num);

    $arr = str_split($num);
    $count = count( $arr );

    $f = number_format($num);
       //KHÔNG ĐỌC BẤT KÌ SỐ NÀO NHỎ DƯỚI 999 ngàn
    if ( $count < 7 ) {
        $str = $num;
    } else {
        // từ 6 số trở lên là triệu, ta sẽ đọc nó !
        // "32,000,000,000"
        $r = explode(',', $f);
        switch ( count ( $r ) ) {
            case 4:
                $str = $r[0] . ' tỷ';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' Tr'; }
            break;
            case 3:
                $str = $r[0] . ' Triệu';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' nghìn'; }
            break;
        }
    }
    return ( $str );
}

?>
