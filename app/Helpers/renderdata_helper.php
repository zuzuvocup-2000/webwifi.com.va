<?php
use App\Models\AutoloadModel;


if (! function_exists('render_menu_frontend')){
    function render_menu_frontend(array $param = [], $child = false){
        $html = '';
        if($child == false){
            $html = '<ul class="uk-navbar-nav uk-clearfix main-menu">';
        }
        if(isset($param) && is_array($param) && count($param)){
            foreach ($param as $key => $val) {
                $active = false;
                $class = '';
                $canonical = str_replace('.html', '', $_SERVER['REQUEST_URI']);
                $canonical_explode = explode('/',$canonical);
                if($val['canonical'] == 'trang-chu' || $val['canonical'] == 'home' || $val['canonical'] == ''){
                    $canonical = '.';
                    $val['canonical'] = '';
                }else{
                    $canonical = $val['canonical'];
                }

                if($canonical_explode[1] == $val['canonical']) $active = true;

                if($val['children'] != []){
                    $active = recursive_active($val['children'], $canonical_explode[1]);
                }
                $html = $html.'<li class=" main-menu-item  '.($active == true ? 'selected' : '').'">';
                $html = $html.'<a href="'.$canonical.'" '.($val['children'] != [] ? '' : '').' title="'.$val['title'].'">'.$val['title'].'</a>';
                if($val['level'] >= 2){
                    $class = 'css_submenu';
                }
                if($val['children'] != []){
                    $html = $html.'<div class="dropdown-menu '.$class.'">';
                        $html = $html.'<ul class="uk-list sub-menu">';
                            $html = $html.render_menu_frontend($val['children'], true);
                        $html = $html.'</ul>';
                    $html = $html.'</div>';
                }

            }
        }
        if($child == false){
            $html = $html.'</ul>';
        }
        return $html;
    }
}

if (! function_exists('recursive_active')){
    function recursive_active(array $param = [], $canonical = ''){
        $active = false;
        if(isset($param) && is_array($param) && count($param)){
            foreach ($param as $key => $value) {
                if($canonical == $value['canonical']) return true;
                if($value['children'] != []){
                    $active = recursive_active($value['children'], $canonical);
                }
            }
        }
        return $active;
    }
}

if (! function_exists('render_menu_mobile')){
    function render_menu_mobile(array $param = [], $child = false, $count = 1){
        $html = '';
        if($child == false){
            $html = '<ul class="l'.$count.' uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>';
        }
        if(isset($param) && is_array($param) && count($param)){
            foreach ($param as $key => $val) {
                $class = 'uk-parent uk-position-relative';
                $html = $html.'<li class="l'.$count.' '.($val['children'] != [] ? $class : '').'">';
                if($val['children'] != []){
                    $html = $html.'<a href="#" title="'.$val['title'].'" class="dropicon"></a>';
                }
                    $html = $html.'<a href="'.$val['canonical'].'" title="'.$val['title'].'" class="l'.$count.'">'.$val['title'].'</a>';
                    if($val['children'] != []){
                        $dem = $count+1;
                        $html = $html.'<ul class="l'.$dem.' uk-nav-sub">';
                            $html = $html.render_menu_frontend($val['children'], true, $count + 1);
                         $html = $html.'</ul>';
                }
                    $html = $html.'</li>';
            }
        }
        if($child == false){
            $html = $html.'</ul>';
        }
        return $html;
    }
}

if (! function_exists('render_slideshow_uikit')){
    function render_slideshow_uikit(array $param = []){
        $html = '';
        if(isset($param) && is_array($param) && count($param)){
            $html = $html.'<div class="uk-slidenav-position" data-uk-slideshow="{autoplay:true}">';
                $html = $html.'<ul class="uk-slideshow"  >';
                    foreach ($param as $key => $value) {
                        $html = $html.'<li><a href="'.$value['canonical'].'" title="'.$value['title'].'" class="img-cover"><img src="'.$value['image'].'" alt="'.(($value['title'] != '') ? $value['title'] : $value['image']).'"></a></li>';
                    }
                $html = $html.'</ul>';
                $html = $html.'<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>';
                $html = $html.'<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>';
            $html = $html.'</div>';
        }
        return $html;
    }
}

if (! function_exists('render_video_modal')){
    function render_video_modal(array $param = []){
        $html = '';
        if(isset($param) && is_array($param) && count($param)){
            $html = $html.'<div class="video-item">';
                $html = $html.'<div class="video-content">';
                    $html = $html.'<div class="video-pic img-cover">';
                        $html = $html.'<img src="'.$param['image'].'" alt="'.$param['title'].'">';
                         $html = $html.'<a class="play btn-modal-iframe" href="#video-modal" data-iframe="'.base64_encode($param['iframe']).'" data-uk-modal>';
                            $html = $html.'<i class="fa fa-play" aria-hidden="true"></i>';
                        $html = $html.'</a>';
                    $html = $html.'</div>';
                $html = $html.'</div>';
            $html = $html.'</div>';
        }
        return $html;
    }
}

if (! function_exists('render_modal_by_video')){
    function render_modal_by_video(){
        $html = '';
        $html = $html.'<div id="video-modal" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll;">';
            $html = $html.'<div class="uk-modal-dialog">';
                $html = $html.'<a href="" class="uk-modal-close uk-close"></a>';
                $html = $html.'<div class=" modal-iframe">';
                $html = $html.'</div>';
            $html = $html.'</div>';
        $html = $html.'</div>';
        return $html;
    }
}


?>
