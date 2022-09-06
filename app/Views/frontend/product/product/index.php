<?php
    $model = new App\Models\AutoloadModel();
    $mainNav = get_menu(['keyword' => 'menu-aside','language' => $language,'output' => 'array']);
    $product_love = $model->_get_where([
        'select' => 'tb2.title, tb1.image, tb2.canonical, tb1.price, tb1.price_promotion, tb1.model, tb1.bar_code, tb2.made_in',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1,
            'tb1.hot' => 1,
        ],
        'table' => 'product as tb1',
        'join' => [
            [
                'product_translate as tb2','tb2.module = "product" AND tb2.objectid = tb1.id AND tb2.language = \''.$language.'\'', 'inner'
            ]
        ],
        'limit' => 5,
        'group_by' => 'tb1.id',
        'order_by' => 'tb1.created_at desc'
    ], true);
?>
<link href="templates/frontend/resources/plugins/lightslider-master/dist/css/lightslider.min.css" rel="stylesheet" />
<section class="bg-banner-top-new uk-position-relative bg-general" style="background-image: url(<?php echo $detailCatalogue['image'] ?>);">
    <div class="wrap-breadcum">
        <h2 class="heading-2 heading-cat-title">
            <?php echo $object['title'] ?>
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
	<div id="product-page" class="page-body pt50 pb50">
		<div class="uk-container uk-container-center">
			<div class="uk-grid uk-grid-medium uk-clearfix">
				<div class="uk-width-large-3-4">
					<div class="wrap-grid">
						<section class="prd-detail mb50 product">
							<section class="panel-body">
								<script>
								$(document).ready(function () {
								var wd_width = $(window).width();
								if (wd_width > 600) {
								$("#content-slider").lightSlider({
								loop: true,
								keyPress: true,
								});
								$("#image-gallery").lightSlider({
								gallery: true,
								item: 1,
								thumbItem: 5,
								slideMargin: 0,
								speed: 500,
								auto: true,
								loop: true,
								onSliderLoad: function () {
								$("#image-gallery").removeClass("cS-hidden");
								},
								});
								} else {
								$("#content-slider").lightSlider({
								loop: true,
								keyPress: true,
								});
								$("#image-gallery").lightSlider({
								gallery: true,
								item: 1,
								thumbItem: 3,
								slideMargin: 0,
								speed: 500,
								auto: true,
								loop: true,
								onSliderLoad: function () {
								$("#image-gallery").removeClass("cS-hidden");
								},
								});
								}
								});
								</script>
								<div class="uk-grid uk-grid-medium">
									<div class="uk-width-large-2-5">
										<div class="prd-gallerys">
											<div class="slider">
												<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
													<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
														foreach ($object['album'] as $key => $value) {
													?>
													<li data-thumb="<?php echo $value ?>">
														<a class="image img-scaledown" href="<?php echo $value ?>" title="" data-uk-lightbox="{group:'gallerys'}">
															<img src="<?php echo $value ?>" />
														</a>
													</li>
													<?php }} ?>
												</ul>
											</div>
										</div>
									</div>
									<div class="uk-width-large-3-5">
										<div class="prd-desc">
											<h1 class="prd-title product-name"><a href="<?php echo $object['canonical'].HTSUFFIX ?>"><?php echo $object['title'] ?> <?php echo (!empty($object['model']) ? ' - Model: '.$object['model'] : '') ?> <?php echo (!empty($object['bar_code']) ? ' - Hãng: '.$object['bar_code'] : '') ?><?php echo (!empty($object['made_in']) ? ' - '.$object['made_in'] : '') ?></a></h1>
											<div class="product-media uk-hidden">
												<img src="<?php echo $object['image'] ?>" alt="">
											</div>
											<div class="uk-flex uk-flex-middle uk-flex-space-between mb10 uk-flex-wrap">
												<div class="star-average">
                                                    <div class="text-left">
                                                        <span class="rating rating-prd"  style="display: inline-block;">
                                                            <?php
                                                                $number = 0;
                                                                if(isset($rate['total'])){
                                                                    $number = $rate['total'];
                                                                }
                                                                for ($i=1; $i <= round($number) ; $i++) {
                                                                    echo '<i class="star-rating-big fa fa-star" aria-hidden="true"></i>';
                                                                }
                                                                for ($i=1; $i <= 5-round($number) ; $i++) {
                                                                    echo '<i class="star-rating-big fa fa-star-o" aria-hidden="true"></i>';
                                                                }
                                                             ?>
                                                        </span>
                                                    </div>
                                                </div>
												<div class="prd-code "><span>Mã sản phẩm: <span class="uk-text-uppercase"><?php echo $object['productid'] ?></span></span></div>
												<div class="status-prd">Tình trạng: <span>Còn hàng</span></div>
											</div>
											<div class="prd-price uk-clearfix mb10 product-price">
												<span class="label">Giá: </span>
												<span class="prd-price-old "><?php echo empty($object['price_promotion']) ? '' : number_format(check_isset($object['price']),0,',','.').' VNĐ' ?></span>
												<span class="prd-price-new new-price"><?php echo (empty($object['price'] ) ? 'Liên hệ' : (!empty($object['price_promotion']) ? number_format(check_isset($object['price_promotion']),0,',','.').' VNĐ' : number_format(check_isset($object['price']),0,',','.').' VNĐ')) ?></span>
											</div>
											<div class="product-form product-qty default">
												<div class="product-form-group">
													<div class="input-group mr-2">
														<button class="quantity-minus d-icon-minus"></button>
														<input class="input_qty quantity form-control" type="number" min="1" max="1000000">
														<button class="quantity-plus d-icon-plus"></button>
													</div>
													<button data-id="<?php echo $object['id'] ?>" data-sku="SKU_<?php echo $object['id'] ?>" class="buy_now btn-product btn-cart text-normal ls-normal font-weight-semi-bold">
													<i class="d-icon-bag"></i> Thêm vào giỏ hàng
													</button>
												</div>
											</div>
											<hr>
											<div class="info-prd">
												<div class="info-prd-title mb10">
													Model: <span><?php echo $object['model'] ?></span>
												</div>
												<div class="info-prd-title mb10">
													Hãng: <span><?php echo $object['bar_code'] ?></span>
												</div>
												<div class="info-prd-title mb10">
													Xuất xứ: <span><?php echo $object['made_in'] ?></span>
												</div>
											</div>
											<hr>

											<div class="prd-description mb20">
												<?php echo strip_tags($object['description']) ?>
											</div>
											<div class="uk-grid uk-grid-medium uk-clearfix uk-grid-width-large-1-2">
												<div class="wrap-grid mb15">
													<a class="contact-prd uk-text-uppercase" href="<?php echo 'lien-he'.HTSUFFIX ?>">Liên hệ báo giá</a>
												</div>
												<div class="wrap-grid mb15">
													<a class="call-prd" href="tel:<?php echo $general['contact_hotline'] ?>"><?php echo $general['contact_hotline'] ?></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</section>
						<div class="tab tab-nav-simple product-tabs mb-4">
							<ul class="nav nav-tabs " role="tablist">
								<li class="nav-item">
									<a class="nav-link button-detail__product active button-detail__active uk-text-uppercase" data-active="box_1">Mô tả sản phẩm</a>
								</li>
								<?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){
									foreach ($object['sub_title'] as $key => $value) {
								?>
								<li class="nav-item">
									<a class="nav-link button-detail__product" data-active="article_<?php echo $key ?>"><?php echo $value ?></a>
								</li>
								<?php }} ?>
								<li class="nav-item">
									<a class="nav-link button-detail__product button-comments uk-text-uppercase" data-active="box_3">đánh giá sản phẩm</a>
								</li>
							</ul>
							<div class="">
								<div class="tab-pane tab-detail__product box_1 tab-detail__active in" id="product-tab-description">
									<div class="row mt-6">
										<div class="col-md-12">
											<div class="css-content product-body">
												<?php echo $object['description'] ?>
												<?php echo $object['content'] ?>
											</div>
										</div>
									</div>
								</div>
								<?php if(isset($object['sub_content']) && is_array($object['sub_content']) && count($object['sub_content'])){
									foreach ($object['sub_content'] as $key => $value) {
								?>
								<div class="css-content tab-pane tab-detail__product article_<?php echo $key ?>" id="product-tab-additional">
									<?php echo $value ?>
								</div>
								<?php }} ?>
								<div class="tab-pane tab-detail__product box_3" id="product-tab-reviews">
									<?php echo view('frontend/homepage/core/comment') ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-large-1-4">
					<div class="side-content">
						<div class="wrap-commit-aside mb50">
							<div class="uk-flex uk-flex-middle mb20">
								<div class="img-commit img-scaledown">
									<img src="public/king.png" alt="">
								</div>
								<div class="text-commit">
									<div class="title-commit">Bảo hành</div>
									<div class="commit-desc">
										Bảo hành lâu dài <br>Thời gian từ 1 - 3 năm
									</div>
								</div>
							</div>
							<div class="uk-flex uk-flex-middle mb20">
								<div class="img-commit img-scaledown">
									<img src="public/camket.png" alt="">
								</div>
								<div class="text-commit">
									<div class="title-commit">Cam kết sản phẩm</div>
									<div class="commit-desc">
										Sản phẩm như mẫu ảnh<br>Chính hãng 100%
									</div>
								</div>
							</div>
							<div class="uk-flex uk-flex-middle ">
								<div class="img-commit img-scaledown">
									<img src="public/hotro.png" alt="">
								</div>
								<div class="text-commit">
									<div class="title-commit">Hỗ trợ khách hàng 24/7</div>
									<div class="commit-desc">
										Hotline: 096.55.88.369<br>Email: truemed.jscvn@gmail.com
									</div>
								</div>
							</div>
						</div>
						<div class="register-contact-panel mb50">
							<div class="title-register-contact uk-text-center uk-text-uppercase">ĐĂNG KÝ TƯ VẤN</div>
							<div class="desc-regiter uk-text-center">(Kỹ thuật tư vấn, giải pháp tận nơi)</div>
							<div class="wrap-input-register">
								<div class="uk-flex uk-flex-middle">
									<input type="text" name="phone" placeholder="Nhập số điện thoại" class="form-control phone_contact_va">
									<button class="btn btn-submit-phone uk-text-uppercase contact_phone_va">Đăng ký</button>
								</div>
							</div>
						</div>
					    <?php if(isset($product_love) && is_array($product_love) && count($product_love)){ ?>
					    <div class="best-saler-panel mb40 aside-products">
					        <header class="main-side-header">
					            <div class="heading uk-flex uk-flex-middle">
					                <img src="public/bag.png" alt="shop" class="mr10">
					                Có thể bạn quan tâm
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
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="templates/frontend/resources/plugins/lightslider-master/dist/js/lightslider.min.js"></script>