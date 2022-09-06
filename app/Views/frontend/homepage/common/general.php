
<?php if(isset($panel['customer']) && is_array($panel['customer']) && count($panel['customer'])){ ?>

<section class="homepage-section order-1 mb-common">
	<div class="uk-container uk-container-center">
		<header class="panel-head">
			<h2 class="heading"><span><?php echo $panel['customer']['title']; ?></span></h2>
		</header>
		<?php if(isset($panel['customer']['data']) && is_array($panel['customer']['data']) && count($panel['customer']['data'])){ ?>
		<section class="panel-body">
			<div class="uk-panel-box" style="position: relative;">
				<div data-uk-slider>
					<div class="uk-slider-container">
						<ul class= "uk-slider uk-list uk-clearfix uk-grid lib-grid-20 uk-grid-width-small-1-2 uk-grid-width-medium-1-2 uk-grid-width-large-1-3 list-customer">
							<?php foreach ($panel['customer']['data'] as $keyPost => $valPost) { ?>
							<?php
								$title = $valPost['title'];
								$image = getthumb($valPost['image']);
								$href = write_url($valPost['canonical'], TRUE, TRUE);
								$description = cutnchar(strip_tags(base64_decode($valPost['description'])),500);
							?>
								<li>
									<div class="customer uk-clearfix">
										<div class="thumb"><span class="image"><?php echo render_img(['src' => $image]) ?></span></div>
										<div class="info">
											<div class="title uk-text-center"><span rel="nofollow" href="<?php echo $href; ?>" title="<?php echo $title; ?>" ><?php echo $title; ?></span></div>
											<p><?php echo $description; ?></p>
										</div>
									</div>
								</li>
							<?php }?>
						</ul>
					</div>
					<ul class="uk-dotnav uk-position-bottom uk-flex-center">
						<?php foreach ($panel['customer']['data'] as $keyPost => $valPost) {?>
						<li data-uk-slider-item="<?php echo $keyPost; ?>"><a href=""></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</section>
		<?php } ?>
	</div>
</section> <!--homepage-reg-->
<?php } ?>


<section class="homepage-section mb-common">
	<div class="uk-container uk-container-center">
		<header class="panel-head">
			<h2 class="heading"><span>Báo chí nói về chúng tôi</span></h2>
		</header>
		<section class="panel-body">
			<ul class="uk-grid uk-grid-medium uk-grid-width-1-3 uk-grid-width-large-1-6">
				<li><a rel="nofollow" target="_blank" rel="nofollow" href="http://afamily.vn/nha-hay/doi-gio-khong-gian-phong-khach-voi-bo-sofa-ghe-go-hien-dai-20160301113131161.chn" title="Afamily" class="img-scaledown"><?php echo render_img(['src' => '/upload/image/partner-1.png']) ?></a></li>
				<li><a rel="nofollow" href="http://news.zing.vn/bai-tri-phong-ngu-voi-noi-that-go-tu-nhien-post650451.html" rel="nofollow" target="_blank" title="Zing" class="img-scaledown"><?php echo render_img(['src' => '/upload/image/partner-2.png','alt' => 'bao-chi-noi-ve-noi-that-toan-ca']) ?></a></li>
			</ul>
		</section>
	</div>
</section> <!--homepage-news-->



<?php $partner = get_slide(['keyword' => 'partner','output' => 'array']); ?>
<?php if(isset($partner) && is_array($partner) && count($partner)){ ?>
<section class="homepage-section mb-common">
	<div class="uk-container uk-container-center">
		<header class="panel-head">
			<h2 class="heading-10"><span>Với đối tác là những hãng nguyên phụ kiện, thiết bị hàng đầu - Chúng tôi cam kết mang đến cho bạn những sản phẩm hoàn hảo nhất</span></h2>
		</header>
		<section class="panel-body">
			<ul class="uk-grid uk-grid-medium uk-grid-width-1-3 uk-grid-width-large-1-6">
				<?php foreach($partner['data'] as $key => $val){ ?>
				<li><a href="<?php echo $val['url']; ?>" title="<?php echo $val['title']; ?>" class="img-scaledown"><?php echo render_img(['src' => $val['image']]) ?></a></li>
				<?php } ?>
			</ul>
		</section>
	</div>
</section> <!--homepage-partner-->
<?php } ?>
