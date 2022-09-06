<?php 
use App\Models\AutoloadModel;

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

if (! function_exists('render_menu_recursive')){
	function render_menu_recursive(array $param = [], $id = 0, $language = ''){
		$html = '';
		if(isset($param) && is_array($param) && count($param)){
			foreach ($param as $key => $val) {
				$html = $html.'<li class="dd-item" '.(($val['parentid'] == 0) ? 'style="position:relative;"' : '').' data-id="'.$val['objectid'].'">';
					$html = $html.'<div class="dd-handle va-handle">';
						$html = $html.'<span class="label label-info"><i class="fa fa-arrows"></i></span> ';
                        $html = $html.''.$val['title'].'';                                       
                    $html = $html.'</div>';
	                    $html = $html.'<span class="pull-right add-sub"> ';
		                    $html = $html.'<a style="font-weight:normal;font-size:12px;" href="'.base_url('backend/menu/menu/create/'.$id.'/'.$language.'/'.$val['id']).'" title="" class="">';
		                        $html = $html.'Quản lý menu con';
		                    $html = $html.'</a> ';
		                $html = $html.'</span>';
	                if($val['children'] != []){

	                	$html = $html.'<ol class="dd-list">';
	                		$html = $html.render_menu_recursive($val['children'], $id, $language);
	            		$html = $html.'</ol>';
	                }
                $html = $html.'</li>';
			}
		}
		return $html;
	}
}


?>

