<section class="hot-deal-panel ">
	<div class="title-panel-general mb50">
		<div class="uk-flex uk-flex-middle uk-flex-center">
			<a href="" title="" class="mr10">
				<h2><?php echo ((isset($panel['hot-deals']['title'])) ? $panel['hot-deals']['title'] : '') ?></h2>
			</a>
			<span><img  class="" alt="Hot Deals" src="public/frontend/resources/img/icon/icon-tin-tuc.png"></span>
		</div>
	</div>
	<div class="uk-grid uk-grid-collapse uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-4 uk-clearfix">
		<?php
			if(isset($panel['hot-deals']['data']) &&is_array($panel['hot-deals']['data']) &&count($panel['hot-deals']['data'])){
				foreach ($panel['hot-deals']['data'] as $key => $value) {
					$value['avatar'] = ($value['avatar'] == '' ? $general['homepage_logo'] : $value['avatar']);
		?>
			<div class="wrap-hot-deal">
				<div class="hot-deal-body">
					<div class="hot-deal-img">
						<div class="hot-deal-time-end countdown" data-time="<?php echo check_isset($value['time_end']) ?>">
							<div class="value">Khuyến mãi còn 
								<span class="countdown" data-time="<?php echo check_isset($value['time_end']) ?>">
                                    <span class="time days"></span>
                                    <span class="smalltext">Ngày</span>
                                </span> 
                            </div>
							<span class="status-deal">Tour Hot</span>
						</div>
						<a href="<?php echo check_isset($value['canonical']) ?>" class="img-cover image img-zoomin">
							<?php echo render_img(check_isset($value['avatar']), check_isset($value['title'])) ?>
						</a>
					</div>
					<div class="hot-deal-content">
						<a href="<?php echo check_isset($value['canonical']) ?>" class="hot-deal-title mb10">
							<h3>
								<?php echo check_isset($value['title']) ?>
							</h3>
						</a>
						<div class="hot-deal-price uk-flex uk-flex-middle">
							<div class="old mr20 <?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? 'line-price' : '' ?>">
								<?php echo check_isset($value['price']) ?> đ
							</div>
							<div class="new" style="<?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? '' : 'display: none;' ?>">
								<?php echo check_isset($value['price_promotion']) ?> đ
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }} ?>
	</div>
</section>

