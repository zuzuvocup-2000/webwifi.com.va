<?php 
	$owlInit = [
		'margin' => 10,
	    'lazyload' => true,
	    'nav' => true,
	    'autoplay' => true,
	    'smartSpeed' => 1000,
	    'autoplayTimeout' => 3000,
	    'dots' => true,
	    'loop' => true,
	    'responsive' => array(
			0 => array(
				'items' => 1,
			),
			768 => array(
				'items' => 2,
			),
			960 => array(
				'items' => 3,
			),
		
		)
	]
 ?>
<?php $banner = get_slide(['keyword' => 'slide-home' , 'language' => $language, ]); ?>
<section id="body" class="mt5 mb5">
	<section class="uk-margin-bottom index-slide mb20">
		<div class="uk-container uk-container-center">
			<?php if(isset($banner) && is_array($banner) && count($banner)){ ?>
			<div class="uk-slidenav-position" data-uk-slideshow="{animation: 'scroll', autoplay: true, autoplayInterval: 5000}">
				<ul class="uk-slideshow">
					<?php foreach ($banner as $value) { ?>
					<li><a href="<?php echo $value['canonical'] ?>" title="<?php echo $value['title'] ?>" class="uk-display-block img-cover" ><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>" class="slide-img uk-width-1-1 "></a></li>
					<?php } ?>
				</ul>
				<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
				<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
				<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center mb20">
					<?php foreach ($banner as $key =>  $value) { ?>
					<li data-uk-slideshow-item="<?php echo $key ?>"><a href=""></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</section>
	<section class="wrap-product-home">
		<div class="uk-container uk-container-center">
			<div class="uk-grid uk-grid-medium uk-clearfix">
				<div class="uk-width-large-1-4">
					<div class="wrap">
						<div class="pr-category">
							<div class="pr-category-title flex-row row-between">Thể loại</div>
							<div class="pr-category-content">
								<?php if(isset($brandCatalogueList) && is_array($brandCatalogueList) && count($brandCatalogueList)){ ?>
									<?php foreach ($brandCatalogueList as $valueCat) { ?>
										<div class="pr-cg-item ">
											<div class="pr-cg-item-title <?php echo ($valueCat['canonical'] == $detailCatalogue['canonical'] ? 'pr-cg-item-has-bg' : '') ?>">
												<svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" class="injected-svg" data-src="/common-uiasset/svg/plus_square_o.svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 13px;height: 11px;"><path d="M12 11h-1v-1h1V1h-1V0h2v11h-1zM7 8H6V6H4V5h2V3h1v2h2v1H7v2zm-7 3V0h2v1H1v9h1v1H0z" fill-rule="evenodd"></path></svg>
												<a href="<?php echo $valueCat['canonical'].HTSUFFIX ?>"><?php echo $valueCat['title'] ?></a>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-large-3-4">
					<div class="wrap-grid">
						<div class="cal-home-article mb20">
							<nav class="breadcrumb-nav fc-breadcrumb mb15">
	                            <ul class="breadcrumb">
	                                <li>Trang chủ</a></li>
	                                <?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
	                                foreach ($breadcrumb as $value) {
	                                ?>
	                                <li><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
	                                <?php }} ?>
	                            </ul>
	                        </nav>
							<h2 class="cal-home-list-title"><?php echo $detailCatalogue['title'] ?></h2>
							<div class="home-part-list">
								<ul class="home-part-list-content home-brand-list-content">
									<?php if(isset($brandList) && is_array($brandList) && count($brandList)){ 
										foreach ($brandList as $key => $value) {
									?>
										<li>
											<a href="<?php echo $value['canonical'].HTSUFFIX ?>">
												<img alt="<?php echo $value['title'] ?>" src="<?php echo (!empty($value['image']) ? $value['image'] : $general['homepage_logo']) ?>" class="ab-lazy-image home-part-list-img" loading="lazy" style="opacity: 1;"> 
											</a>
											<a class="ab-ellipsis ab-ellipsis-line3 ab-ellipsis-m-line3 home-part-list-link" href="<?php echo $value['canonical'].HTSUFFIX ?>"><?php echo $value['title'] ?></a>
											<p class="popular-list-alias limit-line-1"><?php echo strip_tags(base64_decode($value['description'])) ?></p>
										</li>
									<?php }} ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</section>
</section>