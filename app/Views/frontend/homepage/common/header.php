<?php
	$currentDay = date('Y-m-d H:i:s');
	$cookie  = [];
    if(isset($_COOKIE[AUTH.'member'])) $cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
    $model = new App\Models\AutoloadModel();
    $product_catalogue = $model->_get_where([
        'select' => 'tb1.id, tb2.title, tb1.parentid, tb1.lft, tb1.rgt, tb1.level, tb1.order, tb2.canonical, tb1.image',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
            'tb1.level <=' => 3,
        ],
        'table' => 'product_catalogue as tb1',
        'join' => [
            [
                'product_translate as tb2','tb2.module = "product_catalogue" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.order desc, tb2.title'
    ], true);
    $list_catalogue = [];
    if(isset($product_catalogue) && is_array($product_catalogue) && count($product_catalogue)){
        foreach($product_catalogue as $key => $val){
            if($val['level'] == 1){
                $list_catalogue[] = $val;
                unset($product_catalogue[$key]);
            }
        }
    }

    if(isset($product_catalogue) && is_array($product_catalogue) && count($product_catalogue)){
        foreach($product_catalogue as $key => $val){
            foreach($product_catalogue as $keyChild => $valChild){
                if($valChild['parentid'] == $val['id']){
                    $product_catalogue[$key]['children'][] = $valChild;
                    unset($product_catalogue[$keyChild]);
                }
            }
        }
    }

    if(isset($list_catalogue) && is_array($list_catalogue) && count($list_catalogue)){
        foreach($list_catalogue as $key => $val){
            if(isset($product_catalogue) && is_array($product_catalogue) && count($product_catalogue)){
                foreach($product_catalogue as $keyChild => $valChild){
                    if($valChild['parentid'] == $val['id']){
                        $list_catalogue[$key]['children'][] = $valChild;
                        unset($product_catalogue[$keyChild]);
                    }
                }
            }
        }
    }
    $cart = \Config\Services::cart();
    $cartTotal = $cart->contents();
?>
<?php $main_nav = get_menu(array('keyword' => 'main-menu','language' => 'vi', 'output' => 'array')); ?>

<?php if(isset($general['homepage_banner_hd']) && !empty($general['homepage_banner_hd'])){ ?>
<div class="global-header-banner">
    <div class="container">
        <a href="" class="img-scaledown"><img src="<?php echo $general['homepage_banner_hd'] ?>" alt="banner" width="1" height="1" class="w-auto h-auto" /></a>
    </div>
</div>
<?php } ?>

<div class="global-header-container other-page">
    <div class="global-header-top-group bg-grey text-13 font-300">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="global-header-left">
                <a href="" class="icons icon-home"></a>
                <?php if(isset($main_nav['data']) &&  is_array($main_nav['data']) && count($main_nav['data'])){
                    foreach ($main_nav['data'] as $value) {
                 ?>
                <a href="<?php echo $value['canonical'] ?>"><?php echo $value['title'] ?></a>
                <?php }} ?>
            </div>

            <div class="global-header-right">
                <a href="tel:<?php echo $general['contact_phone_mb'] ?>"> <i class="icons icon-headphone"></i> <span>Hà Nội:</span> <b><?php echo $general['contact_phone_mb'] ?></b> </a>

                <a href="tel:<?php echo $general['contact_phone_mn'] ?>"> <i class="icons icon-headphone"></i> <span>Hồ Chí Minh:</span> <b><?php echo $general['contact_phone_mn'] ?></b> </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="global-header-middle-group d-flex flex-wrap align-items-center">
            <a href="" class="header-logo">
                <img src="<?php echo $general['homepage_logo'] ?>" alt="<?php echo $general['homepage_company'] ?>" width="196" height="62" />
            </a>

            <div class="header-search-group position-relative">
                <form method="get" action="/tim-kiem" name="search" class="bg-white d-block position-relative">
                    <input type="text" id="js-seach-input" name="keyword" placeholder="Nhập từ khóa tìm kiếm ..." value="" autocomplete="off" class="text-search" />

                    <button type="submit" class="btn-search icons"></button>
                </form>

                <div class="autocomplete-suggestions"><!-- // search-holder --></div>
            </div>

            <div class="header-right-group">
                <a href="tin-tuc" class="mr30">
                    <i class="icons icon-news"></i>
                    <span>Tin tức</span>
                </a>

                <!-- <a href="taikhoan">
                    <i class="icons icon-user"></i>
                    <span>Tài khoản</span>

                    <b class="text-capitalize"></b>
                </a> -->

                <a href="gio-hang">
                    <i class="icon-cart">
                        <span class="cart-count js-cart-count"><?php echo count($cartTotal); ?></span>
                    </i>
                    <span>Giỏ hàng</span>
                </a>
            </div>
        </div>

        <div class="global-header-bottom-group d-flex flex-wrap align-items-center">
            <div class="header-menu-group">
                <p class="title"><i class="icons icon-menu"></i>DANH MỤC SẢN PHẨM</p>
                <?php if(isset($list_catalogue) && is_array($list_catalogue) && count($list_catalogue)){ ?>
                    <div class="menu-list">
                        <?php foreach ($list_catalogue as $value) { ?>
                            <div class="item">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="cat-1" title="<?php echo $value['title'] ?>">
                                    <i class="cat-thum lazy" data-bg="url(<?php echo $value['image'] ?>)"></i>
                                    <span class="cat-title"><?php echo $value['title'] ?></span>
                                </a>
                                <?php if(isset($value['children']) && is_array($value['children']) && count($value['children'])){ ?>
                                    <div class="sub-menu">
                                        <?php foreach ($value['children'] as $valueChild) { ?>
                                            <div class="sub-item">
                                                <a href="<?php echo $valueChild['canonical'].HTSUFFIX ?>" class="cat-2"><?php echo $valueChild['title'] ?></a>
                                                <?php if(isset($valueChild['children']) && is_array($valueChild['children']) && count($valueChild['children'])){ ?>
                                                    <?php foreach ($valueChild['children'] as $valueSubChild) { ?>
                                                        <a href="<?php echo $valueSubChild['canonical'].HTSUFFIX ?>" class="cat-3"><?php echo $valueSubChild['title'] ?></a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="header-bottom-right font-300">
                <a href="tel:<?php echo $general['contact_phone_mn'] ?>">
                    <i class="icons icon-phone"></i>
                    <span class="text">Hotline TP.HCM: <b class="orange"><?php echo $general['contact_phone_mn'] ?></b></span>
                </a>

                <a href="tel:<?php echo $general['contact_phone_mb'] ?>">
                    <i class="icons icon-phone"></i>
                    <span class="text">Hotline Hà Nội: <b class="orange"><?php echo $general['contact_phone_mb'] ?></b></span>
                </a>

                <!-- <a href="san-pham-hot">
                    <i class="icons icon-fire"></i>
                    <span class="text">Khuyến mãi HOT</span>
                </a>

                <a href="deal">
                    <i class="icons icon-deal"></i>
                    <span class="text">Giờ vàng giá sốc</span>
                </a> -->
            </div>
        </div>
    </div>
</div>

<div class="global-header-block"></div>