<?php
if($detailCatalogue['level'] == 1){
    $model = new App\Models\AutoloadModel();
    $id_list[] = $detailCatalogue['id'];
    $productList = $model->_get_where([
        'select' => 'tb2.title, tb2.canonical, tb1.lft, tb1.rgt, tb1.parentid, tb1.level, tb1.id',
        'table' => 'product_catalogue as tb1',
        'join' => [
            [
                'product_translate as tb2','tb2.module = "product_catalogue" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'where' => ['lft >' => $detailCatalogue['lft'],'rgt <' => $detailCatalogue['rgt'], 'tb1.level' => 2, 'tb1.deleted_at' => 0, 'tb1.publish' => 1],
        'group_by' => 'tb1.id',
        'order_by' => 'tb2.title desc'
    ], TRUE);
    if(isset($productList) && is_array($productList) && count($productList)){
        foreach ($productList as $key => $value) {
            $id_list = [];
            $id_list[] = $value['id'];
            $productList[$key]['child'] = $model->_get_where([
                'select' => 'tb2.title, tb2.canonical, tb1.lft, tb1.rgt, tb1.parentid, tb1.level, tb1.id',
                'table' => 'product_catalogue as tb1',
                'join' => [
                    [
                        'product_translate as tb2','tb2.module = "product_catalogue" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
                    ]
                ],
                'where' => ['lft >' => $value['lft'],'rgt <' => $value['rgt'],  'tb1.deleted_at' => 0, 'tb1.publish' => 1],
                'group_by' => 'tb1.id',
                'order_by' => 'tb2.title desc'
            ], TRUE);
            if(isset($productList[$key]['child']) && is_array($productList[$key]['child']) && count($productList[$key]['child'])){
                foreach ($productList[$key]['child'] as $keyChild => $valueChild) {
                    $id_list[] = $valueChild['id'];
                }
            }

            $productList[$key]['data'] = $model->_get_where([
                'select' => 'tb1.id,tb1.viewed,tb1.hot, tb1.created_at ,tb1.productid, tb1.bar_code,tb1.model, tb1.image,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.module, tb3.description, tb3.content, tb1.model, tb1.bar_code, tb3.info, tb1.length, tb1.width, tb4.title as cat_title,tb4.canonical as cat_canonical,',
                'table' => 'product as tb1',
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1
                ],
                'where_in' => $id_list,
                'where_in_field' => 'tb1.catalogueid',
                'join' => [
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$language.'\' ','inner'
                    ],
                    [
                        'product_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "product_catalogue" AND tb4.language = \''.$language.'\' ','inner'
                    ]
                ],
                'group_by' => 'tb1.id',
                'limit' => 12,
                'order_by' => 'tb1.id desc'
            ], TRUE);
        }
    }
}
?>
<section class="bg-banner-top-new uk-position-relative bg-general" style="background-image: url(<?php echo $detailCatalogue['image'] ?>);">
    <div class="wrap-breadcum">
        <h2 class="heading-2 heading-cat-title">
            <?php echo $detailCatalogue['title'] ?>
        </h2>
        <ul class="uk-breadcrumb">
            <li>
                <a href="#" title=" Trang chủ"><i class="fa fa-home"></i> Trang chủ</a>
            </li>
            <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                foreach ($breadcrumb as $value) {
             ?>
                <li class=""><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
            <?php }} ?>
        </ul>
    </div>
