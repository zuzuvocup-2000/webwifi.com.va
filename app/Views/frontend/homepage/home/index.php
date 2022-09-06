<?php $main_slide = get_slide(['keyword' => 'main-slide' , 'language' => $language ]); ?>
<?php $category_img = get_slide(['keyword' => 'image-category' , 'language' => $language ]); ?>
<?php $quangcao = get_slide(['keyword' => 'quangcao' , 'language' => $language ]); ?>
<?php 
	$model = new App\Models\AutoloadModel();
    $product_news = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb1.price, tb1.price_promotion, tb1.model, tb1.bar_code, tb2.made_in, tb1.id',
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
        'limit' => 10,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);

    
?>
<div class="homepage">
	<?php if(isset($main_slide) && is_array($main_slide) && count($main_slide)){ ?>
	    <div class="home-slider-group">
	        <div class="container">
	            <div class="owl-carousel owl-theme custom-dots" id="js-home-slider">
	            	<?php foreach ($main_slide as $value) { ?>
		                <a href="<?php echo $value['canonical'] ?>"><img data-src="<?php echo $value['image'] ?>" alt="" width="1" height="1" class="owl-lazy" /></a>
		            <?php } ?>
	            </div>
	        </div>
	    </div>
	<?php } ?>
    <div class="container">
		<?php if(isset($category_img) && is_array($category_img) && count($category_img)){ ?>
	        <div class="home-banner-under-group hover-img d-flex flex-wrap">
            	<?php foreach ($category_img as $value) { ?>
            		<a href="<?php echo $value['canonical'] ?>"><img data-src="<?php echo $value['image'] ?>" alt="" width="1" height="1" class="lazy w-auto h-auto" /></a>
	            <?php } ?>
	        </div>
		<?php } ?>
	        <div class="home-deal-group" id="js-home-deal-container">
	            <p class="title"><span>DEALS HOT HÔM NAY</span></p>

	            <div class="p-container" id="js-home-deal-holder"><!-- // get featured deal --></div>

	            <!-- <a href="deal" class="btn-deal">Xem tất cả <i class="fas fa-angle-double-right"></i></a> -->
	        </div>
        <?php if(isset($product_news) && is_array($product_news) && count($product_news)){ ?>
            <div class="home-product-new-group">
                <p class="title"><span>SẢN PHẨM MỚI</span></p>

                <div class="p-container">
                    <?php foreach ($product_news as $value) { ?>
                        <?php echo view('frontend/homepage/core/product', ['value' => $value]) ?>
                    <?php } ?>
                </div>

                <!-- <a href="san-pham-moi" class="btn-new">Xem tất cả <i class="fas fa-angle-double-right"></i></a> -->
            </div>
        <?php } ?>
        <?php if(isset($quangcao) && is_array($quangcao) && count($quangcao)){ ?>
            <div class="home-banner-product-group d-flex flex-wrap justify-content-between hover-img">
                <?php foreach ($quangcao as $value) { ?>
                    <a href="<?php echo $value['canonical'] ?>"><img data-src="<?php echo $value['image'] ?>" alt="" width="1" height="1" class="lazy w-auto h-auto" /></a>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if(isset($product_catalogue) && is_array($product_catalogue) && count($product_catalogue)){
            foreach ($product_catalogue as $key => $value) {
        ?>
            <div class="home-box-group js-box-container" data-id="<?php echo $value['id'] ?>">
                <div class="box-title-group">
                    <div class="box-holder clearfix">
                        <h2 class="title"><?php echo $value['title'] ?></h2>
                        <?php if(isset($value['children']) && is_array($value['children']) && count($value['children'])){
                            foreach ($value['children'] as $keyChild => $valueChild) {
                         ?>
                            <a href="<?php echo $valueChild['canonical'].HTSUFFIX ?>"><h3><?php echo $valueChild['title'] ?></h3></a>
                        <?php }} ?>
                    </div>
                </div>

                <div class="p-container has-cat-image">
                    <div class="cat-image hover-img d-flex align-items-center" style="width: 245px;">
                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" target="_blank">
                            <img data-src="<?php echo $value['icon'] ?>" alt="<?php echo $value['title'] ?>" width="1" height="1" class="lazy w-auto h-auto" />
                        </a>
                    </div>

                    <div id="js-holder-<?php echo $value['id'] ?>"><!-- // Get Product Hot --></div>
                </div>

                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="btn-box">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
            </div>
        <?php }} ?>
    </div>
</div>