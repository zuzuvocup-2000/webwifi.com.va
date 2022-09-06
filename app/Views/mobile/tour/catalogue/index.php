<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $footer = get_panel([
		'locate' => 'footer',
		'language' => $language
	]);
?>
<section class="va-articleCat-panel"  data-module="<?php echo check_isset($module); ?>" data-canonical="<?php echo check_isset($canonical); ?>">
	<div class="uk-container uk-container-center">
		<div class="tourList">
			<div class="uk-grid uk-grid-medium uk-clearfix">
				<div class="uk-width-large-1-4">
					<?php echo view('mobile/homepage/common/asidetour') ?>
				</div>
				<div class="uk-width-large-3-4">
					<section class="artcatalogue mb50">
						<ul class="uk-breadcrumb uk-clearfix mb30">
							<li class="breadcrumb-home"><a href=""> <i class="fa fa-home"></i> Trang chủ</a></li>
							<?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
								foreach ($breadcrumb as $key => $value) {
							 ?>
								<li class=""><a href="<?php echo BASE_URL.check_isset($value['canonical']).HTSUFFIX ?>" ><span><?php echo check_isset($value['title']) ?></span></a></li>
							<?php }} ?>
						</ul>
						<header class="panel-head mb30">
							<h1 class="heading-1">
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<a href="<?php echo check_isset($detailCatalogue['canonical']).HTSUFFIX ?>" title=""><?php echo check_isset($detailCatalogue['title']) ?></a>
								</div>
							</h1>
						</header>
						<section class="panel-body tour_list_panel">
							<ul class="list-tour-mobile" >
								<?php if(isset($tourList) && is_array($tourList) && count($tourList)){
									foreach ($tourList as $key => $value) {
								 ?>
									<li class="mb15">
										<article class="uk-flex tour-mobile">
											<div class="thumb img-zoomin mb20">
												<a class="image img-cover" href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="<?php echo check_isset($value['title']) ?>">
													<?php 
														$album = [];
														if($value['album'] != 'null' && $value['album'] != ''){
															$album =json_decode($value['album']);
														}
														$src = ($album == [] ? $general['homepage_logo'] : $album[0]);
														echo render_img($src,check_isset($value['title'])); 
													?>
													</a>
											</div>
											<div class="infor uk-flex">
												<div class="wrap-content-tour mr50">
													<h3 class="title mb10"><a href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="<?php echo check_isset($value['title']) ?>"><?php echo check_isset($value['title']) ?> </a></h3>
													<div class="star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</div>
													
													<div class="wrap-price isprice">
														<span class="old <?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? 'line-price' : '' ?>"><?php echo number_format(check_isset($value['price']),0,',','.') ?> đ</span>
														<span class="new" style="<?php echo (isset($value['price_promotion']) && $value['price_promotion'] != 0) ? '' : 'display: none;' ?>">
															<?php echo number_format(check_isset($value['price_promotion']),0,',','.') ?> đ
														</span>
													</div>
												</div>	
												<div class="order">
													<ul class="uk-list excerpt mb20">
														<li>Mã tour: <?php echo check_isset($value['tourid']) ?> </li>
														<li><i class="fa fa-clock-o"></i> Thời gian :<?php echo check_isset($value['number_days']) ?></li>
														<li><i class="fa fa-calendar"></i> <?php echo check_isset($value['day_start']) ?></li>
														<li><i class="fa fa-user"></i> Số chỗ: 20</li>
													</ul>
													<div class="viewmore">
														<a href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="<?php echo check_isset($value['title']) ?>">Chi tiết <i class="fa fa-angle-right"></i></a>
													</div>
												</div>
											</div>
										</article>
									</li>
								<?php }}else{ ?>
									<span class="text-danger mt30">Không có dữ liệu để hiển thị...</span>
								<?php } ?>
							</ul>
							<div id="pagination" class="va-num-page">
		                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
		                    </div>
						</section>
						<seciton class="tour_search_panel"></seciton>
					</section>
					<hr>
					<section class="tour_catalogue_description mt50">
						<strong>
							<?php echo check_isset($detailCatalogue['description']) ?>
						</strong>
						<?php echo check_isset($detailCatalogue['content']) ?>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>