</section>
<section id="body">
    <div id="prdcatalogue-page" class="page-body pt50 pb50">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-large-1-4 uk-visible-large">
                    <?php echo view('frontend/homepage/common/aside') ?>
                </div>
                <div class="uk-width-large-3-4">
                    <?php if($detailCatalogue['level'] == 1){ ?>
                        <?php if(isset($productList) && is_array($productList) && count($productList)){ 
                        foreach ($productList as $keyCatalogue => $valueCatalogue) {
                    ?>
                        <div class="medical-section-panel mb30">
                            <div class="medical-section-top mb30">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between uk-flex-wrap">
                                    <header class="medical-section-header">
                                        <h2 class="heading">
                                            <?php echo $valueCatalogue['title'] ?>
                                        </h2>
                                    </header>
                                    <div class="section-more">
                                        <a href="<?php echo $valueCatalogue['canonical'].HTSUFFIX ?>">
                                            Xem thêm
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="medical-section-body">
                                <div class="uk-grid uk-grid-small">
                                    <?php if(isset($valueCatalogue['data']) && is_array($valueCatalogue['data']) && count($valueCatalogue['data'])){
                                        foreach ($valueCatalogue['data'] as $value) {
                                    ?>
                                        <div class="uk-width-large-1-4 uk-width-1-2 mb10">
                                            <div class="medical-item product">
                                                <div class="item-pic">
                                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover product-media">
                                                        <img src="<?php echo $value['image'] ?>">
                                                    </a>
                                                    <div class="item-function">
                                                        <div class="uk-flex uk-flex-middle">
                                                            <div class="icon icon-img-action mr10">
                                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                                    <img src="public/eye.png" alt="" class="p10">
                                                                </a>
                                                            </div>
                                                            <div class="icon icon-img-action mr10">
                                                                <a class="buy_now" data-id="<?php echo $value['id'] ?>" data-sku="SKU_<?php echo $value['id'] ?>">
                                                                    <img src="public/cart.png" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="icon icon-img-action" >
                                                                <a  data-id="<?php echo $value['id'] ?>" class="btn-wishlist">
                                                                    <i class="d-icon-heart"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item-text">
                                                    <div class="product-title product-name mb5">
                                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="limit-line-3 ">
                                                            <?php echo $value['title'] ?> <?php echo (!empty($value['model']) ? ' - Model: '.$value['model'] : '') ?> <?php echo (!empty($value['bar_code']) ? ' - Hãng: '.$value['bar_code'] : '') ?><?php echo (!empty($value['made_in']) ? ' - '.$value['made_in'] : '') ?>
                                                        </a>
                                                    </div>
                                                    <div class="product-star mb5">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="product-contact mb10 product-price">
                                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                            <div class="prd-price uk-clearfix">
                                                                <span class="price-old uk-display-block "><?php echo empty($value['price_promotion']) ? '' : number_format(check_isset($value['price']),0,',','.').' VNĐ' ?></span>
                                                                <span class="price-new new-price"><?php echo (empty($value['price'] ) ? 'Liên hệ' : (!empty($value['price_promotion']) ? number_format(check_isset($value['price_promotion']),0,',','.').' VNĐ' : number_format(check_isset($value['price']),0,',','.').' VNĐ')) ?></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                    <?php }} ?>
                    <?php }else{ ?>
                        <div class="medical-section-panel mb30">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between mb30 uk-flex-wrap">
                                <div class="count-prd">Có <?php echo $count_product ?> sản phẩm</div>
                                <form method="get" class="form-order uk-flex uk-flex-middle">
                                    <select name="order_by" id="" class="form-control mr20" onchange="this.form.submit()">
                                        <option value="">-- Sắp xếp theo --</option>
                                        <option value="tb1.created_at desc" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'tb1.created_at desc' ? 'selected' : '' ?>>Sản phẩm mới nhất</option>
                                        <option value="tb1.created_at asc" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'tb1.created_at asc' ? 'selected' : '' ?>>Sản phẩm cũ nhất</option>
                                        <option value="tb1.price asc" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'tb1.price asc' ? 'selected' : '' ?>>Giá từ thấp đến cao</option>
                                        <option value="tb1.price desc" <?php echo isset($_GET['order_by']) && $_GET['order_by'] == 'tb1.price desc' ? 'selected' : '' ?>>Giá từ cao đến thấp</option>
                                    </select>
                                    <input type="text" class="form-control" onchange="this.form.submit()" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" placeholder="Nhập sản phẩm cần tìm">
                                </form>
                            </div>
                            <div class="medical-section-body">
                                <div class="uk-grid uk-grid-small">
                                    <?php if(isset($productList) && is_array($productList) && count($productList)){
                                        foreach ($productList as $value) {
                                    ?>
                                        <div class="uk-width-large-1-4 uk-width-1-2 mb10">
                                            <div class="medical-item product">
                                                <div class="item-pic">
                                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover product-media">
                                                        <img src="<?php echo $value['image'] ?>">
                                                    </a>
                                                    <div class="item-function">
                                                        <div class="uk-flex uk-flex-middle">
                                                            <div class="icon icon-img-action mr10">
                                                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                                    <img src="public/eye.png" alt="" class="p10">
                                                                </a>
                                                            </div>
                                                            <div class="icon icon-img-action mr10">
                                                                <a class="buy_now" data-id="<?php echo $value['id'] ?>" data-sku="SKU_<?php echo $value['id'] ?>">
                                                                    <img src="public/cart.png" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="icon icon-img-action" >
                                                                <a  data-id="<?php echo $value['id'] ?>" class="btn-wishlist">
                                                                    <i class="d-icon-heart"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item-text">
                                                    <div class="product-title product-name mb5">
                                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="limit-line-3 ">
                                                            <?php echo $value['title'] ?> <?php echo (!empty($value['model']) ? ' - Model: '.$value['model'] : '') ?> <?php echo (!empty($value['bar_code']) ? ' - Hãng: '.$value['bar_code'] : '') ?><?php echo (!empty($value['made_in']) ? ' - '.$value['made_in'] : '') ?>
                                                        </a>
                                                    </div>
                                                    <div class="product-star mb5">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="product-contact mb10 product-price">
                                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                                            <div class="prd-price uk-clearfix">
                                                                <span class="price-old uk-display-block "><?php echo empty($value['price_promotion']) ? '' : number_format(check_isset($value['price']),0,',','.').' VNĐ' ?></span>
                                                                <span class="price-new new-price"><?php echo (empty($value['price'] ) ? 'Liên hệ' : (!empty($value['price_promotion']) ? number_format(check_isset($value['price_promotion']),0,',','.').' VNĐ' : number_format(check_isset($value['price']),0,',','.').' VNĐ')) ?></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }} ?>
                                </div>
                                <div id="pagination">
                                    <?php echo (isset($pagination)) ? $pagination : ''; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
