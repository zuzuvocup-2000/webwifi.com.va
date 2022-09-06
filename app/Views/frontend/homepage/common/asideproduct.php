<?php $banner_ads = get_slide(['keyword' => 'aside' , 'language' => $language ]); ?>
<?php
    $model = new App\Models\AutoloadModel();
    $mainNav = get_menu(['keyword' => 'menu-aside','language' => $language,'output' => 'array']);
    $product_love = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb1.price, tb1.price_promotion, tb1.model, tb1.bar_code, tb2.made_in',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
        ],
        'table' => 'product as tb1',
        'join' => [
            [
                'product_translate as tb2','tb2.module = "product" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.viewed desc'
    ], true);

    $article_love = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb2.description, tb1.created_at',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
            'tb1.hot' => 1,
        ],
        'table' => 'article as tb1',
        'join' => [
            [
                'article_translate as tb2','tb2.module = "article" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);
?>
<div class="side-content">
    <?php if(isset($mainNav['data']) && is_array($mainNav['data']) && count($mainNav['data'])){ ?>
        <div class="category-panel mb40">
            <header class="main-side-header">
                <div class="heading uk-flex uk-flex-middle">
                    <img src="public/shop.png" alt="shop" class="mr10">
                    Danh mục sản  phẩm
                </div>
            </header>
            <div class="panel-body">
                <ul class="category-list">
                    <?php foreach ($mainNav['data'] as $key => $value) { ?>
                        <li class="uk-flex uk-flex-middle">
                            <div class="category-icon">
                                <div class="img-scaledown img-transfer">
                                    <img src="public/transfer.png" alt="transfer">
                                </div>
                            </div>
                            <div class="category-text">
                                <a href="<?php echo $value['canonical'] ?>" class="home-text">
                                    <?php echo $value['title'] ?>
                                </a>
                            </div>
                        </li>
                        <?php if(isset($value['children']) && is_array($value['children']) && count($value['children'])){ ?>
                            <li class="list-child-cat">
                                <?php foreach ($value['children'] as $valuechild) { ?>
                                    <div class="list-child-item">
                                        <a href="<?php echo $valuechild['canonical'] ?>" class="home-text">
                                            <?php echo $valuechild['title'] ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($product_love) && is_array($product_love) && count($product_love)){ ?>
    <div class="best-saler-panel mb40 aside-products">
        <header class="main-side-header">
            <div class="heading uk-flex uk-flex-middle">
                <img src="public/bag.png" alt="shop" class="mr10">
                SẢn phẩm bán chạy
            </div>
        </header>
        <div class="panel-body">
            <?php foreach ($product_love as $value) { ?>
                <div class="best-saler-item product">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-large-2-5">
                            <div class="item-pic">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover">
                                    <img src="<?php echo $value['image'] ?>">
                                </a>
                            </div>
                        </div>
                        <div class="uk-width-large-3-5">
                            <div class="product-title">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                    <?php echo $value['title'] ?> <?php /*<?php echo (!empty($value['model']) ? ' - Model: '.$value['model'] : '') ?> <?php echo (!empty($value['bar_code']) ? ' - Hãng: '.$value['bar_code'] : '') ?><?php echo (!empty($value['made_in']) ? ' - '.$value['made_in'] : '') ?>*/ ?>
                                </a>
                            </div>
                            <div class="product-contact">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                    <div class="prd-price uk-clearfix">
                                        <span class="price-old uk-display-block "><?php echo empty($value['price_promotion']) ? '' : number_format(check_isset($value['price']),0,',','.').' VNĐ' ?></span>
                                        <span class="price-new"><?php echo (empty($value['price'] ) ? 'Liên hệ' : (!empty($value['price_promotion']) ? number_format(check_isset($value['price_promotion']),0,',','.').' VNĐ' : number_format(check_isset($value['price']),0,',','.').' VNĐ')) ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <?php if(isset($article_love) && is_array($article_love) && count($article_love)){ ?>
        <div class="best-news-panel mb40">
            <header class="main-side-header">
                <div class="heading uk-flex uk-flex-middle">
                    <img src="public/news_aside.png" alt="shop" class="mr10">
                    Tin tức nổi bật
                </div>
            </header>
            <div class="panel-body">
                <?php foreach ($article_love as $value) { ?>
                    <div class="best-news-item">
                        <div class="item-pic">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img img-cover">
                                <img src="<?php echo $value['image'] ?>">
                            </a>
                        </div>
                        <div class="product-title mb15">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>">
                                <?php echo $value['title'] ?>
                            </a>
                        </div>
                        <div class="date">
                            <?php echo date('d/m/Y', strtotime($value['created_at'])) ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($banner_ads) && is_array($banner_ads ) && count($banner_ads )){
        foreach ($banner_ads  as $key => $value) {
     ?>
        <div class="side-big-pic">
            <a href="<?php echo $value['canonical'] ?>" class="img img-cover">
                <img src="<?php echo $value['image'] ?>">
            </a>
        </div>
    <?php }} ?>
</div>