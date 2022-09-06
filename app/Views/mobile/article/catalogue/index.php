<section class="va-articleCat-panel">
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb uk-clearfix mb30">
			<li class="breadcrumb-home"><a href=""> <i class="fa fa-home"></i> Trang chủ</a></li>
			<?php if(isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb)){
				foreach ($breadcrumb as $key => $value) {
			 ?>
				<li class=""><a href="<?php echo BASE_URL.check_isset($value['canonical']).HTSUFFIX ?>" ><span><?php echo check_isset($value['title']) ?></span></a></li>
			<?php }} ?>
		</ul>
		<div class="articleList">
			<div class="uk-grid uk-grid-medium uk-clearfix">
				
				<div class="uk-width-large-3-4">
					<section class="artcatalogue">
						<header class="panel-head mb30">
							<h1 class="heading-1">
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<a href="<?php echo check_isset($detailCatalogue['canonical']).HTSUFFIX ?>" title="Về Kim Liên Travel"><?php echo check_isset($detailCatalogue['title']) ?></a>
								</div>
							</h1>
						</header>
						<section class="panel-body">
							<ul class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-2 list-articles uk-clearfix" >
								<?php if(isset($articleList) && is_array($articleList) && count($articleList)){
									foreach ($articleList as $key => $value) {
								 ?>
									<li >
										<article class="article">
											<h3 class="title"><a href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="<?php echo check_isset($value['title']) ?>"><?php echo check_isset($value['title']) ?></a></h3>
											<div class="thumb">
												<a class="image img-cover" href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="<?php echo check_isset($value['title']) ?>"><img src="<?php echo check_isset($value['image']) ?>" alt="<?php echo check_isset($value['title']) ?>"></a>
											</div>
											<div class="infor">
												<div class="description">
													<?php echo check_isset(base64_decode($value['description'])) ?>										</div>
												<div class="uk-flex uk-flex-middle uk-flex-space-between meta">
													<div class="viewmore"><a href="<?php echo check_isset($value['canonical']).HTSUFFIX ?>" title="Xem thêm"><span>Xem thêm</span></a></div>
													<div class="social">
														<ul class="uk-list uk-clearfix">
															<li><a href="https://www.facebook.com/kimlientravel" title="Facebook" target="_blank">Facebook</a></li>
															<li><a href="https://twitter.com/KimLienChannel" title="Twitter" target="_blank">Twitter</a></li>
															<li><a href="https://plus.google.com/+KimLienTravel" title="Google" target="_blank">Google Plus</a></li>
															<li><a href="mailto: : info@kimlientravel.com.vn" title="Gmail">Gmail</a></li>
														</ul>
													</div>
												</div>
											</div>
										</article>
									</li>
								<?php }}else{ ?>
									<span class="text-danger mt30">Không có dữ liệu để hiển thị...</span>
								<?php } ?>
							</ul>
						</section>
						<div id="pagination" class="va-num-page">
	                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
	                    </div>
					</section>
				</div>
				<div class="uk-width-large-1-4 ">
					<?php echo view('mobile/homepage/common/aside') ?>
				</div>
			</div>
		</div>
	</div>
</section>