<?php 
	if(isset($panel['tour-trong-nuoc']) && is_array($panel['tour-trong-nuoc']) && count($panel['tour-trong-nuoc'])){
 ?>
<section class="tour-category-panel ">
	<div class="uk-container uk-container-center">
		<div class="title-panel-general mb50">
			<div class="uk-flex uk-flex-middle uk-flex-center">
				<a href="" title="" class="mr10">
					<h2><?php echo ((isset($panel['tour-trong-nuoc']['title'])) ? $panel['tour-trong-nuoc']['title'] : '')  ?></h2>
				</a>
				<span><img  class="" alt="Hot Deals" src="public/frontend/resources/img/icon/icon-hanh-ly.png"></span>
			</div>
		</div>
		<div class="uk-grid uk-grid-medium uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-4 uk-clearfix">
			<?php
			if(isset($panel['tour-trong-nuoc']['data']) && is_array($panel['tour-trong-nuoc']['data']) && count($panel['tour-trong-nuoc']['data'])){
			$n=0;for($i = 0; $i < count($panel['tour-trong-nuoc']['data']) ; $i++){
					$panel['tour-trong-nuoc']['data'][$n]['avatar'] = ($panel['tour-trong-nuoc']['data'][$n]['avatar'] == '' ? $general['homepage_logo'] : $panel['tour-trong-nuoc']['data'][$n]['avatar']);

				?>
				<div class="wrap-tour-category">
					<div class="tour-category-body">
						<div class="tour-category-img">
							<a href="<?php echo ((isset($panel['tour-trong-nuoc']['data'][$n]['canonical'])) ? $panel['tour-trong-nuoc']['data'][$n]['canonical'] : '') ?>" class="img-cover img-zoomin">
								<?php echo render_img($panel['tour-trong-nuoc']['data'][$n]['avatar'],$panel['tour-trong-nuoc']['data'][$n]['title']) ?>
							</a>
						</div>
						<div class="tour-category-content">
							<a href="<?php echo ((isset($panel['tour-trong-nuoc']['data'][$n]['canonical'])) ? $panel['tour-trong-nuoc']['data'][$n]['canonical'] : '') ?>" class="tour-category-title">
								<?php echo ((isset($panel['tour-trong-nuoc']['data'][$n]['title'])) ? $panel['tour-trong-nuoc']['data'][$n]['title'] : '') ?>
							</a>
							<div class="uk-flex uk-flex-middle uk-flex-space-between" style="height: 50px;">
								<div class="tour-category-price">
									<div class="old mr20 <?php echo (isset($panel['tour-trong-nuoc']['data'][$n]['price_promotion']) && $panel['tour-trong-nuoc']['data'][$n]['price_promotion'] != 0) ? 'line-price' : '' ?>">
										<?php echo check_isset($panel['tour-trong-nuoc']['data'][$n]['price']) ?> đ
									</div>
									<div class="new" style="<?php echo (isset($panel['tour-trong-nuoc']['data'][$n]['price_promotion']) && $panel['tour-trong-nuoc']['data'][$n]['price_promotion'] != 0) ? '' : 'display: none;' ?>">
										<?php echo check_isset($panel['tour-trong-nuoc']['data'][$n]['price_promotion']) ?> đ
									</div>
								</div>
								<a class="btn btn-view" href="<?php echo ((isset($panel['tour-trong-nuoc']['data'][$n]['canonical'])) ? $panel['tour-trong-nuoc']['data'][$n]['canonical'] : '') ?>" title="Xem Ngay">
									Xem ngay
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php $n++; }}  ?>
		</div>
		<?php echo render_a(BASE_URL.$panel['tour-trong-nuoc']['keyword'].HTSUFFIX, $panel['tour-trong-nuoc']['title'],'class="btn-view-all btn"','xem đầy đủ các tour hot') ?>
	</div>
</section>
<?php } ?>
<?php
	$owlInit = array(
		'margin' => 30,
		'loop' => true,
		'nav' => true,
		'dots' => false,
		'autoplay' => true,
		'autoplayTimeout' => 3000,
		'responsiveClass' =>true,
		'responsive' => array(
			0 => array(
				'items' => 1,
				'nav' => false
			),
			769 => array(
				'items' => 2,
				'nav' => false
			)
		)
	);
