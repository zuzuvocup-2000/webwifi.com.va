<div class="global-breadcrumb">
    <div class="container">
        <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="ul clearfix">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item" class="nopad-l">
                    <span itemprop="name" class="icons icon-home">Trang chủ</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
                foreach ($breadcrumb as $value) {
             ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" itemprop="item" class="nopad-l">
                        <span itemprop="name"><?php echo $value['title'] ?></span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
            <?php }} ?>
        </ol>
    </div>
</div>
<div class="product-detail-page container">
    <div class="pd-box-container pd-box-main-group d-flex flex-wrap text-13">
        <div class="pd-col-left">
            <div class="big-img-holder" id="js-big-img" data-id="js-fancybox-1">
                <img src="<?php echo isset($object['album'][0]) ? $object['album'][0] : '' ?>" alt="<?php echo $object['title'] ?>" class="fit-img" />
            </div>

            <div class="pd-img-gallery owl-carousel owl-theme" id="js-img-gallery">
            	<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
            		foreach ($object['album'] as $key => $value) {
            	 ?>
                <a href="javascript:void(0)" class="current" data-id="js-fancybox-<?php echo $key + 1 ?>" data-href="<?php echo $value ?>"><img src="<?php echo $value ?>" /></a>
                <?php }} ?>
            </div>

            <div>
            	<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
            		foreach ($object['album'] as $key => $value) {
            	 ?>
                <a href="<?php echo $value ?>" data-fancybox="gallery" data-thumb="<?php echo $value ?>" id="js-fancybox-<?php echo $key + 1 ?>"></a>
                <?php }} ?>
            </div>
        </div>

        <div class="pd-col-middle">
            <h1 class="pd-name"><?php echo $object['title'] ?></h1>

            <div class="pd-info-list text-12 font-300">
                <p>Mã SP: <span class="orange"><?php echo $object['productid'] ?></span></p>
                <p>Lượt xem: <span class="grey"><?php echo $object['viewed'] ?> lượt</span></p>
                <!-- <p>
                    <i class="icon-star star-0"></i>
                    <a href="javascript:void(0)" onclick="$('html, body').animate({scrollTop: $('#js-comment-block').offset().top - 80},800);" style="color: #55adff;">0 đánh giá</a>
                </p> -->
            </div>

            <div class="pd-summary-group">
                <div class="pd-summary-list" id="js-summary-list">
                    <?php echo $general['product_ship'] ?>
                </div>
            </div>
            <?php
			    $price = number_format($object['price_promotion'],0,',','.').' đ';
			    if ($object['price_promotion'] == 0) $price = "Liên hệ";

			    $marketPrice = "";
			    $discount = "";
			    if ($object['price'] > $object['price_promotion'] && $object['price_promotion'] > 0) {
			        $marketPrice = number_format($object['price'],0,',','.').' đ';
			        $percent = round((100 - ($object['price_promotion'] * 100) / $object['price']));
			        $discount = "<span class='pd-discount'> -" . $percent . "% </span>";
			    }
			?>
            <div class="pd-price-group">
                <table>
                    <tr>
                        <td width="110px">Giá niêm yết:</td>
                        <td>
                            <del class="pd-old-price"><?php echo $marketPrice ?></del>
                            <?php echo $discount ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="110px">Giá khuyến mại:</td>
                        <td>
                            <span class="pd-price"><?php echo $price ?></span>
                            <span class="pd-vat"> </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="pd-btn-group">
                <a href="javascript:void(0)" onclick="addProductToCart(<?php echo $object['id'] ?>, 1, '/gio-hang')">
                    <b>MUA NGAY</b>
                    <span>Giao hàng tận nơi</span>
                </a>

                <a href="javascript:void(0)" onclick="addProductToCart(<?php echo $object['id'] ?>, 1, '')">
                    <b>CHO VÀO GIỎ</b>
                    <span>Cho vào giỏ để chọn tiếp</span>
                </a>
            </div>
        </div>

        <div class="pd-col-right">
            <div class="pd-help-list">
                <?php echo $general['product_aside'] ?>
            </div>
        </div>
    </div>

    <div class="pd-info-container d-flex">
        <div class="pd-info-left-group">
            <div class="pd-box-container pd-desc-group js-static-container">
                <p class="box-title">MÔ TẢ SẢN PHẨM</p>
                <div style="padding: 12px;" class="js-static-content">
                	<?php echo $object['description'] ?>
                    <?php echo $object['content'] ?>
                </div>

                <div class="text-center btn-html-content p-4">
                    <a href="javascript:void(0)" class="js-showmore-button">Xem thêm <i class="fas fa-caret-right"></i></a>
                    <a href="javascript:void(0)" class="js-showless-button">Thu gọn <i class="fas fa-caret-down"></i></a>
                </div>
            </div>
        </div>

        <div class="pd-info-right-group">
        	<?php if(isset($product_general) && is_array($product_general) && count($product_general)){ ?>
	            <div class="pd-box-container pd-art-related-container">
	                <p class="box-title">Sản phẩm liên quan</p>

	                <div class="pd-art-holder pd-product-related-holder">
	                	<?php foreach ($product_general as $value) {  ?>
	                    <div class="item">
	                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="img">
	                            <img
	                                data-src="<?php echo $value['image'] ?>"
	                                alt="<?php echo $value['title'] ?>"
	                                class="lazy"
	                                src="<?php echo $general['homepage_logo'] ?>"
	                            />
	                        </a>
	                        <?php
							    $price = number_format($value['price_promotion'],0,',','.').' đ';
							    if ($value['price_promotion'] == 0) $price = "Liên hệ";

							    $marketPrice = "";
							    $discount = "";
							    if ($value['price'] > $value['price_promotion'] && $value['price_promotion'] > 0) {
							        $marketPrice = number_format($value['price'],0,',','.').' đ';
							        $percent = round((100 - ($value['price_promotion'] * 100) / $value['price']));
							        $discount = "<span class='p-discount'> -" . $percent . "% </span>";
							    }
							?>
	                        <div class="text">
	                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="name">
	                                <?php echo $value['title'] ?>
	                            </a>

	                            <div class="p-price-group">
	                                <span class="p-price">
	                                    <?php echo $price ?>
	                                </span>

	                                <span class="p-old-price"><?php echo $marketPrice ?></span>
	                                <?php echo $discount ?>
	                            </div>
	                            <a href="javascript:void(0)" class="p-item-btn icon-cart" onclick="addProductToCart(<?php echo $value['id'] ?>, 1, '')"></a>
	                        </div>
	                    </div>
	                    <?php } ?>
	                </div>
	            </div>
	        <?php } ?>
        </div>
    </div>
</div>
