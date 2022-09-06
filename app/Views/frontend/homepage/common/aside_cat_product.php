<?php $ads = get_slide(['keyword' => 'ads-article' , 'language' => $language, ]); ?>

<div class="sidebar-overlay">
    <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
</div>
<a href="#" class="sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
<div class="sidebar-content">
    <div class="sticky-sidebar" data-sticky-options="{'top': 89, 'bottom': 70}">
        <?php if(isset($panel['cat-product']['data']) && is_array($panel['cat-product']['data']) && count($panel['cat-product']['data'])){ ?>
            <div class="asidebox mb30">
                <h2 class="title-aside"><?php echo $panel['cat-product']['title'] ?></h2>
                <div class="aside-list">
                    <ul class="uk-clearfix uk-list">
                        <?php foreach ($panel['cat-product']['data'] as $key => $value) {  ?>
                            <li><a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="item-cat-product"><?php echo $value['title'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <?php if(isset($best_seller) && is_array($best_seller) && count($best_seller)){ ?>
            <div class="asidebox mb30">
                <h2 class="title-aside">Sản phẩm bán chạy</h2>
                <div class="aside-product">
                    <?php foreach ($best_seller as $key => $value) {  ?>
                        <div class="article-box mb10 uk-flex">
                            <div class="article-img">
                                <a class="img-cover" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo render_img(['src' => $value['image']]) ?></a>
                            </div>
                            <div class="article-content">
                                <a class="article-title" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a>
                                <div class="product-price" style="white-space: normal;">
                                    <label class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : '') ?></label>
                                    <span class="price"><?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0 ? number_format($value['price_promotion'], 0, ',', '.').'đ' : (isset($value['price']) && $value['price'] != 0 ? number_format($value['price'], 0, ',', '.').'đ' : 'Liên hệ')) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if(isset($panel['article-product']['data']) && is_array($panel['article-product']['data']) && count($panel['article-product']['data'])){ ?>
            <div class="asidebox">
                <h2 class="title-aside"><?php echo $panel['article-product']['title'] ?></h2>
                <div class="aside-article-hot">
                    <?php foreach ($panel['article-product']['data'] as $key => $value) { 
                        if($key == 5) break;
                    ?>
                        <div class="article-box mb15 uk-flex">
                            <div class="article-img uk-width-1-4">
                                <a class="img-cover" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                    <?php echo render_img(['src' => $value['image']]) ?>
                                </a>
                            </div>
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="article-content uk-width-3-4">
                                <?php echo $value['title'] ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>  
        <?php } ?>
        <?php if(isset($ads) && is_array($ads) && count($ads)){ ?>
            <div class="ads-article">
                <?php foreach ($ads as $value) { ?>
                    <a href="<?php echo $value['canonical'] ?>">
                        <?php echo render_img(['src' => $value['image']]) ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>