?>
<?php if(isset($panel['feedback']) && is_array($panel['feedback']) && count($panel['feedback'])){ ?>
	<section class="customer-panel " style="background-image: url(upload/image/a/bg-3.gif);">
		<div class="uk-container uk-container-center">
			<div class="text-center mb50 va-zindex">
				<div class="customer-title ">
					<h2>
						<?php echo check_isset($panel['feedback']['description']) ?>
					</h2>
				</div>
				<p class="customer-text"><?php echo check_isset($panel['feedback']['content']) ?></p>
			</div>
			<div class="customer-slide ">
				<div class="owl-slide">
					<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
						<?php if(isset($panel['feedback']['data']) && is_array($panel['feedback']['data']) && count($panel['feedback']['data'])){
							foreach ($panel['feedback']['data'] as $key => $value) {
						 ?>
							<div class="wrap-customer-row">
								<div class="customer-wrap">
									<div class="uk-flex uk-flex-middle">
										<a href="" class="img-customer img-cover mr30">
											<?php echo render_img(check_isset($value['avatar']), check_isset($value['title'])) ?>
										</a>
										<div class="customer-name mr30">
											<?php echo check_isset($value['title']) ?>
										</div>
										<div class="customer-job">
											<?php echo check_isset($value['description']) ?>
										</div>
									</div>
									<div class="customer-content">
										<div class="customer-cmt">
											<?php echo check_isset($value['content']) ?>
										</div>
									</div>
								</div>
							</div>
						<?php  }} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

<?php
	$owlInit = array(
		'items' =>  3,
		'margin' => 30,
		'loop' => true,
		'nav' => false,
		'dots' => true,
		'autoplay' => true,
		'autoplayTimeout' => 3000,
		'responsiveClass' =>true,
		'responsive' => array(
			0 => array(
				'items' => 1,
				'nav' => false
			),
			500 => array(
				'items' => 2,
				'nav' => false
			),
			1024 => array(
				'items' => 3,
				'nav' => false
			),
		)
	);
?>

<section class="blog-panel ">
	<div class="uk-container uk-container-center">
		<div class="title-panel-general mb50">
			<div class="uk-flex uk-flex-middle uk-flex-center">
				<a href="" title="" class="mr10">
					<h2><?php echo ((isset($panel['tin-tuc']['title'])) ? $panel['tin-tuc']['title'] : '')  ?></h2>
				</a>
				<span><img  class="" alt="Hot Deals" src="public/frontend/resources/img/icon/icon-hanh-ly.png"></span>
			</div>
		</div>
		<div class="blog-slide">
			<div class="owl-slide">
				<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
					<?php
					if(isset($panel['tin-tuc']['data']) && is_array($panel['tin-tuc']['data']) && count($panel['tin-tuc']['data'])){
					$m=0;for($i = 0; $i < count($panel['tin-tuc']['data']) ; $i++){?>
						<div class="wrap-blog-slide">
							<div class="blog-slide-body">
								<div class="blog-overlay"></div>
								<a href="<?php echo ((isset($panel['tin-tuc']['data'][$m]['canonical'])) ? $panel['tin-tuc']['data'][$m]['canonical'] : '') ?>" class="blog-img img-cover">
									<?php echo render_img($panel['tin-tuc']['data'][$m]['avatar'],$panel['tin-tuc']['data'][$m]['title']) ?>
								</a>
								<div class="blog-time">
									2020
								</div>
								<div class="blog-slide-content">
									<a href="<?php echo ((isset($panel['tin-tuc']['data'][$m]['canonical'])) ? $panel['tin-tuc']['data'][$m]['canonical'] : '') ?>" class="blog-slide-title ">
										<?php echo ((isset($panel['tin-tuc']['data'][$m]['title'])) ? $panel['tin-tuc']['data'][$m]['title'] : '') ?>
									</a>
									<hr>
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<div class="blog-slide-view">
											<i class="fa fa-eye mr10" aria-hidden="true"></i>123 lượt xem
										</div>
										<a href="" class="btn-rating">
											<i class="fa fa-heart-o" aria-hidden="true"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php $m++; }}  ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="video-panel " style="background:url(public/frontend/resources/img/banner/banner-trafic-4.png)">
	<?php if(isset($panel['video']['data']) &&is_array($panel['video']['data']) &&count($panel['video']['data'])){
		foreach ($panel['video']['data'] as $key => $value) {
	?>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium uk-grid-width-medium-1-1 uk-grid-width-large-1-2 uk-clearfix">
			<div class="wrap-video-content">
				<div class="video-content">
					<h3 class="heading-2"><?php echo check_isset($value['title']) ?></h3>
					<div class="description">
						<?php echo check_isset($value['description']) ?>
					</div>
					<div class="readmore">
						<a href="<?php echo check_isset($value['canonical']) ?>" title="<?php echo check_isset($value['title']) ?>">Xem thêm</a>
					</div>
				</div>
			</div>
			<div class="wrap-video">
				<div class="video-popup">
					<a class="btn-modal-general" href="#modal-video">
						<?php echo render_img(check_isset($value['avatar']), check_isset($value['title']), ''); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php }} ?>
</section>

<?php
	$owlInit = array(
		'items' =>  3,
		'margin' => 30,
		'loop' => true,
		'nav' => false,
		'dots' => false,
		'autoplay' => true,
		'autoplayTimeout' => 3000,
		'responsiveClass' =>true,
		'responsive' => array(
			0 => array(
				'items' => 3,
				'nav' => false
			),
			500 => array(
				'items' => 5,
				'nav' => false
			),
			1024 => array(
				'items' => 8,
				'nav' => false
			),
		)
	);
?>

<section class="slide-company-panel p30 ">
	<div class="uk-container uk-container-center">
		<h2 style="display: none">Slide company</h2>
		<div class="owl-slide">
			<div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>" data-disabled="0">
				<?php if(isset($slide_company) && is_array($slide_company) && count($slide_company)){
					foreach ($slide_company['data'] as $key => $value) {
				 ?>
					<div class="slide-company">
						<div class="slide-company-body">
							<a href="<?php echo $value['url'] ?>" class="img-scaledown image">
								<?php echo render_img($value['image'],$value['title']) ?>
							</a>
						</div>
					</div>
				<?php }} ?>
			</div>
		</div>
	</div>
</section>

<?php if(isset($panel['video']['data']) &&is_array($panel['video']['data']) &&count($panel['video']['data'])){ 
	foreach ($panel['video']['data'] as $key => $value) {
?>
	<div id="modal-video" class="modal">
		<div class="modal-content-review ">
			<?php echo check_isset($value['iframe']); ?>
		</div>
	</div>
<?php }} ?>
